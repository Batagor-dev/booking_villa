@php
  $appSettings = settings();
@endphp
<!doctype html>
<html lang="id" class="h-full">
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
  <body class="h-full bg-[#fcfbf9] text-slate-900 antialiased font-satoshi-medium selection:bg-[#ca9e54] selection:text-white">
    <div class="min-h-screen flex flex-col lg:flex-row">

      <!-- LEFT COLUMN: LUXURY SHOWCASE (Visible on lg screens) -->
      <div class="hidden lg:flex lg:w-7/12 relative overflow-hidden bg-slate-950 flex-col justify-between p-12 xl:p-16 min-h-screen">
        <!-- Background Image with Gradient Overlays -->
        <div class="absolute inset-0 z-0 pointer-events-none select-none">
          <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1800&q=85" 
               alt="Luxury Villa Resort" 
               class="w-full h-full object-cover object-center scale-105">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/45 to-black/30"></div>
          <div class="absolute inset-0 bg-radial from-transparent via-black/20 to-slate-950/60"></div>
        </div>

        <!-- Top Left Brand Badge & Navigation -->
        <div class="relative z-10 flex items-center justify-between">
          <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            <span class="font-serif-title text-3xl font-bold tracking-[0.2em] text-white uppercase group-hover:text-[#e5c382] transition-colors">
              PALMA
            </span>
          </a>
          <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold text-[#e5c382] tracking-wider uppercase">
            <i class="ri-shield-star-line text-sm"></i> Luxury Villa Sanctuary
          </span>
        </div>

        <!-- Middle Editorial Quote & Highlights -->
        <div class="relative z-10 space-y-8 max-w-xl my-auto pt-12">
          <div class="space-y-4">
            <span class="text-xs font-bold tracking-[0.3em] uppercase text-[#e5c382]">Eksklusif & Terverifikasi</span>
            <h1 class="font-serif-title text-4xl xl:text-5xl font-normal leading-tight text-white">
              Rasakan Privasi & <br/>
              <span class="italic font-normal text-[#f5e6c8]">Kemewahan Tanpa Batas</span>
            </h1>
            <p class="text-sm xl:text-base text-slate-300 font-light leading-relaxed">
              Akses koleksi villa dan resort eksklusif di Seminyak, Ubud, Uluwatu, dan Canggu dengan layanan concierge pribadi 24/7.
            </p>
          </div>
        </div>

        <!-- Footer Note -->
        <div class="relative z-10 flex items-center justify-between text-xs text-slate-400 font-light border-t border-white/10 pt-6">
          <p>&copy; {{ date('Y') }} Palma Luxury Villas. All rights reserved.</p>
          <div class="flex items-center gap-4">
            <span class="flex items-center gap-1"><i class="ri-lock-2-line text-[#ca9e54]"></i> Enkripsi 256-bit</span>
          </div>
        </div>
      </div>

      <!-- RIGHT COLUMN: FORM CONTAINER -->
      <div class="w-full lg:w-5/12 flex flex-col justify-between p-6 sm:p-10 xl:p-14 bg-[#fcfbf9] min-h-screen">
        
        <!-- Header Top Back Link & Mobile Brand Header -->
        <div class="flex items-center justify-between mb-6">
          <a href="{{ route('home') }}" class="lg:hidden font-serif-title text-2xl font-bold tracking-[0.2em] text-slate-900 uppercase">
            PALMA
          </a>
          <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-satoshi-bold text-slate-700 hover:text-[#ca9e54] transition-colors ml-auto group">
            <i class="ri-arrow-left-line text-base group-hover:-translate-x-1 transition-transform"></i>
            <span>Kembali ke Beranda</span>
          </a>
        </div>

        <!-- Form Card Wrapper -->
        <div class="w-full max-w-md mx-auto my-auto space-y-7 py-4">
          <!-- Header Title & Subtitle -->
          <div class="space-y-2 text-center lg:text-left">
            <h2 class="font-serif-title text-3xl sm:text-4xl font-normal text-slate-900 tracking-tight">
              @yield('title', 'Selamat Datang')
            </h2>
            <p class="text-sm sm:text-base text-slate-600 font-satoshi-medium leading-relaxed">
              @yield('subtitle', 'Masuk untuk mengelola dan mengakses layanan eksklusif Anda.')
            </p>
          </div>

          <!-- Dynamic Page Content -->
          @yield('content')
        </div>

        <!-- Footer Bottom Links on Mobile -->
        <div class="text-center text-xs text-slate-400 font-light pt-6">
          <p class="lg:hidden">&copy; {{ date('Y') }} Palma Luxury Villas. All rights reserved.</p>
        </div>

      </div>

    </div>

    @stack('scripts')
  </body>
</html>

