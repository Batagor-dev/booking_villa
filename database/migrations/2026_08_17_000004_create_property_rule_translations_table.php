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
        Schema::create('property_rule_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_rule_id')->constrained('property_rules')->cascadeOnDelete();
            $table->string('locale', 10);
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['property_rule_id', 'locale']);
            $table->index(['locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_rule_translations');
    }
};
