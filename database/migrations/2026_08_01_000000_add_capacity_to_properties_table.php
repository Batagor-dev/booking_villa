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
        if (Schema::hasTable('properties') && !Schema::hasColumn('properties', 'capacity')) {
            Schema::table('properties', function (Blueprint $table) {
                $table->integer('capacity')->default(2)->after('type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('properties') && Schema::hasColumn('properties', 'capacity')) {
            Schema::table('properties', function (Blueprint $table) {
                $table->dropColumn('capacity');
            });
        }
    }
};
