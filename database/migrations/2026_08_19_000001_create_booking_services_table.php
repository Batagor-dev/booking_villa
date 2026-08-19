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
        // Add services_subtotal column to bookings if not exists
        if (Schema::hasTable('bookings') && !Schema::hasColumn('bookings', 'services_subtotal')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->decimal('services_subtotal', 15, 2)->default(0)->after('discount_amount');
            });
        }

        Schema::create('booking_services', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('property_service_id')->nullable()->constrained('property_services')->nullOnDelete();
            $table->string('name');
            $table->string('category')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->string('price_type')->default('per_item');
            $table->integer('quantity')->default(1);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_services');

        if (Schema::hasTable('bookings') && Schema::hasColumn('bookings', 'services_subtotal')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('services_subtotal');
            });
        }
    }
};
