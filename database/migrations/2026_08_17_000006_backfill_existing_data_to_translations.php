<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations and backfill existing data to default locale (id).
     */
    public function up(): void
    {
        $defaultLocale = config('localization.fallback_locale', 'id');

        // 1. Backfill properties -> property_translations
        if (Schema::hasTable('properties')) {
            $properties = DB::table('properties')->get();
            foreach ($properties as $property) {
                DB::table('property_translations')->updateOrInsert(
                    [
                        'property_id' => $property->id,
                        'locale'      => $defaultLocale,
                    ],
                    [
                        'name'              => $property->name ?? '',
                        'slug'              => $property->slug ?? null,
                        'description'       => $property->description ?? null,
                        'short_description' => null,
                        'address'           => $property->address ?? null,
                        'created_at'        => $property->created_at ?? now(),
                        'updated_at'        => $property->updated_at ?? now(),
                    ]
                );
            }
        }

        // 2. Backfill destinations -> destination_translations
        if (Schema::hasTable('destinations')) {
            $destinations = DB::table('destinations')->get();
            foreach ($destinations as $destination) {
                DB::table('destination_translations')->updateOrInsert(
                    [
                        'destination_id' => $destination->id,
                        'locale'         => $defaultLocale,
                    ],
                    [
                        'name'       => $destination->name ?? '',
                        'slug'       => $destination->slug ?? null,
                        'attraction' => $destination->attraction ?? null,
                        'created_at' => $destination->created_at ?? now(),
                        'updated_at' => $destination->updated_at ?? now(),
                    ]
                );
            }
        }

        // 3. Backfill facilities -> facility_translations
        if (Schema::hasTable('facilities')) {
            $facilities = DB::table('facilities')->get();
            foreach ($facilities as $facility) {
                DB::table('facility_translations')->updateOrInsert(
                    [
                        'facility_id' => $facility->id,
                        'locale'      => $defaultLocale,
                    ],
                    [
                        'name'        => $facility->name ?? '',
                        'description' => $facility->description ?? null,
                        'created_at'  => $facility->created_at ?? now(),
                        'updated_at'  => $facility->updated_at ?? now(),
                    ]
                );
            }
        }

        // 4. Backfill property_rules -> property_rule_translations
        if (Schema::hasTable('property_rules')) {
            $rules = DB::table('property_rules')->get();
            foreach ($rules as $rule) {
                DB::table('property_rule_translations')->updateOrInsert(
                    [
                        'property_rule_id' => $rule->id,
                        'locale'           => $defaultLocale,
                    ],
                    [
                        'title'       => $rule->title ?? '',
                        'description' => $rule->description ?? null,
                        'created_at'  => $rule->created_at ?? now(),
                        'updated_at'  => $rule->updated_at ?? now(),
                    ]
                );
            }
        }

        // 5. Backfill promotions -> promotion_translations
        if (Schema::hasTable('promotions')) {
            $promotions = DB::table('promotions')->get();
            foreach ($promotions as $promo) {
                DB::table('promotion_translations')->updateOrInsert(
                    [
                        'promotion_id' => $promo->id,
                        'locale'       => $defaultLocale,
                    ],
                    [
                        'name'        => $promo->name ?? '',
                        'description' => $promo->description ?? null,
                        'created_at'  => $promo->created_at ?? now(),
                        'updated_at'  => $promo->updated_at ?? now(),
                    ]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No down action needed for backfilling
    }
};
