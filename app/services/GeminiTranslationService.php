<?php

namespace App\Services;

use App\Exceptions\GeminiAuthException;
use App\Exceptions\GeminiConnectionException;
use App\Exceptions\GeminiQuotaExceededException;
use App\Exceptions\GeminiTranslationException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class GeminiTranslationService
{
    protected ?string $apiKey;
    protected string $model;
    protected string $baseUrl;
    protected int $timeout;
    protected int $retryTimes;
    protected int $retrySleepMs;
    protected array $localesMap;

    public function __construct()
    {
        $this->apiKey = config('gemini.api_key');
        $this->model = config('gemini.model', 'gemini-1.5-flash');
        $this->baseUrl = rtrim(config('gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta'), '/');
        $this->timeout = (int) config('gemini.timeout', 15);
        $this->retryTimes = (int) config('gemini.retry_times', 2);
        $this->retrySleepMs = (int) config('gemini.retry_sleep_ms', 500);
        $this->localesMap = config('gemini.locales_map', [
            'id' => 'Indonesian',
            'en' => 'English',
            'zh' => 'Simplified Chinese',
            'ja' => 'Japanese',
            'ru' => 'Russian',
            'ar' => 'Arabic',
            'fr' => 'French',
            'de' => 'German',
            'es' => 'Spanish',
        ]);
    }

    /**
     * Check whether Gemini API key is properly configured.
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey) && trim($this->apiKey) !== '';
    }

    /**
     * Translate single text returning a safe result array without throwing exceptions.
     *
     * @return array{success: bool, data: string|null, error: string|null, error_type: string|null, code: int|null}
     */
    public function translate(string $text, string $targetLocale, ?string $sourceLocale = null): array
    {
        if (trim($text) === '') {
            return [
                'success' => true,
                'data' => $text,
                'error' => null,
                'error_type' => null,
                'code' => 200,
            ];
        }

        try {
            $translated = $this->translateOrFail($text, $targetLocale, $sourceLocale);

            return [
                'success' => true,
                'data' => $translated,
                'error' => null,
                'error_type' => null,
                'code' => 200,
            ];
        } catch (GeminiQuotaExceededException $e) {
            Log::warning('Gemini Quota Exceeded during translation', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'data' => null,
                'error' => $e->getMessage(),
                'error_type' => 'quota',
                'code' => 429,
            ];
        } catch (GeminiConnectionException $e) {
            Log::warning('Gemini Connection Error during translation', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'data' => null,
                'error' => $e->getMessage(),
                'error_type' => 'connection',
                'code' => $e->getCode() ?: 0,
            ];
        } catch (GeminiAuthException $e) {
            Log::error('Gemini Auth / API Key Error', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'data' => null,
                'error' => $e->getMessage(),
                'error_type' => 'auth',
                'code' => $e->getCode() ?: 401,
            ];
        } catch (Throwable $e) {
            Log::error('Gemini General Translation Error', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'data' => null,
                'error' => $e->getMessage(),
                'error_type' => 'general',
                'code' => (int) $e->getCode() ?: 500,
            ];
        }
    }

    /**
     * Translate single text and throw typed exceptions on failure.
     *
     * @throws GeminiAuthException
     * @throws GeminiQuotaExceededException
     * @throws GeminiConnectionException
     * @throws GeminiTranslationException
     */
    public function translateOrFail(string $text, string $targetLocale, ?string $sourceLocale = null): string
    {
        if (trim($text) === '') {
            return $text;
        }

        $sourceLang = $sourceLocale ? $this->resolveLanguageName($sourceLocale) : 'auto-detected source language';
        $targetLang = $this->resolveLanguageName($targetLocale);

        $prompt = "You are a professional multilingual translator for a hospitality & villa rental platform.\n"
            . "Translate the following text from {$sourceLang} into natural, polished {$targetLang}.\n"
            . "Rules:\n"
            . "- Maintain all original formatting, paragraphs, markdown, and HTML tags intact if present.\n"
            . "- Preserve brand names, proper nouns, currency symbols, and numbers.\n"
            . "- Output ONLY the translated text. Do not add markdown quotes, preamble, notes, or explanations.\n\n"
            . "Text to translate:\n" . $text;

        $response = $this->callGeminiApi([
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.2,
            ]
        ]);

        $translated = $this->extractCandidateText($response);

        return trim($translated);
    }

    /**
     * Batch translate an associative array of fields (e.g. ['name' => '...', 'description' => '...'])
     * in a single Gemini API request using structured JSON.
     *
     * @param array<string, string|null> $fields
     * @return array{success: bool, data: array<string, string>|null, error: string|null, error_type: string|null, code: int|null}
     */
    public function translateBatch(array $fields, string $targetLocale, ?string $sourceLocale = null): array
    {
        if (empty($fields)) {
            return [
                'success' => true,
                'data' => [],
                'error' => null,
                'error_type' => null,
                'code' => 200,
            ];
        }

        try {
            $translated = $this->translateBatchOrFail($fields, $targetLocale, $sourceLocale);

            return [
                'success' => true,
                'data' => $translated,
                'error' => null,
                'error_type' => null,
                'code' => 200,
            ];
        } catch (GeminiQuotaExceededException $e) {
            Log::warning('Gemini Quota Exceeded during batch translation', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'data' => null,
                'error' => $e->getMessage(),
                'error_type' => 'quota',
                'code' => 429,
            ];
        } catch (GeminiConnectionException $e) {
            Log::warning('Gemini Connection Error during batch translation', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'data' => null,
                'error' => $e->getMessage(),
                'error_type' => 'connection',
                'code' => $e->getCode() ?: 0,
            ];
        } catch (GeminiAuthException $e) {
            Log::error('Gemini Auth Error during batch translation', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'data' => null,
                'error' => $e->getMessage(),
                'error_type' => 'auth',
                'code' => $e->getCode() ?: 401,
            ];
        } catch (Throwable $e) {
            Log::error('Gemini General Batch Translation Error', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'data' => null,
                'error' => $e->getMessage(),
                'error_type' => 'general',
                'code' => (int) $e->getCode() ?: 500,
            ];
        }
    }

    /**
     * Batch translate an associative array of fields and throw typed exceptions on failure.
     *
     * @param array<string, string|null> $fields
     * @return array<string, string>
     *
     * @throws GeminiAuthException
     * @throws GeminiQuotaExceededException
     * @throws GeminiConnectionException
     * @throws GeminiTranslationException
     */
    public function translateBatchOrFail(array $fields, string $targetLocale, ?string $sourceLocale = null): array
    {
        if (empty($fields)) {
            return [];
        }

        $sourceLang = $sourceLocale ? $this->resolveLanguageName($sourceLocale) : 'auto-detected source language';
        $targetLang = $this->resolveLanguageName($targetLocale);

        // Filter out null or empty values while keeping track of keys
        $nonEmptyFields = array_filter($fields, fn($val) => !is_null($val) && trim((string)$val) !== '');

        if (empty($nonEmptyFields)) {
            return $fields;
        }

        $jsonPayload = json_encode($nonEmptyFields, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $prompt = "You are a professional multilingual translator for a hospitality & villa rental platform.\n"
            . "Translate the values of the following JSON key-value dictionary from {$sourceLang} into natural, polished {$targetLang}.\n"
            . "Rules:\n"
            . "- Keep the EXACT same JSON keys unchanged.\n"
            . "- Translate only the string values.\n"
            . "- Maintain all HTML tags, markup, formatting, brand names, and currency figures within the values.\n"
            . "- Respond strictly with valid JSON only matching the input keys.\n\n"
            . "JSON Input:\n" . $jsonPayload;

        $response = $this->callGeminiApi([
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.1,
                'responseMimeType' => 'application/json',
            ]
        ]);

        $rawJson = $this->extractCandidateText($response);

        // Strip markdown backticks if Gemini wrapped json in ```json ... ```
        $cleanJson = trim(preg_replace('/^```(?:json)?\s*|\s*```$/i', '', trim($rawJson)));

        $decoded = json_decode($cleanJson, true);

        if (!is_array($decoded)) {
            throw new GeminiTranslationException("Gemini mengembalikan format JSON yang tidak valid: " . substr($rawJson, 0, 200));
        }

        // Merge translated values back with original keys
        $result = $fields;
        foreach ($decoded as $key => $translatedValue) {
            if (array_key_exists($key, $result)) {
                $result[$key] = is_string($translatedValue) ? trim($translatedValue) : $translatedValue;
            }
        }

        return $result;
    }

    /**
     * Resolve human language name from locale code (e.g. 'en' => 'English').
     */
    public function resolveLanguageName(string $locale): string
    {
        $normalized = strtolower(trim($locale));
        return $this->localesMap[$normalized] ?? ucfirst($normalized);
    }

    /**
     * Low-level HTTP call to Gemini API with robust error handling and classification.
     *
     * @throws GeminiAuthException
     * @throws GeminiQuotaExceededException
     * @throws GeminiConnectionException
     * @throws GeminiTranslationException
     */
    protected function callGeminiApi(array $payload): array
    {
        if (!$this->isConfigured()) {
            throw new GeminiAuthException("GEMINI_API_KEY belum disetel di file .env. Silakan dapatkan API key di https://aistudio.google.com/.", 401);
        }

        $endpoint = "{$this->baseUrl}/models/{$this->model}:generateContent";

        try {
            $httpClient = Http::timeout($this->timeout)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ]);

            if ($this->retryTimes > 0) {
                $httpClient = $httpClient->retry(
                    $this->retryTimes,
                    $this->retrySleepMs,
                    function (Throwable $exception) {
                        // Only retry on network / connection timeout errors
                        return $exception instanceof ConnectionException;
                    },
                    throw: false
                );
            }

            $response = $httpClient->post("{$endpoint}?key={$this->apiKey}", $payload);
        } catch (ConnectionException $e) {
            throw new GeminiConnectionException(
                "Gagal terhubung ke Google Gemini API (Network Timeout / DNS / Disconnected): " . $e->getMessage(),
                0,
                $e
            );
        } catch (Throwable $e) {
            throw new GeminiConnectionException(
                "Gagal melakukan koneksi ke Google Gemini API: " . $e->getMessage(),
                0,
                $e
            );
        }

        if ($response->successful()) {
            return $response->json() ?? [];
        }

        $status = $response->status();
        $errorBody = $response->json('error') ?? [];
        $errorMessage = $errorBody['message'] ?? $response->body();
        $errorStatus = $errorBody['status'] ?? '';

        // Classify Quota / Token Exhausted (429 or RESOURCE_EXHAUSTED)
        if ($status === 429 || $errorStatus === 'RESOURCE_EXHAUSTED' || stripos($errorMessage, 'quota') !== false || stripos($errorMessage, 'rate limit') !== false) {
            throw new GeminiQuotaExceededException(
                "Batas kuota/token Gemini API telah habis (HTTP 429 - Quota Exceeded): {$errorMessage}",
                $status,
                null,
                $errorBody
            );
        }

        // Classify Authentication / API Key errors (400 / 401 / 403)
        if (in_array($status, [400, 401, 403]) && (stripos($errorMessage, 'API_KEY_INVALID') !== false || stripos($errorMessage, 'API key not valid') !== false || stripos($errorMessage, 'PERMISSION_DENIED') !== false || $errorStatus === 'PERMISSION_DENIED' || $errorStatus === 'INVALID_ARGUMENT')) {
            throw new GeminiAuthException(
                "Gemini API Key tidak valid atau ditolak (HTTP {$status}): {$errorMessage}",
                $status,
                null,
                $errorBody
            );
        }

        // Generic API failure
        throw new GeminiTranslationException(
            "Gemini API Error (HTTP {$status}): {$errorMessage}",
            $status,
            null,
            $errorBody
        );
    }

    /**
     * Extract candidate text from Gemini response structure.
     *
     * @throws GeminiTranslationException
     */
    protected function extractCandidateText(array $response): string
    {
        $candidate = $response['candidates'][0] ?? null;

        if (!$candidate) {
            $blockReason = $response['promptFeedback']['blockReason'] ?? 'Unknown Reason';
            throw new GeminiTranslationException("Tidak ada teks terjemahan yang dihasilkan Gemini (Blokir: {$blockReason}).");
        }

        $parts = $candidate['content']['parts'] ?? [];
        $text = '';
        foreach ($parts as $part) {
            if (isset($part['text'])) {
                $text .= $part['text'];
            }
        }

        if (trim($text) === '') {
            $finishReason = $candidate['finishReason'] ?? 'EMPTY';
            throw new GeminiTranslationException("Hasil terjemahan Gemini kosong (Finish reason: {$finishReason}).");
        }

        return $text;
    }
}
