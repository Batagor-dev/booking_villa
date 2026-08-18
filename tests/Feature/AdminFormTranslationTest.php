<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\Facilities;
use App\Models\Promotion;
use App\Models\Properties;
use App\Models\PropertyRule;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminFormTranslationTest extends TestCase
{
    use DatabaseTransactions;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('gemini.api_key', 'test-api-key');
        Config::set('localization.supported_locales', ['id', 'en']);
        Storage::fake('public');

        // Create or find an admin user for authentication
        $this->adminUser = User::first() ?? User::factory()->create();
    }

    public function test_property_auto_translates_on_creation(): void
    {
        Http::fake([
            '*generativelanguage.googleapis.com*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'text' => json_encode([
                                        'name' => 'Royal Sunset Sanctuary Villa',
                                        'description' => '<p>Exclusive luxury villa with private infinity pool.</p>',
                                        'address' => 'Jl. Sunset Road No. 99, Seminyak',
                                    ])
                                ]
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $property = Properties::create([
            'name' => 'Villa Royal Sunset Sanctuary',
            'type' => 'Villa',
            'price' => 5000000,
            'bedrooms' => 3,
            'capacity' => 6,
            'description' => '<p>Villa mewah eksklusif dengan kolam renang pribadi.</p>',
            'address' => 'Jl. Sunset Road No. 99, Seminyak',
            'status' => true,
        ]);

        $property->autoTranslateAndSave([
            'name' => 'Villa Royal Sunset Sanctuary',
            'description' => '<p>Villa mewah eksklusif dengan kolam renang pribadi.</p>',
            'address' => 'Jl. Sunset Road No. 99, Seminyak',
        ]);

        // Assert Indonesian translation exists
        $transId = $property->getTranslation('id');
        $this->assertNotNull($transId);
        $this->assertEquals('Villa Royal Sunset Sanctuary', $transId->name);

        // Assert English translation exists and auto-translated
        $transEn = $property->getTranslation('en');
        $this->assertNotNull($transEn);
        $this->assertEquals('Royal Sunset Sanctuary Villa', $transEn->name);
        $this->assertStringContainsString('Exclusive luxury villa', $transEn->description);
    }

    public function test_destination_auto_translates_on_creation(): void
    {
        Http::fake([
            '*generativelanguage.googleapis.com*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'text' => json_encode([
                                        'name' => 'Ubud Sanctuary',
                                        'attraction' => 'Heart of Balinese art, lush jungle, and serene retreats.',
                                    ])
                                ]
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $destination = Destination::create([
            'name' => 'Ubud Asri',
            'image_path' => 'destination-images/sample.jpg',
            'sort' => 999,
            'attraction' => 'Pusat seni Bali, hutan rimbun, dan suasana tenang.',
            'status' => true,
        ]);

        $destination->autoTranslateAndSave([
            'name' => 'Ubud Asri',
            'attraction' => 'Pusat seni Bali, hutan rimbun, dan suasana tenang.',
        ]);

        $transId = $destination->getTranslation('id');
        $this->assertNotNull($transId);
        $this->assertEquals('Ubud Asri', $transId->name);

        $transEn = $destination->getTranslation('en');
        $this->assertNotNull($transEn);
        $this->assertEquals('Ubud Sanctuary', $transEn->name);
        $this->assertStringContainsString('Heart of Balinese art', $transEn->attraction);
    }

    public function test_facility_auto_translates_on_creation(): void
    {
        Http::fake([
            '*generativelanguage.googleapis.com*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'text' => json_encode([
                                        'name' => 'Private Infinity Pool',
                                        'description' => 'Olympic size infinity swimming pool overlooking the jungle.',
                                    ])
                                ]
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $facility = Facilities::create([
            'name' => 'Kolam Renang Infinity Pribadi',
            'category' => 'Outdoor',
            'sort' => 1,
            'description' => 'Kolam renang ukuran olympic menghadap pemandangan hutan.',
            'status' => true,
        ]);

        $facility->autoTranslateAndSave([
            'name' => 'Kolam Renang Infinity Pribadi',
            'description' => 'Kolam renang ukuran olympic menghadap pemandangan hutan.',
        ]);

        $transId = $facility->getTranslation('id');
        $this->assertNotNull($transId);
        $this->assertEquals('Kolam Renang Infinity Pribadi', $transId->name);

        $transEn = $facility->getTranslation('en');
        $this->assertNotNull($transEn);
        $this->assertEquals('Private Infinity Pool', $transEn->name);
        $this->assertStringContainsString('Olympic size infinity', $transEn->description);
    }

    public function test_property_rule_auto_translates_on_creation(): void
    {
        Http::fake([
            '*generativelanguage.googleapis.com*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'text' => json_encode([
                                        'title' => 'Quiet Hours & Party Policy',
                                        'description' => 'Quiet hours are strictly observed from 10:00 PM to 07:00 AM.',
                                    ])
                                ]
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $rule = PropertyRule::create([
            'title' => 'Jam Tenang & Aturan Pesta',
            'property_type' => 'all',
            'sort_order' => 1,
            'description' => 'Jam tenang berlaku mulai pukul 22:00 malam hingga 07:00 pagi.',
            'is_active' => true,
        ]);

        $rule->autoTranslateAndSave([
            'title' => 'Jam Tenang & Aturan Pesta',
            'description' => 'Jam tenang berlaku mulai pukul 22:00 malam hingga 07:00 pagi.',
        ]);

        $transId = $rule->getTranslation('id');
        $this->assertNotNull($transId);
        $this->assertEquals('Jam Tenang & Aturan Pesta', $transId->title);

        $transEn = $rule->getTranslation('en');
        $this->assertNotNull($transEn);
        $this->assertEquals('Quiet Hours & Party Policy', $transEn->title);
        $this->assertStringContainsString('Quiet hours are strictly observed', $transEn->description);
    }

    public function test_promotion_auto_translates_on_creation(): void
    {
        Http::fake([
            '*generativelanguage.googleapis.com*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'text' => json_encode([
                                        'name' => 'Summer Holiday Special 20%',
                                        'description' => 'Get a 20% discount on all luxury villa bookings during summer.',
                                    ])
                                ]
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $promo = Promotion::create([
            'name' => 'Spesial Liburan Musim Panas 20%',
            'description' => 'Dapatkan diskon 20% untuk semua pemesanan villa mewah selama musim panas.',
            'promotion_type' => 'automatic',
            'discount_type' => 'percentage',
            'discount_value' => 20,
            'target_type' => 'all',
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'status' => true,
        ]);

        $promo->autoTranslateAndSave([
            'name' => 'Spesial Liburan Musim Panas 20%',
            'description' => 'Dapatkan diskon 20% untuk semua pemesanan villa mewah selama musim panas.',
        ]);

        $transId = $promo->getTranslation('id');
        $this->assertNotNull($transId);
        $this->assertEquals('Spesial Liburan Musim Panas 20%', $transId->name);

        $transEn = $promo->getTranslation('en');
        $this->assertNotNull($transEn);
        $this->assertEquals('Summer Holiday Special 20%', $transEn->name);
        $this->assertStringContainsString('Get a 20% discount', $transEn->description);
    }
}
