<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class LocalizationController extends Controller
{
    /**
     * Switch application language and redirect back.
     */
    public function switch(string $locale, Request $request): RedirectResponse
    {
        $supportedLocales = config('localization.supported_locales', ['id', 'en', 'ja']);

        if (in_array($locale, $supportedLocales, true)) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
            cookie()->queue(cookie('locale', $locale, 60 * 24 * 365)); // 1 year cookie
        }

        return redirect()->back();
    }
}
