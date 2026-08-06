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
        // 1. WELCOME100 Promo Code / Voucher (valid for all)
        Promotion::create([
            'name' => 'Welcome Promo Voucher',
            'description' => 'Rp100.000 off your first booking with minimum transaction Rp500.000.',
            'promotion_type' => 'code',
            'code' => 'WELCOME100',
            'discount_type' => 'fixed',
            'discount_value' => 100000.00,
            'min_nights' => 1,
            'min_transaction' => 500000.00,
            'target_type' => 'all',
            'start_date' => now()->subDays(2)->startOfDay(),
            'end_date' => now()->addYears(1)->startOfDay(),
            'status' => true,
        ]);

        // 2. Automatic 20% Discount targeting Specific Properties
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

        // 3. Automatic 10% Discount targeting Bali destination
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

        // 4. Automatic 15% Discount targeting Resorts
        $promo = Promotion::create([
            'name' => 'Resorts Special 15%',
            'description' => 'Automatic 15% discount on all Resort properties.',
            'promotion_type' => 'automatic',
            'discount_type' => 'percentage',
            'discount_value' => 15.00,
            'min_nights' => 1,
            'min_transaction' => 0.00,
            'target_type' => 'categories',
            'start_date' => now()->subDays(1)->startOfDay(),
            'end_date' => now()->addYears(1)->startOfDay(),
            'status' => true,
        ]);
        $promo->propertyTypes()->create([
            'property_type' => 'Resort'
        ]);
    }
}
