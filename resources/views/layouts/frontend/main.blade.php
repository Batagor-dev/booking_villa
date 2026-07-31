@php
    $appSettings = settings();
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($appSettings['title'] ?? 'Palma') . ' - Pelarian Mewah & Villa Impian Anda')</title>
    <meta name="author" content="{{ $appSettings['author'] ?? '' }}">
    <meta name="description" content="{{ $appSettings['description'] ?? 'Platform Pemesanan Villa Mewah & Resort Eksklusif.' }}">
    <link rel="icon" type="image/png" href="{{ !empty($appSettings['favicon']) ? asset('storage/' . $appSettings['favicon']) : asset('images/no-image.png') }}">
    
    <!-- Preconnect & Google Fonts (Non-blocking display=swap) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Local Vendor Assets -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" />

    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans bg-[#f8f9fb] text-slate-800 antialiased selection:bg-[#ca9e54] selection:text-white">

    <!-- NAVBAR HEADER -->
    <x-layout.frontend.header />

    <!-- MAIN CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <x-layout.frontend.footer />

    <!-- INTERACTIVE GLOBAL JS -->
    <script>
        const navbar = document.getElementById('navbar');
        const navLogoText = document.getElementById('nav-logo-text');
        const navMenu = document.getElementById('nav-menu');
        const navSearchIcon = document.getElementById('nav-search-icon');
        const navFavIcon = document.getElementById('nav-fav-icon');
        const navLoginBtn = document.getElementById('nav-login-btn');

        if (navbar) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 40) {
                    navbar.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-sm', 'py-3.5');
                    navbar.classList.remove('py-5');
                    if (navLogoText) { navLogoText.classList.remove('text-white'); navLogoText.classList.add('text-slate-900'); }
                    if (navMenu) { navMenu.classList.remove('text-white/90'); navMenu.classList.add('text-slate-700'); }
                    if (navSearchIcon) { navSearchIcon.classList.remove('text-white'); navSearchIcon.classList.add('text-slate-800'); }
                    if (navFavIcon) { navFavIcon.classList.remove('text-white'); navFavIcon.classList.add('text-slate-800'); }
                    if (navLoginBtn) {
                        navLoginBtn.classList.remove('border-white/40', 'text-white', 'bg-white/10');
                        navLoginBtn.classList.add('border-slate-900', 'text-slate-900', 'hover:bg-slate-900', 'hover:text-white');
                    }
                } else {
                    navbar.classList.remove('bg-white/95', 'backdrop-blur-md', 'shadow-sm', 'py-3.5');
                    navbar.classList.add('py-5');
                    if (navLogoText) { navLogoText.classList.add('text-white'); navLogoText.classList.remove('text-slate-900'); }
                    if (navMenu) { navMenu.classList.add('text-white/90'); navMenu.classList.remove('text-slate-700'); }
                    if (navSearchIcon) { navSearchIcon.classList.add('text-white'); navSearchIcon.classList.remove('text-slate-800'); }
                    if (navFavIcon) { navFavIcon.classList.add('text-white'); navFavIcon.classList.remove('text-slate-800'); }
                    if (navLoginBtn) {
                        navLoginBtn.classList.add('border-white/40', 'text-white', 'bg-white/10');
                        navLoginBtn.classList.remove('border-slate-900', 'text-slate-900', 'hover:bg-slate-900', 'hover:text-white');
                    }
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
