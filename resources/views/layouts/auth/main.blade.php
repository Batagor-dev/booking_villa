@php
  $appSettings = settings();
@endphp
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Sign In') - {{ $appSettings['title'] ?? config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ !empty($appSettings['favicon']) ? asset('storage/' . $appSettings['favicon']) : asset('images/no-image.png') }}">
    
    <!-- Preconnect & Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="flex min-h-screen items-center justify-center px-4 py-10">
      <div class="w-full max-w-md rounded-3xl border border-slate-200 bg-white/95 p-8 shadow-xl shadow-slate-300/40 backdrop-blur-sm">
        <div class="mb-8 text-center">
          <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2.5">
            <span class="font-serif-title text-3xl font-bold tracking-[0.2em] uppercase text-slate-900">
              @yield('brand', $appSettings['title'] ?? 'PALMA')
            </span>
          </a>
          <p class="mt-2 text-base text-slate-500 font-satoshi-medium">
            @yield('subtitle', 'Sign in to manage the application.')
          </p>
        </div>

        @yield('content')
      </div>
    </div>

    @stack('scripts')
  </body>
</html>
