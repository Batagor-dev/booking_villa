<?php

namespace App\Providers;

use App\Services\GeminiTranslationService;
use Illuminate\Support\ServiceProvider;

class GeminiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GeminiTranslationService::class, function ($app) {
            return new GeminiTranslationService();
        });

        // Facade/alias binding
        $this->app->alias(GeminiTranslationService::class, 'gemini.translator');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
