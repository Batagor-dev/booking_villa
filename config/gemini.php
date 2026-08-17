<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Gemini API Key
    |--------------------------------------------------------------------------
    |
    | API Key obtained from Google AI Studio (https://aistudio.google.com/).
    |
    */
    'api_key' => env('GEMINI_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Default Model
    |--------------------------------------------------------------------------
    |
    | Model used for translations.
    | Options: 'gemini-1.5-flash', 'gemini-1.5-pro', 'gemini-2.0-flash', etc.
    | 'gemini-1.5-flash' / 'gemini-2.0-flash' are recommended for speed and low cost.
    |
    */
    'model' => env('GEMINI_MODEL', 'gemini-2.5-flash'),

    /*
    |--------------------------------------------------------------------------
    | Base API URL
    |--------------------------------------------------------------------------
    */
    'base_url' => env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout (seconds)
    |--------------------------------------------------------------------------
    */
    'timeout' => (int) env('GEMINI_TIMEOUT', 15),

    /*
    |--------------------------------------------------------------------------
    | Retry Configuration
    |--------------------------------------------------------------------------
    */
    'retry_times' => (int) env('GEMINI_RETRY_TIMES', 2),
    'retry_sleep_ms' => (int) env('GEMINI_RETRY_SLEEP_MS', 500),

    /*
    |--------------------------------------------------------------------------
    | Locale Mapping to Human Language Names
    |--------------------------------------------------------------------------
    */
    'locales_map' => [
        'id' => 'Indonesian',
        'en' => 'English',
        'zh' => 'Simplified Chinese',
        'ja' => 'Japanese',
        'ru' => 'Russian',
        'ar' => 'Arabic',
        'fr' => 'French',
        'de' => 'German',
        'es' => 'Spanish',
    ],
];
