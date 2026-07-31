<!-- NAVBAR -->
<header id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 py-5 px-6 md:px-16">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Brand Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
            <span class="font-serif-title text-2xl font-bold tracking-[0.2em] text-white uppercase transition-colors duration-300" id="nav-logo-text">
                PALMA
            </span>
        </a>

        <!-- Nav Links -->
        <nav class="hidden md:flex items-center gap-10 font-satoshi text-xs font-medium uppercase tracking-[0.15em] text-white/90" id="nav-menu">
            <a href="#villa" class="hover:text-white transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1px] after:bg-[#ca9e54] hover:after:w-full after:transition-all">Villa</a>
            <a href="#destinasi" class="hover:text-white transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1px] after:bg-[#ca9e54] hover:after:w-full after:transition-all">Destinasi</a>
            <a href="#pengalaman" class="hover:text-white transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1px] after:bg-[#ca9e54] hover:after:w-full after:transition-all">Layanan</a>
            <a href="#tentang" class="hover:text-white transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1px] after:bg-[#ca9e54] hover:after:w-full after:transition-all">Tentang</a>
        </nav>

        <!-- Action Buttons -->
        <div class="flex items-center gap-5">
            <button class="p-2 text-white hover:text-[#ca9e54] transition-colors" id="nav-search-icon" title="Cari">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
            <button class="p-2 text-white hover:text-[#ca9e54] transition-colors" id="nav-fav-icon" title="Favorit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                </svg>
            </button>
            @auth
                <a href="{{ route('dashboard') }}" class="bg-[#ca9e54] hover:bg-[#b88c43] text-white font-satoshi text-xs font-semibold uppercase tracking-wider px-6 py-2.5 rounded-full transition duration-300 shadow-sm hover:shadow-md">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" id="nav-login-btn" class="border border-white/40 hover:border-white bg-white/10 hover:bg-white text-white hover:text-slate-900 font-satoshi text-xs font-semibold uppercase tracking-wider px-6 py-2.5 rounded-full transition duration-300">
                    Masuk
                </a>
            @endauth
        </div>
    </div>
</header>
