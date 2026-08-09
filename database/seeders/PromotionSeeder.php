<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;
use App\Models\Properties;
use App\Models\Destination;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean existing seed promo records (including soft deleted ones)
        Promotion::withTrashed()->whereIn('code', ['WELCOME100', 'VILLA-SEMINYAK'])->forceDelete();

        // 1. WELCOME100 Promo Code / Voucher (valid for ALL properties)
        Promotion::create([
            'name'            => 'Welcome Global Voucher',
            'description'     => 'Potongan Rp 100.000 untuk transaksi pertama di villa mana saja dengan minimal transaksi Rp 500.000.',
            'promotion_type'  => 'code',
            'code'            => 'WELCOME100',
            'discount_type'   => 'fixed',
            'discount_value'  => 100000.00,
            'min_nights'      => 1,
            'min_transaction' => 500000.00,
            'target_type'     => 'all',
            'start_date'      => now()->subDays(2)->startOfDay(),
            'end_date'        => now()->addYears(1)->startOfDay(),
            'status'          => true,
            'max_uses'        => 500,
            'used_count'      => 0,
        ]);

        // 2. VILLA-SEMINYAK Promo Code / Voucher (valid strictly for 1 SPECIFIC PROPERTY)
        $firstProperty = Properties::first();
        if ($firstProperty) {
            $promoPropertySpecific = Promotion::create([
                'name'            => 'Voucher Khusus ' . $firstProperty->name,
                'description'     => 'Potongan Rp 250.000 khusus reservasi ' . $firstProperty->name . ' dengan minimal menginap 2 malam.',
                'promotion_type'  => 'code',
                'code'            => 'VILLA-SEMINYAK',
                'discount_type'   => 'fixed',
                'discount_value'  => 250000.00,
                'min_nights'      => 2,
                'min_transaction' => 1000000.00,
                'target_type'     => 'properties',
                'start_date'      => now()->subDays(1)->startOfDay(),
                'end_date'        => now()->addMonths(6)->startOfDay(),
                'status'          => true,
                'max_uses'        => 100,
                'used_count'      => 0,
            ]);

            // Link promo exclusively to the first property
            $promoPropertySpecific->properties()->sync([$firstProperty->id]);
        }

        // 3. Automatic 20% Discount targeting Specific Properties
        $properties = Properties::take(2)->get();
        if ($properties->isNotEmpty()) {
            $promo = Promotion::create([
                'name' => 'Featured Villas Special 20%',
                'description' => 'Enjoy 20% discount on select premium villas with minimum stay of 2 nights.',
                'promotion_type' => 'automatic',
                'discount_type' => 'percentage',
                'discount_value' => 20.00,
                'min_nights' => 2,
                'min_transaction' => 0.00,
                'target_type' => 'properties',
                'start_date' => now()->subDays(1)->startOfDay(),
                'end_date' => now()->addMonths(6)->startOfDay(),
                'status' => true,
            ]);

            $promo->properties()->sync($properties->pluck('id')->toArray());
        }

        // 4. Automatic 10% Discount targeting Bali destination
        $destination = Destination::first();
        if ($destination) {
            $promo = Promotion::create([
                'name' => 'Bali Getaway Special',
                'description' => 'Automatic 10% discount on all properties in Bali.',
                'promotion_type' => 'automatic',
                'discount_type' => 'percentage',
                'discount_value' => 10.00,
                'min_nights' => 1,
                'min_transaction' => 0.00,
                'target_type' => 'destinations',
                'start_date' => now()->subDays(1)->startOfDay(),
                'end_date' => now()->addYears(1)->startOfDay(),
                'status' => true,
            ]);

            $promo->destinations()->sync([$destination->id]);
        }
    }
}
