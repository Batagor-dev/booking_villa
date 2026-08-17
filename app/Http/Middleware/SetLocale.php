<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request and set the active application locale.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = config('localization.supported_locales', ['id', 'en', 'ja']);
        $fallbackLocale = config('localization.fallback_locale', 'id');

        $locale = null;

        // 1. Check query parameter e.g. ?lang=en or ?locale=en
        if ($request->has('lang') && in_array($request->query('lang'), $supportedLocales, true)) {
            $locale = $request->query('lang');
            session(['locale' => $locale]);
        } elseif ($request->has('locale') && in_array($request->query('locale'), $supportedLocales, true)) {
            $locale = $request->query('locale');
            session(['locale' => $locale]);
        }
        // 2. Check session
        elseif (session()->has('locale') && in_array(session('locale'), $supportedLocales, true)) {
            $locale = session('locale');
        }
        // 3. Check Cookie
        elseif ($request->hasCookie('locale') && in_array($request->cookie('locale'), $supportedLocales, true)) {
            $locale = $request->cookie('locale');
            session(['locale' => $locale]);
        }
        // 4. Default fallback
        else {
            $locale = $fallbackLocale;
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
