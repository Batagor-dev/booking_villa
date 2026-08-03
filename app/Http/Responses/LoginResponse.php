<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        // 🚨 WAJIB: cek verifikasi email dulu
        if (! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // ADMIN / SUPER ADMIN -> Always to Admin Panel Dashboard
        if (method_exists($user, 'hasRole') && $user->hasRole(['Admin', 'Super Admin', 'admin', 'super-admin'])) {
            return redirect()->route('dashboard');
        }

        // Determine intended / last visited non-auth URL
        $targetUrl = $request->input('redirect');

        if (! $targetUrl && session()->has('url.intended')) {
            $targetUrl = session()->get('url.intended');
        }

        if (! $targetUrl) {
            $previousUrl = url()->previous();
            if ($previousUrl && $previousUrl !== url()->current() && Str::startsWith($previousUrl, config('app.url'))) {
                $targetUrl = $previousUrl;
            }
        }

        // Verify that target URL is NOT an auth page (login/register/password/logout)
        if ($targetUrl) {
            $isAuthPage = Str::contains($targetUrl, [
                '/login', '/register', '/logout', '/forgot-password', '/reset-password', '/auth/', '/email/verify'
            ]);

            if (! $isAuthPage) {
                session()->forget('url.intended');
                return redirect($targetUrl);
            }
        }

        // REGULAR USER / CUSTOMER FRONTEND (Default fallback to Home)
        return redirect()->intended(route('home'));
    }
}
