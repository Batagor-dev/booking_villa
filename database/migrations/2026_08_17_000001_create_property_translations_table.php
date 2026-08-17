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
        Schema::create('property_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->string('locale', 10);
            $table->string('name');
            $table->string('slug')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();

            $table->unique(['property_id', 'locale']);
            $table->index(['locale', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_translations');
    }
};
