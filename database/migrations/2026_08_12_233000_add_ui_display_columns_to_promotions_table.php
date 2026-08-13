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
        Schema::table('promotions', function (Blueprint $table) {
            $table->string('badge_text')->nullable()->after('name');
            $table->boolean('is_featured')->default(false)->after('status');
            $table->string('banner_theme')->default('navy')->after('is_featured');
            $table->text('features')->nullable()->after('banner_theme');
            $table->string('icon')->nullable()->after('features');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn(['badge_text', 'is_featured', 'banner_theme', 'features', 'icon']);
        });
    }
};
