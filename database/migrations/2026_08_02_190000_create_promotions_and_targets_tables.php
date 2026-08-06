<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            
            // Type of Promotion
            $table->enum('promotion_type', ['automatic', 'code'])->default('automatic');
            $table->string('code')->nullable()->unique(); // Required if promotion_type is 'code'
            
            // Discount definition
            $table->enum('discount_type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('discount_value', 15, 2);
            
            // Conditions
            $table->integer('min_nights')->nullable();
            $table->decimal('min_transaction', 15, 2)->nullable();
            
            // Target level (all, specific properties, categories/property types, destinations/regions)
            $table->enum('target_type', ['all', 'properties', 'categories', 'destinations'])->default('all');
            
            // Validity duration
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot for Specific Properties (promo_id & property_id)
        Schema::create('promotion_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained('promotions')->cascadeOnDelete();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->timestamps();
        });

        // Pivot for Specific Property Types (Villa, Resort, Hotel, Apartment, etc. mapping to properties.type)
        Schema::create('promotion_property_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained('promotions')->cascadeOnDelete();
            $table->string('property_type');
            $table->timestamps();
        });

        // Pivot for Specific Regions/Destinations
        Schema::create('promotion_destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained('promotions')->cascadeOnDelete();
            $table->foreignId('destination_id')->constrained('destinations')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_destinations');
        Schema::dropIfExists('promotion_property_types');
        Schema::dropIfExists('promotion_properties');
        Schema::dropIfExists('promotions');
    }
};
