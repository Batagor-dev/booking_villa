<?php

namespace Tests\Feature;

use App\Exceptions\GeminiAuthException;
use App\Exceptions\GeminiConnectionException;
use App\Exceptions\GeminiQuotaExceededException;
use App\Services\GeminiTranslationService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeminiTranslationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::set('gemini.api_key', 'test-valid-api-key-12345');
        Config::set('gemini.model', 'gemini-1.5-flash');
        Config::set('gemini.timeout', 5);
        Config::set('gemini.retry_times', 0);
    }

    public function test_service_provider_is_registered_in_container(): void
    {
        $service = app(GeminiTranslationService::class);
        $this->assertInstanceOf(GeminiTranslationService::class, $service);
        $this->assertTrue($service->isConfigured());
    }

    public function test_successful_single_translation(): void
    {
        Http::fake([
            '*generativelanguage.googleapis.com*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Luxury Villa with Private Pool']
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $service = new GeminiTranslationService();
        $result = $service->translate('Villa Mewah dengan Kolam Renang Pribadi', 'en', 'id');

        $this->assertTrue($result['success']);
        $this->assertEquals('Luxury Villa with Private Pool', $result['data']);
        $this->assertNull($result['error']);
        $this->assertNull($result['error_type']);
    }

    public function test_successful_batch_translation(): void
    {
        $batchResponse = [
            'name' => 'Sunset Beach Villa',
            'description' => '<p>Beautiful villa near the beach.</p>',
            'city' => 'Badung'
        ];

        Http::fake([
            '*generativelanguage.googleapis.com*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => json_encode($batchResponse)]
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $service = new GeminiTranslationService();
        $input = [
            'name' => 'Villa Pantai Sunset',
            'description' => '<p>Villa cantik dekat pantai.</p>',
            'city' => 'Badung'
        ];

        $result = $service->translateBatch($input, 'en', 'id');

        $this->assertTrue($result['success']);
        $this->assertIsArray($result['data']);
        $this->assertEquals('Sunset Beach Villa', $result['data']['name']);
        $this->assertEquals('<p>Beautiful villa near the beach.</p>', $result['data']['description']);
        $this->assertEquals('Badung', $result['data']['city']);
    }

    public function test_quota_exceeded_error_handling_returns_structured_failure(): void
    {
        Http::fake([
            '*generativelanguage.googleapis.com*' => Http::response([
                'error' => [
                    'code' => 429,
                    'message' => 'Quota exceeded for quota metric GenerateContentRequests',
                    'status' => 'RESOURCE_EXHAUSTED'
                ]
            ], 429)
        ]);

        $service = new GeminiTranslationService();
        $result = $service->translate('Selamat datang', 'en', 'id');

        $this->assertFalse($result['success']);
        $this->assertNull($result['data']);
        $this->assertEquals('quota', $result['error_type']);
        $this->assertEquals(429, $result['code']);
        $this->assertStringContainsString('Batas kuota/token Gemini API telah habis', $result['error']);
    }

    public function test_translate_or_fail_throws_quota_exception(): void
    {
        Http::fake([
            '*generativelanguage.googleapis.com*' => Http::response([
                'error' => [
                    'code' => 429,
                    'message' => 'Quota exceeded',
                    'status' => 'RESOURCE_EXHAUSTED'
                ]
            ], 429)
        ]);

        $this->expectException(GeminiQuotaExceededException::class);

        $service = new GeminiTranslationService();
        $service->translateOrFail('Selamat datang', 'en', 'id');
    }

    public function test_connection_timeout_error_handling(): void
    {
        Http::fake([
            '*generativelanguage.googleapis.com*' => function () {
                throw new ConnectionException('cURL error 28: Connection timed out');
            }
        ]);

        $service = new GeminiTranslationService();
        $result = $service->translate('Halo', 'en', 'id');

        $this->assertFalse($result['success']);
        $this->assertEquals('connection', $result['error_type']);
        $this->assertStringContainsString('Gagal terhubung ke Google Gemini API', $result['error']);
    }

    public function test_translate_or_fail_throws_connection_exception(): void
    {
        Http::fake([
            '*generativelanguage.googleapis.com*' => function () {
                throw new ConnectionException('cURL error 28: Connection timed out');
            }
        ]);

        $this->expectException(GeminiConnectionException::class);

        $service = new GeminiTranslationService();
        $service->translateOrFail('Halo', 'en', 'id');
    }

    public function test_invalid_api_key_auth_error_handling(): void
    {
        Http::fake([
            '*generativelanguage.googleapis.com*' => Http::response([
                'error' => [
                    'code' => 400,
                    'message' => 'API key not valid. Please pass a valid API key.',
                    'status' => 'INVALID_ARGUMENT'
                ]
            ], 400)
        ]);

        $service = new GeminiTranslationService();
        $result = $service->translate('Halo dunia', 'en', 'id');

        $this->assertFalse($result['success']);
        $this->assertEquals('auth', $result['error_type']);
        $this->assertEquals(400, $result['code']);
        $this->assertStringContainsString('Gemini API Key tidak valid', $result['error']);
    }

    public function test_missing_api_key_fails_with_auth_error(): void
    {
        Config::set('gemini.api_key', null);

        $service = new GeminiTranslationService();
        $this->assertFalse($service->isConfigured());

        $result = $service->translate('Halo dunia', 'en', 'id');
        $this->assertFalse($result['success']);
        $this->assertEquals('auth', $result['error_type']);
        $this->assertStringContainsString('GEMINI_API_KEY belum disetel', $result['error']);
    }
}
