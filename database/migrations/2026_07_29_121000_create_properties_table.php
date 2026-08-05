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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->nullable()->constrained('destinations')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code')->nullable();
            $table->string('type')->default('Villa'); // Villa, Resort, Hotel, Apartment
            
            // Specification & Pricing
            $table->decimal('price', 15, 2)->default(0);
            $table->integer('bedrooms')->default(1);
            $table->integer('capacity')->default(2);

            // Ratings Cache
            $table->decimal('rating', 3, 2)->default(0.00);

            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('main_image')->nullable();
            $table->text('map_link')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('is_featured')->default(false);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
