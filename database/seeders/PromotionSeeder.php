<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;
use App\Models\Properties;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean existing seed promo records
        Promotion::withTrashed()->whereIn('code', [
            'PALMAWEEKEND', 'WELCOMEPALMA', 'LONGSTAY25', 'REFER100', 'LASTMIN50', 'ROMANCEVIP', 'WELCOME100', 'VILLA-SEMINYAK'
        ])->forceDelete();

        // 1. FEATURED BANNER 1: Flash Sale Weekend (Navy Theme)
        Promotion::create([
            'name'            => 'Weekend Luxury Escape',
            'badge_text'      => 'FLASH SALE WEEKEND',
            'description'     => 'Reservasi weekend di villa mewah pilihan kawasan Seminyak & Uluwatu. Dapatkan diskon 40% plus bonus gratis makan malam dan welcome drink.',
            'promotion_type'  => 'code',
            'code'            => 'PALMAWEEKEND',
            'discount_type'   => 'percentage',
            'discount_value'  => 40.00,
            'min_nights'      => 2,
            'min_transaction' => 0.00,
            'target_type'     => 'all',
            'is_featured'     => true,
            'banner_theme'    => 'navy',
            'features'        => "Diskon Instan 40% OFF Semua Villa, Bonus Welcome Drink & Dinner VIP",
            'start_date'      => now()->subDays(1)->startOfDay(),
            'end_date'        => now()->addDays(7)->startOfDay(),
            'status'          => true,
            'max_uses'        => 500,
            'used_count'      => 0,
        ]);

        // 2. FEATURED BANNER 2: Bonus Registrasi Pertama (Gold Theme)
        Promotion::create([
            'name'            => 'Bonus Registrasi Pertama',
            'badge_text'      => 'KHUSUS MEMBER BARU',
            'description'     => 'Daftar akun Palma hari ini dan klaim diskon instan 35% untuk reservasi villa pertama Anda beserta paket penjemputan bandara gratis.',
            'promotion_type'  => 'code',
            'code'            => 'WELCOMEPALMA',
            'discount_type'   => 'percentage',
            'discount_value'  => 35.00,
            'min_nights'      => 1,
            'min_transaction' => 0.00,
            'target_type'     => 'all',
            'is_featured'     => true,
            'banner_theme'    => 'gold',
            'features'        => "Gratis Transfer Bandara VIP (Alphard / SUV), Gratis Romantic Candlelight Dinner, Layanan Concierge 24 Jam Nonstop",
            'start_date'      => now()->subDays(1)->startOfDay(),
            'end_date'        => now()->addMonths(12)->startOfDay(),
            'status'          => true,
            'max_uses'        => 1000,
            'used_count'      => 0,
        ]);

        // 3. SECONDARY CARD 1: Long Stay Sanctuary
        Promotion::create([
            'name'            => 'Hemat 25% (> 7 Malam)',
            'badge_text'      => 'LONG STAY SANCTUARY',
            'description'     => 'Nikmati pengalaman liburan panjang. Makin lama Anda menginap, makin hemat harga per malamnya.',
            'promotion_type'  => 'code',
            'code'            => 'LONGSTAY25',
            'discount_type'   => 'percentage',
            'discount_value'  => 25.00,
            'min_nights'      => 7,
            'min_transaction' => 0.00,
            'target_type'     => 'all',
            'is_featured'     => false,
            'icon'            => 'ri-calendar-check-line',
            'start_date'      => now()->subDays(1)->startOfDay(),
            'end_date'        => now()->addYear()->startOfDay(),
            'status'          => true,
        ]);

        // 4. SECONDARY CARD 2: Referral Reward
        Promotion::create([
            'name'            => 'Kredit $100 Per Teman',
            'badge_text'      => 'REFERRAL REWARD',
            'description'     => 'Ajak kerabat & teman Anda menginap di Palma dan dapatkan langsung kredit saldo $100 per booking.',
            'promotion_type'  => 'code',
            'code'            => 'REFER100',
            'discount_type'   => 'fixed',
            'discount_value'  => 1500000.00,
            'min_nights'      => 1,
            'min_transaction' => 0.00,
            'target_type'     => 'all',
            'is_featured'     => false,
            'icon'            => 'ri-gift-line',
            'start_date'      => now()->subDays(1)->startOfDay(),
            'end_date'        => now()->addYear()->startOfDay(),
            'status'          => true,
        ]);

        // 5. SECONDARY CARD 3: Last Minute Deal
        Promotion::create([
            'name'            => 'Diskon Hingga 50%',
            'badge_text'      => 'LAST MINUTE DEAL',
            'description'     => 'Penawaran istimewa untuk pemesanan tanggal spontan di minggu yang sama.',
            'promotion_type'  => 'code',
            'code'            => 'LASTMIN50',
            'discount_type'   => 'percentage',
            'discount_value'  => 50.00,
            'min_nights'      => 1,
            'min_transaction' => 0.00,
            'target_type'     => 'all',
            'is_featured'     => false,
            'icon'            => 'ri-price-tag-3-line',
            'start_date'      => now()->subDays(1)->startOfDay(),
            'end_date'        => now()->addYear()->startOfDay(),
            'status'          => true,
        ]);

        // 6. SECONDARY CARD 4: Honeymoon Special
        Promotion::create([
            'name'            => 'Paket Pasangan Romantis',
            'badge_text'      => 'HONEYMOON SPECIAL',
            'description'     => 'Gratis dekorasi bunga tempat tidur, botol wine premium, dan perawatan spa pasangan 90 menit.',
            'promotion_type'  => 'code',
            'code'            => 'ROMANCEVIP',
            'discount_type'   => 'percentage',
            'discount_value'  => 20.00,
            'min_nights'      => 2,
            'min_transaction' => 0.00,
            'target_type'     => 'all',
            'is_featured'     => false,
            'icon'            => 'ri-heart-3-line',
            'start_date'      => now()->subDays(1)->startOfDay(),
            'end_date'        => now()->addYear()->startOfDay(),
            'status'          => true,
        ]);
    }
}
