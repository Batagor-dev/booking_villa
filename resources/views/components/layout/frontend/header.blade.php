<!-- NAVBAR -->
<header id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 py-4 md:py-5 px-4 sm:px-6 md:px-16">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Brand Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
            <span class="font-serif-title text-xl sm:text-2xl font-bold tracking-[0.2em] text-white uppercase transition-colors duration-300" id="nav-logo-text">
                PALMA
            </span>
        </a>

        <!-- Desktop Nav Links -->
        <nav class="hidden md:flex items-center gap-7 lg:gap-9 font-satoshi text-xs font-medium uppercase tracking-[0.15em] text-white/90" id="nav-menu">
            <a href="{{ route('home') }}" class="transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1px] after:bg-[#ca9e54] hover:after:w-full after:transition-all {{ request()->routeIs('home') ? 'text-[#ca9e54] font-bold' : '' }}">Beranda</a>
            <a href="{{ route('villa.index') }}" class="transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1px] after:bg-[#ca9e54] hover:after:w-full after:transition-all {{ request()->routeIs('villa.index') ? 'text-[#ca9e54] font-bold' : '' }}">Villa</a>
            <a href="{{ route('wisata.index') }}" class="transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1px] after:bg-[#ca9e54] hover:after:w-full after:transition-all {{ request()->routeIs('wisata.index') ? 'text-[#ca9e54] font-bold' : '' }}">Wisata Bali</a>
            <a href="{{ route('promo.index') }}" class="transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1px] after:bg-[#ca9e54] hover:after:w-full after:transition-all {{ request()->routeIs('promo.index') ? 'text-[#ca9e54] font-bold' : '' }}">Promo</a>
            <a href="{{ route('layanan.index') }}" class="transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1px] after:bg-[#ca9e54] hover:after:w-full after:transition-all {{ request()->routeIs('layanan.index') ? 'text-[#ca9e54] font-bold' : '' }}">Layanan</a>
            
            @auth
                <a href="{{ route('user.bookings') }}" class="transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1px] after:bg-[#ca9e54] hover:after:w-full after:transition-all {{ request()->routeIs('user.bookings') ? 'text-[#ca9e54] font-bold' : '' }}">History Pemesanan</a>
            @endauth
        </nav>

        <!-- Action Buttons & Mobile Toggle -->
        <div class="flex items-center gap-2.5 sm:gap-4">
            <button type="button" class="p-1.5 sm:p-2 text-white hover:text-[#ca9e54] transition-colors focus:outline-none cursor-pointer" id="nav-search-icon" title="Cari Villa & Wisata" aria-label="Buka Pencarian Cepat" aria-controls="quick-search-modal">
                <i class="ri-search-line text-lg sm:text-xl"></i>
            </button>
            
            <!-- Language Toggle Circle Button -->
            <button type="button" id="lang-toggle-btn" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full border border-white/40 hover:border-white bg-white/10 hover:bg-[#152c4e] text-white font-satoshi text-[11px] sm:text-xs font-bold uppercase transition duration-300 flex items-center justify-center cursor-pointer shrink-0" title="Ganti Bahasa" aria-label="Ganti Bahasa (Bahasa Indonesia / English)">
                <span id="current-lang-text">ID</span>
            </button>
            
            @auth
                @php
                    $authUser = auth()->user();
                    $userAvatar = $authUser->foto && \Illuminate\Support\Str::startsWith($authUser->foto, ['http://', 'https://'])
                        ? $authUser->foto
                        : ($authUser->foto && \Illuminate\Support\Str::startsWith($authUser->foto, 'avatar-')
                            ? asset('assets/img/avatar/' . $authUser->foto)
                            : ($authUser->foto 
                                ? asset('storage/uploads/users/' . $authUser->foto) 
                                : null));
                @endphp

                <!-- User Profile Dropdown -->
                <div class="relative">
                    <button type="button" 
                            onclick="toggleUserDropdown(event)"
                            class="w-9 h-9 sm:w-10 sm:h-10 rounded-full overflow-hidden transition duration-300 flex items-center justify-center cursor-pointer shrink-0 hover:scale-105 focus:outline-none" 
                            id="user-menu-btn"
                            title="{{ $authUser->name }}">
                        @if($userAvatar)
                            <img src="{{ $userAvatar }}" alt="{{ $authUser->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-[#ca9e54] text-white flex items-center justify-center font-bold text-xs sm:text-sm">
                                {{ strtoupper(substr($authUser->name, 0, 1)) }}
                            </div>
                        @endif
                    </button>

                    <!-- Dropdown Menu Box -->
                    <div id="user-dropdown-menu" 
                         class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 z-50 text-slate-800 font-satoshi text-xs hidden transition-all duration-200">
                        <div class="px-3 py-2 border-b border-slate-100 flex items-center gap-2.5">
                            @if($userAvatar)
                                <img src="{{ $userAvatar }}" alt="{{ $authUser->name }}" class="w-9 h-9 rounded-full object-cover border border-slate-200 shrink-0">
                            @else
                                <div class="w-9 h-9 rounded-full bg-[#ca9e54] text-white flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($authUser->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <span class="font-bold text-slate-900 block truncate">{{ $authUser->name }}</span>
                                <span class="text-[10px] text-slate-400 block truncate">{{ $authUser->email }}</span>
                            </div>
                        </div>

                        <div class="py-1">
                            <a href="{{ route('user.account') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-50 text-slate-700 font-bold transition">
                                <i class="ri-user-settings-line text-[#ca9e54] text-sm"></i> Kelola Akun
                            </a>

                            @if(method_exists($authUser, 'hasRole') && $authUser->hasRole(['Admin', 'Super Admin', 'admin', 'super-admin']))
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-50 text-slate-700 font-bold transition border-t border-slate-100 mt-1">
                                    <i class="ri-dashboard-line text-[#152c4e] text-sm"></i> Admin Panel
                                </a>
                            @endif
                        </div>

                        <div class="pt-1 border-t border-slate-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-rose-50 text-rose-600 font-bold transition text-left cursor-pointer">
                                    <i class="ri-logout-box-r-line text-sm"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" id="nav-login-btn" class="border border-white/40 hover:border-white bg-white/10 hover:bg-[#152c4e] text-white font-satoshi text-[11px] sm:text-xs font-semibold uppercase tracking-wider px-4 sm:px-6 py-2 sm:py-2.5 rounded-full transition duration-300">
                    Masuk
                </a>
            @endauth

            <!-- Mobile Hamburger Button -->
            <button id="mobile-menu-btn" class="md:hidden p-2 text-white hover:text-[#ca9e54] transition-colors focus:outline-none" aria-label="Buka Menu Navigasi" aria-expanded="false" aria-controls="mobile-drawer">
                <i class="ri-menu-3-line text-2xl" id="mobile-hamburger-icon"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Drawer Overlay Menu -->
    <div id="mobile-drawer" class="fixed inset-0 bg-slate-950/95 backdrop-blur-xl z-50 flex flex-col justify-between p-8 text-white transform transition-transform duration-300 translate-x-full md:hidden" aria-hidden="true">
        <div class="flex items-center justify-between border-b border-white/10 pb-6">
            <span class="font-serif-title text-2xl font-bold tracking-[0.2em] text-white uppercase">PALMA</span>
            <div class="flex items-center gap-3">
                <!-- Mobile Language Circle Button -->
                <button type="button" id="mobile-lang-toggle-btn" class="w-8 h-8 rounded-full border border-white/40 hover:border-white bg-white/10 text-white font-satoshi text-xs font-bold uppercase flex items-center justify-center cursor-pointer shrink-0" aria-label="Ganti Bahasa">
                    <span id="mobile-lang-text">ID</span>
                </button>
                <button id="mobile-close-btn" class="p-2 text-slate-400 hover:text-white text-2xl focus:outline-none" aria-label="Tutup Menu Navigasi">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        </div>

        <nav class="flex flex-col gap-6 py-8 font-satoshi text-base font-medium tracking-wider uppercase">
            <a href="{{ route('home') }}" class="mobile-nav-link text-white/90 hover:text-[#ca9e54] transition-colors py-2 border-b border-white/5 flex items-center justify-between">
                <span>Beranda</span>
                <i class="ri-arrow-right-s-line text-slate-500"></i>
            </a>
            <a href="{{ route('villa.index') }}" class="mobile-nav-link text-white/90 hover:text-[#ca9e54] transition-colors py-2 border-b border-white/5 flex items-center justify-between">
                <span>Villa</span>
                <i class="ri-arrow-right-s-line text-slate-500"></i>
            </a>
            <a href="{{ route('wisata.index') }}" class="mobile-nav-link text-white/90 hover:text-[#ca9e54] transition-colors py-2 border-b border-white/5 flex items-center justify-between">
                <span>Wisata Bali</span>
                <i class="ri-arrow-right-s-line text-slate-500"></i>
            </a>
            <a href="{{ route('promo.index') }}" class="mobile-nav-link text-white/90 hover:text-[#ca9e54] transition-colors py-2 border-b border-white/5 flex items-center justify-between">
                <span>Promo</span>
                <i class="ri-arrow-right-s-line text-slate-500"></i>
            </a>
            <a href="{{ route('layanan.index') }}" class="mobile-nav-link text-white/90 hover:text-[#ca9e54] transition-colors py-2 border-b border-white/5 flex items-center justify-between">
                <span>Layanan Concierge</span>
                <i class="ri-arrow-right-s-line text-slate-500"></i>
            </a>
            @auth
                <a href="{{ route('user.bookings') }}" class="mobile-nav-link text-white/90 hover:text-[#ca9e54] transition-colors py-2 border-b border-white/5 flex items-center justify-between">
                    <span>History Pemesanan</span>
                    <i class="ri-arrow-right-s-line text-slate-500"></i>
                </a>
            @endauth
        </nav>

        <div class="space-y-4 pt-6 border-t border-white/10 text-center">
            @auth
                <div class="space-y-2">
                    <a href="{{ route('user.bookings') }}" class="block w-full bg-[#ca9e54] text-white font-semibold uppercase text-xs tracking-wider py-3 rounded-full shadow-lg">
                        <i class="ri-calendar-event-line mr-1"></i> My Bookings & Riwayat
                    </a>
                    <a href="{{ route('user.account') }}" class="block w-full bg-white/10 border border-white/20 text-white font-semibold uppercase text-xs tracking-wider py-3 rounded-full">
                        <i class="ri-user-settings-line mr-1"></i> Kelola Akun
                    </a>
                    @if(method_exists(auth()->user(), 'hasRole') && auth()->user()->hasRole(['Admin', 'Super Admin', 'admin', 'super-admin']))
                        <a href="{{ route('dashboard') }}" class="block w-full bg-white/10 text-white font-semibold uppercase text-xs tracking-wider py-2.5 rounded-full">
                            Admin Panel
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="pt-1">
                        @csrf
                        <button type="submit" class="w-full text-rose-400 hover:text-rose-300 text-xs font-bold py-2">
                            Keluar
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="block w-full bg-[#ca9e54] text-white font-semibold uppercase text-xs tracking-wider py-3.5 rounded-full shadow-lg">
                    Masuk ke Akun
                </a>
            @endauth
            <p class="text-[11px] text-slate-400 font-light">&copy; {{ date('Y') }} Palma Luxury Sanctuary</p>
        </div>
    </div>
</header>

<!-- QUICK LIVE SEARCH MODAL -->
<div id="quick-search-modal" onclick="closeSearchModal()" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-[60] flex items-start justify-center pt-16 sm:pt-24 px-4 hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl border border-slate-100 font-satoshi transform scale-95 transition-transform duration-300" id="quick-search-box" onclick="event.stopPropagation()">
        
        <!-- Input Header -->
        <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center gap-3">
            <i class="ri-search-line text-xl sm:text-2xl text-[#ca9e54]"></i>
            <input type="text" id="quick-search-input" placeholder="Cari villa, lokasi (Seminyak, Ubud...), atau wisata..." class="w-full text-sm sm:text-base font-semibold text-slate-900 focus:outline-none placeholder:text-slate-400 placeholder:font-normal">
            <button id="quick-search-close" class="p-1.5 text-slate-400 hover:text-slate-700 text-xl focus:outline-none">
                <i class="ri-close-line"></i>
            </button>
        </div>

        <!-- Live Results Container -->
        <div class="p-4 sm:p-6 max-h-[60vh] overflow-y-auto no-scrollbar" id="quick-search-results">
            <span class="text-[10px] uppercase font-bold tracking-widest text-slate-400 block mb-3">Rekomendasi Populer</span>
            
            <div class="space-y-3" id="search-list">
                <!-- Initial dummy items rendered via JS -->
            </div>
        </div>

        <!-- Footer -->
        <div class="p-3 sm:p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500 font-medium">
            <span>Tekan <kbd class="px-1.5 py-0.5 bg-white border border-slate-200 rounded text-[10px] font-mono">ESC</kbd> untuk menutup</span>
            <a href="{{ route('villa.index') }}" class="text-[#152c4e] hover:text-[#ca9e54] font-bold">Lihat Semua Villa &rarr;</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchBtn = document.getElementById('nav-search-icon');
        const searchModal = document.getElementById('quick-search-modal');
        const searchBox = document.getElementById('quick-search-box');
        const searchClose = document.getElementById('quick-search-close');
        const searchInput = document.getElementById('quick-search-input');
        const searchList = document.getElementById('search-list');

        const dummySearchData = [
            { title: "Villa Azure Paradise", category: "Villa Mewah", location: "Seminyak, Bali", price: "$450 / malam", image: "https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=300&q=75", link: "{{ route('villa.show', 1) }}" },
            { title: "Villa Ocean Breeze", category: "Villa Cliffside", location: "Uluwatu, Bali", price: "$680 / malam", image: "https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=300&q=75", link: "{{ route('villa.show', 1) }}" },
            { title: "Villa Tropical Serenity", category: "Villa Nature", location: "Canggu, Bali", price: "$320 / malam", image: "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=300&q=75", link: "{{ route('villa.show', 1) }}" },
            { title: "Villa Sunset Cliff", category: "Villa Ocean View", location: "Nusa Dua, Bali", price: "$550 / malam", image: "https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=300&q=75", link: "{{ route('villa.show', 1) }}" },
            { title: "Villa Emerald Hills", category: "Jungle Sanctuary", location: "Ubud, Bali", price: "$280 / malam", image: "https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=300&q=75", link: "{{ route('villa.show', 1) }}" },
            { title: "Villa Coastal Dream", category: "Beachfront Villa", location: "Jimbaran, Bali", price: "$420 / malam", image: "https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=300&q=75", link: "{{ route('villa.show', 1) }}" },
            { title: "Seminyak Beach & Beach Club", category: "Wisata Populer", location: "Seminyak, Bali", price: "Sunset & Lifestyle", image: "https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=300&q=75", link: "{{ route('wisata.index') }}" },
            { title: "Tegallalang & Monkey Forest", category: "Wisata Alam", location: "Ubud, Bali", price: "Hutan & Sawah", image: "https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=300&q=75", link: "{{ route('wisata.index') }}" },
            { title: "Pura Uluwatu & Tari Kecak", category: "Wisata Budaya", location: "Uluwatu, Bali", price: "Tebing & Kecak", image: "https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=300&q=75", link: "{{ route('wisata.index') }}" }
        ];

        function renderResults(filteredItems) {
            if (!searchList) return;
            if (filteredItems.length === 0) {
                searchList.innerHTML = `<div class="text-center py-8 text-slate-400 text-xs">Tidak ada villa atau wisata yang cocok dengan pencarian Anda.</div>`;
                return;
            }
            searchList.innerHTML = filteredItems.map(item => `
                <a href="${item.link}" class="flex items-center gap-3.5 p-2.5 rounded-2xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100 group">
                    <img src="${item.image}" alt="${item.title}" class="w-14 h-14 rounded-xl object-cover shrink-0">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-[#ca9e54]/10 text-[#ca9e54] uppercase">${item.category}</span>
                            <span class="text-[11px] text-slate-400 truncate">${item.location}</span>
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors truncate">${item.title}</h4>
                    </div>
                    <span class="text-xs font-bold text-[#152c4e] shrink-0">${item.price}</span>
                </a>
            `).join('');
        }

        function openSearchModal() {
            if (!searchModal) return;
            searchModal.classList.remove('hidden');
            setTimeout(() => {
                searchModal.classList.remove('opacity-0');
                if (searchBox) searchBox.classList.remove('scale-95');
                if (searchInput) searchInput.focus();
            }, 10);
            renderResults(dummySearchData);
        }

        function closeSearchModal() {
            if (!searchModal) return;
            searchModal.classList.add('opacity-0');
            if (searchBox) searchBox.classList.add('scale-95');
            setTimeout(() => {
                searchModal.classList.add('hidden');
            }, 300);
        }

        if (searchBtn) searchBtn.addEventListener('click', openSearchModal);
        if (searchClose) searchClose.addEventListener('click', closeSearchModal);

        if (searchModal) {
            searchModal.addEventListener('click', (e) => {
                if (e.target === searchModal) closeSearchModal();
            });
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeSearchModal();
        });

        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.toLowerCase().trim();
                if (!query) {
                    renderResults(dummySearchData);
                    return;
                }
                const filtered = dummySearchData.filter(item => 
                    item.title.toLowerCase().includes(query) ||
                    item.location.toLowerCase().includes(query) ||
                    item.category.toLowerCase().includes(query)
                );
                renderResults(filtered);
            });
        }

        // Language Toggle ID <-> EN JS Handler
        const langToggleBtn = document.getElementById('lang-toggle-btn');
        const langText = document.getElementById('current-lang-text');
        const mobileLangBtn = document.getElementById('mobile-lang-toggle-btn');
        const mobileLangText = document.getElementById('mobile-lang-text');

        function toggleLanguage() {
            const newLang = (langText && langText.innerText === 'ID') ? 'EN' : 'ID';
            if (langText) langText.innerText = newLang;
            if (mobileLangText) mobileLangText.innerText = newLang;
        }

        if (langToggleBtn) langToggleBtn.addEventListener('click', toggleLanguage);
        if (mobileLangBtn) mobileLangBtn.addEventListener('click', toggleLanguage);
    });

    // User Profile Dropdown Toggle Function
    window.toggleUserDropdown = function(event) {
        if (event) event.stopPropagation();
        const menu = document.getElementById('user-dropdown-menu');
        const arrow = document.getElementById('user-menu-arrow');
        if (!menu) return;

        const isHidden = menu.classList.contains('hidden');
        if (isHidden) {
            menu.classList.remove('hidden');
            if (arrow) arrow.classList.add('rotate-180');
        } else {
            menu.classList.add('hidden');
            if (arrow) arrow.classList.remove('rotate-180');
        }
    };

    document.addEventListener('click', function(event) {
        const menu = document.getElementById('user-dropdown-menu');
        const btn = document.getElementById('user-menu-btn');
        const arrow = document.getElementById('user-menu-arrow');
        if (menu && !menu.classList.contains('hidden') && btn && !btn.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('hidden');
            if (arrow) arrow.classList.remove('rotate-180');
        }
    });

    // Global Require Login Modal Functions
    window.openRequireLoginModal = function(redirectTarget = null) {
        const modal = document.getElementById('require-login-modal');
        const box = document.getElementById('require-login-box');
        const loginLink = document.getElementById('modal-login-btn-link');

        if (redirectTarget && loginLink) {
            loginLink.href = "{{ route('login') }}?redirect=" + encodeURIComponent(redirectTarget);
        } else if (loginLink) {
            loginLink.href = "{{ route('login') }}";
        }

        if (modal) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                if (box) box.classList.remove('scale-95');
            }, 10);
        }
    };

    window.closeRequireLoginModal = function() {
        const modal = document.getElementById('require-login-modal');
        const box = document.getElementById('require-login-box');
        if (modal) {
            modal.classList.add('opacity-0');
            if (box) box.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    };
</script>

<!-- REQUIRE LOGIN MODAL BOX -->
<div id="require-login-modal" onclick="closeRequireLoginModal()" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-[90] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300 font-satoshi">
    <div class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl border border-slate-100 p-6 sm:p-8 text-center transform scale-95 transition-transform duration-300 relative space-y-5" id="require-login-box" onclick="event.stopPropagation()">
        
        <!-- Close Button -->
        <button type="button" onclick="closeRequireLoginModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition cursor-pointer">
            <i class="ri-close-line text-lg"></i>
        </button>

        <!-- Lock Icon Header -->
        <div class="w-16 h-16 rounded-full bg-amber-50 text-[#ca9e54] border border-amber-200 flex items-center justify-center text-3xl mx-auto shadow-sm">
            <i class="ri-lock-2-line"></i>
        </div>

        <div>
            <span class="text-[10px] uppercase font-bold tracking-[0.2em] text-[#ca9e54] block mb-1">Akses Pemesanan Terbatas</span>
            <h3 class="font-serif-title text-2xl font-bold text-slate-900">Login Diperlukan</h3>
            <p class="text-xs text-slate-500 font-medium leading-relaxed mt-2">
                Silakan masuk ke akun Anda atau daftar sebagai pengguna baru terlebih dahulu untuk melanjutkan proses reservasi villa ini.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-2.5 pt-2">
            <a href="{{ route('login') }}" id="modal-login-btn-link" class="block w-full bg-[#152c4e] hover:bg-[#0f1d32] text-white font-bold py-3.5 px-4 rounded-2xl text-xs uppercase tracking-wider transition shadow-md">
                <i class="ri-login-box-line mr-1 text-sm"></i> Masuk Ke Akun Anda
            </a>
            
            <a href="{{ route('register') }}" class="block w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-3.5 px-4 rounded-2xl text-xs uppercase tracking-wider border border-slate-200 transition">
                <i class="ri-user-add-line mr-1 text-sm"></i> Buat Akun Baru
            </a>
        </div>

        <button type="button" onclick="closeRequireLoginModal()" class="text-[11px] text-slate-400 hover:text-slate-600 font-semibold block mx-auto pt-1">
            Nanti Saja / Kembalikan Ke Detail Villa
        </button>

    </div>
</div>


