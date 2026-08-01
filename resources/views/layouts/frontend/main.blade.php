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
    
    <!-- Vendor & RemixIcon CDN Fallback -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Luxury UI CSS Helpers -->
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .glass-dark {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .gold-gradient-text {
            background: linear-gradient(135deg, #f5e6c8 0%, #ca9e54 50%, #b88c43 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gold-glow {
            box-shadow: 0 0 25px -5px rgba(202, 158, 84, 0.4);
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans bg-[#f8f9fb] text-slate-800 antialiased selection:bg-[#ca9e54] selection:text-white">

    <!-- FRONTEND SKELETON PAGE LOADING OVERLAY -->
    <div id="frontend-skeleton-page-loader" class="fixed inset-0 z-[100] bg-[#f8f9fb] flex flex-col justify-between p-6 sm:p-12 transition-opacity duration-500 ease-out pointer-events-none">
        <!-- Header Skeleton -->
        <div class="max-w-7xl w-full mx-auto flex items-center justify-between">
            <div class="h-7 w-28 rounded-xl skeleton-shimmer"></div>
            <div class="hidden md:flex gap-8">
                <div class="h-4 w-16 rounded-lg skeleton-shimmer"></div>
                <div class="h-4 w-16 rounded-lg skeleton-shimmer"></div>
                <div class="h-4 w-16 rounded-lg skeleton-shimmer"></div>
            </div>
            <div class="h-9 w-24 rounded-full skeleton-shimmer"></div>
        </div>
        
        <!-- Hero Skeleton -->
        <div class="max-w-3xl w-full mx-auto space-y-5 text-center my-auto">
            <div class="h-3 w-36 rounded-full skeleton-shimmer mx-auto"></div>
            <div class="h-10 sm:h-14 w-4/5 rounded-2xl skeleton-shimmer mx-auto"></div>
            <div class="h-5 w-3/5 rounded-xl skeleton-shimmer mx-auto"></div>
            <div class="h-12 w-full max-w-md rounded-full skeleton-shimmer mx-auto pt-2"></div>
        </div>

        <!-- Cards Grid Skeleton -->
        <div class="max-w-7xl w-full mx-auto grid grid-cols-1 sm:grid-cols-3 gap-6 pt-6 border-t border-slate-200/60 hidden sm:grid">
            <div class="h-24 rounded-2xl skeleton-shimmer"></div>
            <div class="h-24 rounded-2xl skeleton-shimmer"></div>
            <div class="h-24 rounded-2xl skeleton-shimmer"></div>
        </div>
    </div>

    <!-- FAST TOP PROGRESS BAR -->
    <div id="global-progress-bar" class="fixed top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#ca9e54] via-[#e5c382] to-[#152c4e] z-[101] transition-all duration-300 ease-out"></div>

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
        const langToggleBtn = document.getElementById('lang-toggle-btn');
        const navLoginBtn = document.getElementById('nav-login-btn');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileCloseBtn = document.getElementById('mobile-close-btn');
        const mobileDrawer = document.getElementById('mobile-drawer');
        const mobileHamburgerIcon = document.getElementById('mobile-hamburger-icon');
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

        if (navbar) {
            const isHomePage = @json(request()->routeIs('home'));

            function updateNavbarState() {
                if (!isHomePage || window.scrollY > 40) {
                    navbar.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-sm', 'border-b', 'border-slate-100', 'py-3');
                    navbar.classList.remove('py-4', 'md:py-5');
                    if (navLogoText) { navLogoText.classList.remove('text-white'); navLogoText.classList.add('text-slate-900'); }
                    if (navMenu) { navMenu.classList.remove('text-white/90'); navMenu.classList.add('text-slate-700'); }
                    if (navSearchIcon) { navSearchIcon.classList.remove('text-white'); navSearchIcon.classList.add('text-slate-800'); }
                    if (navFavIcon) { navFavIcon.classList.remove('text-white'); navFavIcon.classList.add('text-slate-800'); }
                    if (mobileHamburgerIcon) { mobileHamburgerIcon.classList.remove('text-white'); mobileHamburgerIcon.classList.add('text-slate-900'); }
                    if (langToggleBtn) {
                        langToggleBtn.classList.remove('border-white/40', 'text-white', 'bg-white/10');
                        langToggleBtn.classList.add('border-slate-900', 'text-slate-900', 'hover:bg-slate-900', 'hover:text-white');
                    }
                    if (navLoginBtn) {
                        navLoginBtn.classList.remove('border-white/40', 'text-white', 'bg-white/10');
                        navLoginBtn.classList.add('border-slate-900', 'text-slate-900', 'hover:bg-slate-900', 'hover:text-white');
                    }
                } else {
                    navbar.classList.remove('bg-white/95', 'backdrop-blur-md', 'shadow-sm', 'border-b', 'border-slate-100', 'py-3');
                    navbar.classList.add('py-4', 'md:py-5');
                    if (navLogoText) { navLogoText.classList.add('text-white'); navLogoText.classList.remove('text-slate-900'); }
                    if (navMenu) { navMenu.classList.add('text-white/90'); navMenu.classList.remove('text-slate-700'); }
                    if (navSearchIcon) { navSearchIcon.classList.add('text-white'); navSearchIcon.classList.remove('text-slate-800'); }
                    if (navFavIcon) { navFavIcon.classList.add('text-white'); navFavIcon.classList.remove('text-slate-800'); }
                    if (mobileHamburgerIcon) { mobileHamburgerIcon.classList.add('text-white'); mobileHamburgerIcon.classList.remove('text-slate-900'); }
                    if (langToggleBtn) {
                        langToggleBtn.classList.add('border-white/40', 'text-white', 'bg-white/10');
                        langToggleBtn.classList.remove('border-slate-900', 'text-slate-900', 'hover:bg-slate-900', 'hover:text-white');
                    }
                    if (navLoginBtn) {
                        navLoginBtn.classList.add('border-white/40', 'text-white', 'bg-white/10');
                        navLoginBtn.classList.remove('border-slate-900', 'text-slate-900', 'hover:bg-slate-900', 'hover:text-white');
                    }
                }
            }

            updateNavbarState();
            window.addEventListener('scroll', updateNavbarState);
        }

        // Mobile Drawer Toggle
        if (mobileMenuBtn && mobileDrawer) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileDrawer.classList.remove('translate-x-full');
                mobileDrawer.setAttribute('aria-hidden', 'false');
                mobileMenuBtn.setAttribute('aria-expanded', 'true');
                document.body.classList.add('overflow-hidden');
            });
        }

        if (mobileCloseBtn && mobileDrawer) {
            mobileCloseBtn.addEventListener('click', () => {
                mobileDrawer.classList.add('translate-x-full');
                mobileDrawer.setAttribute('aria-hidden', 'true');
                if (mobileMenuBtn) mobileMenuBtn.setAttribute('aria-expanded', 'false');
                document.body.classList.remove('overflow-hidden');
            });
        }

        mobileNavLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (mobileDrawer) {
                    mobileDrawer.classList.add('translate-x-full');
                    mobileDrawer.setAttribute('aria-hidden', 'true');
                }
                if (mobileMenuBtn) mobileMenuBtn.setAttribute('aria-expanded', 'false');
                document.body.classList.remove('overflow-hidden');
            });
        });

        // Frontend Page Skeleton Loader & Top Progress Bar Fadeout
        function dismissSkeletonPageLoader() {
            const skeletonLoader = document.getElementById('frontend-skeleton-page-loader');
            const progressBar = document.getElementById('global-progress-bar');
            
            if (progressBar) {
                progressBar.style.width = '100%';
                setTimeout(() => {
                    progressBar.style.opacity = '0';
                    setTimeout(() => progressBar.remove(), 400);
                }, 200);
            }

            if (skeletonLoader) {
                setTimeout(() => {
                    skeletonLoader.style.opacity = '0';
                    setTimeout(() => skeletonLoader.remove(), 450);
                }, 150);
            }
        }

        if (document.readyState === 'complete') {
            dismissSkeletonPageLoader();
        } else {
            window.addEventListener('load', dismissSkeletonPageLoader);
            document.addEventListener('DOMContentLoaded', () => setTimeout(dismissSkeletonPageLoader, 300));
        }
    </script>

    @stack('scripts')
</body>
</html>
