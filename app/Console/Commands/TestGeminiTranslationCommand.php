<?php

namespace App\Console\Commands;

use App\Services\GeminiTranslationService;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class TestGeminiTranslationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gemini:test-translate
                            {--text= : Teks yang ingin diterjemahkan}
                            {--from=id : Bahasa sumber (contoh: id, en)}
                            {--to=en : Bahasa target (contoh: en, id)}
                            {--batch : Uji coba batch translation (banyak field sekaligus)}
                            {--mock-error= : Simulasi error tertentu (pilihan: quota, connection, auth)}
                            {--mock-success : Simulasi respons sukses tanpa memanggil real Google API}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uji coba sistem Gemini Auto-Translation, status koneksi, dan simulasi error handling (quota habis, network down, auth error)';

    /**
     * Execute the console command.
     */
    public function handle(GeminiTranslationService $translator): int
    {
        $this->info('===========================================================');
        $this->info('        🚀 GEMINI AUTO-TRANSLATION TEST SUITE            ');
        $this->info('===========================================================');

        $mockError = $this->option('mock-error');
        $mockSuccess = $this->option('mock-success');
        $isBatch = $this->option('batch');
        $from = $this->option('from') ?: 'id';
        $to = $this->option('to') ?: 'en';
        $text = $this->option('text') ?: 'Villa mewah dengan kolam renang pribadi dan pemandangan laut yang spektakuler.';

        $apiKey = config('gemini.api_key');
        $model = config('gemini.model', 'gemini-1.5-flash');
        $timeout = config('gemini.timeout', 15);

        $this->table(
            ['Konfigurasi', 'Nilai'],
            [
                ['Model AI', $model],
                ['API Key Status', !empty($apiKey) ? '✅ Terkonfigurasi (' . substr($apiKey, 0, 6) . '...' . substr($apiKey, -4) . ')' : '⚠️ KOSONG / BELUM DISET'],
                ['Timeout', "{$timeout} detik"],
                ['Mode Test', $mockError ? "Simulasi Error [{$mockError}]" : ($mockSuccess ? 'Simulasi Sukses (Mock)' : 'Real Google Gemini API')],
                ['Arah Terjemahan', "{$from} -> {$to}"],
            ]
        );

        // Handle Mocks if requested
        if ($mockError) {
            if (empty($apiKey)) {
                config(['gemini.api_key' => 'mock-test-key-for-simulation']);
            }
            $translator = new GeminiTranslationService();
            $this->setupMockError($mockError);
        } elseif ($mockSuccess) {
            if (empty($apiKey)) {
                config(['gemini.api_key' => 'mock-test-key-for-simulation']);
            }
            $translator = new GeminiTranslationService();
            $this->setupMockSuccess($isBatch);
        }

        $this->newLine();
        $this->info("⏳ Menjalankan pengujian terjemahan...");
        $startTime = microtime(true);

        if ($isBatch) {
            $payload = [
                'name' => 'Villa Sunset Paradise',
                'tagline' => 'Pengalaman menginap tak terlupakan di bibir pantai',
                'description' => '<p>Nikmati <strong>kolam renang infinity</strong> dan layanan butler 24 jam.</p>',
            ];

            $this->comment('📦 Input Batch Data:');
            $this->line(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            $this->newLine();

            $result = $translator->translateBatch($payload, $to, $from);
        } else {
            $this->comment("📝 Input Text: \"{$text}\"");
            $this->newLine();

            $result = $translator->translate($text, $to, $from);
        }

        $duration = round((microtime(true) - $startTime) * 1000, 2);

        $this->info("⏱️ Waktu Eksekusi: {$duration} ms");
        $this->newLine();

        if ($result['success']) {
            $this->info('✅ STATUS: BERHASIL (SUCCESS)');
            $this->newLine();
            $this->line('👉 Hasil Terjemahan:');
            if (is_array($result['data'])) {
                $this->line(json_encode($result['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            } else {
                $this->line("<fg=green;options=bold>{$result['data']}</>");
            }
            $this->newLine();
            return Command::SUCCESS;
        }

        // Output error handling details
        $this->error('❌ STATUS: GAGAL (FAILED)');
        $this->table(
            ['Error Property', 'Detail'],
            [
                ['Error Type', $result['error_type'] ?? 'unknown'],
                ['HTTP / Code', $result['code'] ?? '-'],
                ['Error Message', $result['error'] ?? 'No message'],
            ]
        );

        $this->newLine();
        $this->explainErrorType($result['error_type'] ?? '');

        return Command::FAILURE;
    }

    /**
     * Setup HTTP mocks to simulate specific error conditions.
     */
    protected function setupMockError(string $type): void
    {
        switch (strtolower($type)) {
            case 'quota':
                $this->warn('🧪 Mengaktifkan Mock: Simulasi Token/Quota Habis (HTTP 429 RESOURCE_EXHAUSTED)...');
                Http::fake([
                    '*generativelanguage.googleapis.com*' => Http::response([
                        'error' => [
                            'code' => 429,
                            'message' => 'Resource has been exhausted (e.g. check quota). Please retry after some time.',
                            'status' => 'RESOURCE_EXHAUSTED',
                            'details' => [
                                [
                                    '@type' => 'type.googleapis.com/google.rpc.QuotaFailure',
                                    'violations' => [
                                        ['subject' => 'user:default', 'description' => 'Rate limit exceeded for model gemini-1.5-flash']
                                    ]
                                ]
                            ]
                        ]
                    ], 429),
                ]);
                break;

            case 'connection':
                $this->warn('🧪 Mengaktifkan Mock: Simulasi Jaringan Putus / Connection Timeout...');
                Http::fake([
                    '*generativelanguage.googleapis.com*' => function () {
                        throw new ConnectionException('cURL error 28: Operation timed out after 15000 milliseconds with 0 bytes received');
                    },
                ]);
                break;

            case 'auth':
                $this->warn('🧪 Mengaktifkan Mock: Simulasi API Key Invalid / Unauthorized (HTTP 400/403)...');
                Http::fake([
                    '*generativelanguage.googleapis.com*' => Http::response([
                        'error' => [
                            'code' => 400,
                            'message' => 'API key not valid. Please pass a valid API key.',
                            'status' => 'INVALID_ARGUMENT',
                            'details' => [
                                ['@type' => 'type.googleapis.com/google.rpc.ErrorInfo', 'reason' => 'API_KEY_INVALID']
                            ]
                        ]
                    ], 400),
                ]);
                break;

            default:
                $this->error("Pilihan mock-error '{$type}' tidak dikenal. Gunakan: quota, connection, atau auth.");
                break;
        }
    }

    /**
     * Setup mock for success.
     */
    protected function setupMockSuccess(bool $isBatch): void
    {
        $this->warn('🧪 Mengaktifkan Mock: Simulasi Respons Sukses dari Gemini...');
        if ($isBatch) {
            $mockResponse = [
                'name' => 'Sunset Paradise Villa',
                'tagline' => 'An unforgettable stay right by the beach',
                'description' => '<p>Enjoy an <strong>infinity pool</strong> and 24-hour butler service.</p>',
            ];
            $jsonText = json_encode($mockResponse);
        } else {
            $jsonText = 'Luxurious villa with a private pool and spectacular ocean views.';
        }

        Http::fake([
            '*generativelanguage.googleapis.com*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => $jsonText]
                            ],
                            'role' => 'model'
                        ],
                        'finishReason' => 'STOP',
                    ]
                ]
            ], 200),
        ]);
    }

    /**
     * Explain actionable advice based on error type.
     */
    protected function explainErrorType(string $errorType): void
    {
        switch ($errorType) {
            case 'quota':
                $this->warn('💡 PENJELASAN & SOLUSI QUOTA:');
                $this->line('1. Kuota token gratis per menit (RPM) atau per hari (RPD) Google Gemini habis.');
                $this->line('2. Solusi: Tunggu 1 menit lalu coba lagi, atau gunakan Google AI Studio billing/upgrade.');
                $this->line('3. Di controller/fitur: Sistem bisa otomatis fallback ke teks asli (source) tanpa membuat aplikasi crash.');
                break;

            case 'connection':
                $this->warn('💡 PENJELASAN & SOLUSI KONEKSI:');
                $this->line('1. Server tidak dapat menjangkau domain generativelanguage.googleapis.com.');
                $this->line('2. Periksa koneksi internet, firewall, proxy, atau setting DNS server Anda.');
                break;

            case 'auth':
                $this->warn('💡 PENJELASAN & SOLUSI AUTH:');
                $this->line('1. GEMINI_API_KEY di file .env salah atau belum aktif.');
                $this->line('2. Dapatkan API Key baru di: https://aistudio.google.com/app/apikey');
                $this->line('3. Pastikan .env sudah terupdate dan jalankan "php artisan config:clear".');
                break;
        }
    }
}
