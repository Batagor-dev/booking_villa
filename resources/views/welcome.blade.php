<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Niskala - Pelarian Mewah & Villa Impian Anda</title>
    
    <!-- Preconnect & Google Fonts (Non-blocking display=swap) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-[#f8f9fb] text-slate-800 antialiased selection:bg-[#ca9e54] selection:text-white">

    <!-- NAVBAR -->
    <header id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 py-4 px-6 md:px-12">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full bg-navy-main flex items-center justify-center text-white font-bold text-xl shadow-md group-hover:scale-105 transition-transform duration-300">
                    N
                </div>
                <span class="font-serif-title text-2xl font-bold tracking-tight text-white transition-colors duration-300" id="nav-logo-text">
                    Niskala
                </span>
            </a>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center gap-8 font-medium text-white/90" id="nav-menu">
                <a href="#villa" class="hover:text-white transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-[#ca9e54] hover:after:w-full after:transition-all">Villa</a>
                <a href="#destinasi" class="hover:text-white transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-[#ca9e54] hover:after:w-full after:transition-all">Destinasi</a>
                <a href="#promo" class="hover:text-white transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-[#ca9e54] hover:after:w-full after:transition-all">Promo</a>
                <a href="#tentang" class="hover:text-white transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-[#ca9e54] hover:after:w-full after:transition-all">Tentang</a>
            </nav>

            <!-- Action Buttons -->
            <div class="flex items-center gap-4">
                <button class="p-2.5 rounded-full text-white hover:bg-white/10 transition-colors" id="nav-search-icon" title="Cari">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                <button class="p-2.5 rounded-full text-white hover:bg-white/10 transition-colors" id="nav-fav-icon" title="Favorit">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
                <a href="#masuk" class="bg-white text-navy-main hover:bg-slate-100 font-semibold px-6 py-2.5 rounded-full shadow-md transition duration-300 hover:shadow-lg">
                    Masuk
                </a>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative min-h-screen flex items-center justify-center pt-24 pb-36 px-6 overflow-hidden">
        <!-- Hero Background Image (Optimized High Priority Image) -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1400&q=80" 
                 alt="Luxury Villa Resort" 
                 fetchpriority="high"
                 decoding="async"
                 class="w-full h-full object-cover object-center scale-105 transition-transform duration-10000 hover:scale-100">
            <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/30 to-black/70"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 max-w-4xl mx-auto text-center text-white mt-8">
            <!-- Badge Tag -->
            <div class="inline-flex items-center gap-2 glass-pill px-4 py-1.5 rounded-full text-sm font-medium tracking-wide mb-6 shadow-inner animate-pulse">
                <svg class="w-4 h-4 text-[#e5c382]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l2.4 7.4H22l-6 4.5 2.3 7.1-6.3-4.6-6.3 4.6 2.3-7.1-6-4.5h7.6z"/>
                </svg>
                <span>Pelarian Mewah Eksklusif</span>
            </div>

            <!-- Title -->
            <h1 class="font-serif-title text-4xl md:text-6xl lg:text-7xl font-bold leading-tight md:leading-none tracking-tight mb-6">
                Temukan Villa <br class="hidden md:inline"/>
                <span class="bg-gradient-to-r from-[#f8e5be] via-[#e5c382] to-[#ca9e54] bg-clip-text text-transparent italic">
                    Impian Anda
                </span>
            </h1>

            <!-- Subtitle -->
            <p class="text-lg md:text-xl text-white/90 font-light max-w-2xl mx-auto mb-10 leading-relaxed">
                Koleksi pilihan villa luar biasa di lokasi paling menakjubkan. Dimana kemewahan bertemu dengan ketenangan.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#villa" class="w-full sm:w-auto bg-[#ca9e54] hover:bg-[#b88c43] text-white font-semibold px-8 py-4 rounded-full shadow-lg hover:shadow-xl transition duration-300 flex items-center justify-center gap-2 group">
                    <span>Pesan Sekarang</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <a href="#destinasi" class="w-full sm:w-auto glass-pill hover:bg-white/30 text-white font-medium px-8 py-4 rounded-full transition duration-300 flex items-center justify-center">
                    Jelajahi Villa
                </a>
            </div>
        </div>

        <!-- FLOATING SEARCH BAR -->
        <div class="absolute bottom-6 left-6 right-6 md:left-12 md:right-12 z-20 max-w-6xl mx-auto transform translate-y-1/2 md:translate-y-1/3">
            <div class="glass-card rounded-2xl p-4 md:p-6 shadow-2xl border border-white/60">
                <form class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                    <!-- Destinasi -->
                    <div class="p-3 rounded-xl hover:bg-slate-50/80 transition-colors border border-transparent hover:border-slate-200">
                        <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase mb-1">DESTINASI</label>
                        <div class="flex items-center gap-2 text-slate-700">
                            <svg class="w-5 h-5 text-[#ca9e54] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <input type="text" placeholder="Bali, Ubud, Seminyak..." class="w-full bg-transparent text-sm font-semibold text-slate-800 focus:outline-none placeholder:text-slate-400">
                        </div>
                    </div>

                    <!-- Check In -->
                    <div class="p-3 rounded-xl hover:bg-slate-50/80 transition-colors border border-transparent hover:border-slate-200">
                        <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase mb-1">CHECK IN</label>
                        <div class="flex items-center gap-2 text-slate-700">
                            <svg class="w-5 h-5 text-[#ca9e54] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <input type="text" onfocus="(this.type='date')" placeholder="Pilih tanggal" class="w-full bg-transparent text-sm font-semibold text-slate-800 focus:outline-none placeholder:text-slate-400">
                        </div>
                    </div>

                    <!-- Tamu -->
                    <div class="p-3 rounded-xl hover:bg-slate-50/80 transition-colors border border-transparent hover:border-slate-200">
                        <label class="block text-xs font-bold tracking-wider text-slate-400 uppercase mb-1">TAMU</label>
                        <div class="flex items-center gap-2 text-slate-700">
                            <svg class="w-5 h-5 text-[#ca9e54] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <select class="w-full bg-transparent text-sm font-semibold text-slate-800 focus:outline-none">
                                <option value="2">2 tamu</option>
                                <option value="4">4 tamu</option>
                                <option value="6">6+ tamu</option>
                            </select>
                        </div>
                    </div>

                    <!-- Search & Filter Button -->
                    <div class="flex items-center gap-2">
                        <button type="submit" class="flex-1 bg-navy-main hover:bg-navy-dark text-white font-semibold py-3.5 px-6 rounded-xl shadow-lg transition duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span>Cari</span>
                        </button>
                        <button type="button" class="p-3.5 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition-colors" title="Filter Tambahan">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- SECTION: FEATURED VILLA ("Villa Mewah Terpilih") -->
    <section id="villa" class="pt-32 pb-20 px-6 md:px-12 max-w-7xl mx-auto section-lazy">
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-16">
            <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 mb-3">
                <svg class="w-3.5 h-3.5 text-[#ca9e54]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l2.4 7.4H22l-6 4.5 2.3 7.1-6.3-4.6-6.3 4.6 2.3-7.1-6-4.5h7.6z"/>
                </svg>
                <span>Koleksi Pilihan</span>
            </div>
            <h2 class="font-serif-title text-3xl md:text-5xl font-bold text-navy-main mb-4">
                Villa Mewah Terpilih
            </h2>
            <p class="text-slate-600 font-light text-base md:text-lg">
                Temukan pilihan properti luar biasa kami di destinasi paling menakjubkan di dunia
            </p>
        </div>

        <!-- Villa Grid (6 Cards) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">

            <!-- Villa Card 1 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-64 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=600&q=75" 
                         alt="Villa Azure Paradise" 
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover img-zoom">
                    <div class="absolute top-4 left-4 flex gap-2">
                        <span class="bg-[#ca9e54] text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">-30% OFF</span>
                        <span class="bg-white/90 backdrop-blur-md text-slate-800 text-xs font-semibold px-3 py-1 rounded-full shadow-md">Pilihan</span>
                    </div>
                    <button class="absolute top-4 right-4 p-2 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 transition-colors shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-navy-main transition-colors">
                                Villa Azure Paradise
                            </h3>
                            <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
                                <svg class="w-4 h-4 text-[#ca9e54]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2.4 7.4H22l-6 4.5 2.3 7.1-6.3-4.6-6.3 4.6 2.3-7.1-6-4.5h7.6z"/></svg>
                                <span>4.9</span> <span class="text-xs font-normal text-slate-400">(127)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1 mb-4">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            Seminyak, Bali
                        </p>
                        <div class="flex items-center gap-4 text-xs text-slate-600 pt-3 border-t border-slate-100 mb-6">
                            <span>🛏️ 5 Kamar</span>
                            <span>🛁 4 Kamar Mandi</span>
                            <span>👥 10 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2">
                        <div>
                            <span class="text-xs text-slate-400 line-through mr-1.5">$650</span>
                            <span class="text-2xl font-bold text-navy-main">$450</span>
                            <span class="text-xs font-normal text-slate-500">/malam</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Villa Card 2 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-64 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=600&q=75" 
                         alt="Villa Ocean Breeze" 
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover img-zoom">
                    <div class="absolute top-4 left-4">
                        <span class="bg-white/90 backdrop-blur-md text-slate-800 text-xs font-semibold px-3 py-1 rounded-full shadow-md">Pilihan</span>
                    </div>
                    <button class="absolute top-4 right-4 p-2 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 transition-colors shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-navy-main transition-colors">
                                Villa Ocean Breeze
                            </h3>
                            <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
                                <svg class="w-4 h-4 text-[#ca9e54]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2.4 7.4H22l-6 4.5 2.3 7.1-6.3-4.6-6.3 4.6 2.3-7.1-6-4.5h7.6z"/></svg>
                                <span>5.0</span> <span class="text-xs font-normal text-slate-400">(89)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1 mb-4">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            Uluwatu, Bali
                        </p>
                        <div class="flex items-center gap-4 text-xs text-slate-600 pt-3 border-t border-slate-100 mb-6">
                            <span>🛏️ 6 Kamar</span>
                            <span>🛁 5 Kamar Mandi</span>
                            <span>👥 12 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2">
                        <div>
                            <span class="text-2xl font-bold text-navy-main">$680</span>
                            <span class="text-xs font-normal text-slate-500">/malam</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Villa Card 3 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-64 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=600&q=75" 
                         alt="Villa Tropical Serenity" 
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover img-zoom">
                    <div class="absolute top-4 left-4">
                        <span class="bg-[#ca9e54] text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">-28% OFF</span>
                    </div>
                    <button class="absolute top-4 right-4 p-2 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 transition-colors shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-navy-main transition-colors">
                                Villa Tropical Serenity
                            </h3>
                            <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
                                <svg class="w-4 h-4 text-[#ca9e54]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2.4 7.4H22l-6 4.5 2.3 7.1-6.3-4.6-6.3 4.6 2.3-7.1-6-4.5h7.6z"/></svg>
                                <span>4.8</span> <span class="text-xs font-normal text-slate-400">(203)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1 mb-4">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            Canggu, Bali
                        </p>
                        <div class="flex items-center gap-4 text-xs text-slate-600 pt-3 border-t border-slate-100 mb-6">
                            <span>🛏️ 4 Kamar</span>
                            <span>🛁 3 Kamar Mandi</span>
                            <span>👥 8 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2">
                        <div>
                            <span class="text-xs text-slate-400 line-through mr-1.5">$450</span>
                            <span class="text-2xl font-bold text-navy-main">$320</span>
                            <span class="text-xs font-normal text-slate-500">/malam</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Villa Card 4 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-64 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=600&q=75" 
                         alt="Villa Sunset Cliff" 
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover img-zoom">
                    <button class="absolute top-4 right-4 p-2 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 transition-colors shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-navy-main transition-colors">
                                Villa Sunset Cliff
                            </h3>
                            <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
                                <svg class="w-4 h-4 text-[#ca9e54]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2.4 7.4H22l-6 4.5 2.3 7.1-6.3-4.6-6.3 4.6 2.3-7.1-6-4.5h7.6z"/></svg>
                                <span>4.9</span> <span class="text-xs font-normal text-slate-400">(156)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1 mb-4">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            Nusa Dua, Bali
                        </p>
                        <div class="flex items-center gap-4 text-xs text-slate-600 pt-3 border-t border-slate-100 mb-6">
                            <span>🛏️ 5 Kamar</span>
                            <span>🛁 4 Kamar Mandi</span>
                            <span>👥 10 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2">
                        <div>
                            <span class="text-2xl font-bold text-navy-main">$550</span>
                            <span class="text-xs font-normal text-slate-500">/malam</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Villa Card 5 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-64 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=600&q=75" 
                         alt="Villa Emerald Hills" 
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover img-zoom">
                    <div class="absolute top-4 left-4">
                        <span class="bg-[#ca9e54] text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">-30% OFF</span>
                    </div>
                    <button class="absolute top-4 right-4 p-2 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 transition-colors shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-navy-main transition-colors">
                                Villa Emerald Hills
                            </h3>
                            <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
                                <svg class="w-4 h-4 text-[#ca9e54]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2.4 7.4H22l-6 4.5 2.3 7.1-6.3-4.6-6.3 4.6 2.3-7.1-6-4.5h7.6z"/></svg>
                                <span>4.7</span> <span class="text-xs font-normal text-slate-400">(94)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1 mb-4">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            Ubud, Bali
                        </p>
                        <div class="flex items-center gap-4 text-xs text-slate-600 pt-3 border-t border-slate-100 mb-6">
                            <span>🛏️ 3 Kamar</span>
                            <span>🛁 3 Kamar Mandi</span>
                            <span>👥 6 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2">
                        <div>
                            <span class="text-xs text-slate-400 line-through mr-1.5">$400</span>
                            <span class="text-2xl font-bold text-navy-main">$280</span>
                            <span class="text-xs font-normal text-slate-500">/malam</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Villa Card 6 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-64 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=600&q=75" 
                         alt="Villa Coastal Dream" 
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover img-zoom">
                    <button class="absolute top-4 right-4 p-2 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 transition-colors shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-navy-main transition-colors">
                                Villa Coastal Dream
                            </h3>
                            <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
                                <svg class="w-4 h-4 text-[#ca9e54]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2.4 7.4H22l-6 4.5 2.3 7.1-6.3-4.6-6.3 4.6 2.3-7.1-6-4.5h7.6z"/></svg>
                                <span>4.8</span> <span class="text-xs font-normal text-slate-400">(178)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1 mb-4">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            Jimbaran, Bali
                        </p>
                        <div class="flex items-center gap-4 text-xs text-slate-600 pt-3 border-t border-slate-100 mb-6">
                            <span>🛏️ 4 Kamar</span>
                            <span>🛁 4 Kamar Mandi</span>
                            <span>👥 8 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2">
                        <div>
                            <span class="text-2xl font-bold text-navy-main">$420</span>
                            <span class="text-xs font-normal text-slate-500">/malam</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Section Action Button -->
        <div class="text-center">
            <a href="#villa" class="inline-flex items-center gap-2 bg-navy-main hover:bg-navy-dark text-white font-semibold px-8 py-3.5 rounded-full shadow-md hover:shadow-lg transition duration-300 group">
                <span>Lihat Semua Villa</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </section>

    <!-- SECTION: PROMO TERBATAS -->
    <section id="promo" class="py-20 px-6 md:px-12 bg-gradient-to-b from-[#f4f6fa] to-[#f8f9fb] section-lazy">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-16">
                <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-50 border border-amber-200 text-xs font-semibold text-amber-800 mb-3">
                    <svg class="w-3.5 h-3.5 text-[#ca9e54]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2.4 7.4H22l-6 4.5 2.3 7.1-6.3-4.6-6.3 4.6 2.3-7.1-6-4.5h7.6z"/></svg>
                    <span>Penawaran Eksklusif</span>
                </div>
                <h2 class="font-serif-title text-3xl md:text-5xl font-bold text-navy-main mb-4">
                    Promo Terbatas
                </h2>
                <p class="text-slate-600 font-light text-base md:text-lg">
                    Jangan lewatkan pengalaman villa premium kami dengan harga terbaik
                </p>
            </div>

            <!-- Top Promo Grid (2 Main Banner Cards) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">

                <!-- Left Promo: Flash Sale -->
                <div class="bg-navy-main text-white rounded-3xl p-8 md:p-10 shadow-xl relative overflow-hidden flex flex-col justify-between group">
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/5 rounded-full blur-2xl group-hover:scale-110 transition-transform"></div>
                    <div>
                        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-3.5 py-1 rounded-full text-xs font-semibold text-[#e5c382] mb-6 border border-white/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Flash Sale</span>
                        </div>
                        <h3 class="font-serif-title text-3xl md:text-4xl font-bold mb-4 leading-tight">
                            Spesial Weekend Escape
                        </h3>
                        <p class="text-white/80 font-light text-sm md:text-base mb-8 max-w-md">
                            Hemat hingga 40% untuk booking weekend di villa mewah pilihan
                        </p>

                        <!-- Countdown Timer -->
                        <div class="flex items-center gap-3 mb-8" id="countdown-timer">
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3 min-w-[70px] text-center border border-white/10">
                                <span class="block text-2xl font-bold font-mono text-[#e5c382]" id="timer-hours">23</span>
                                <span class="text-[10px] uppercase font-bold text-white/60 tracking-wider">JAM</span>
                            </div>
                            <span class="text-xl font-bold text-[#e5c382]">:</span>
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3 min-w-[70px] text-center border border-white/10">
                                <span class="block text-2xl font-bold font-mono text-[#e5c382]" id="timer-minutes">42</span>
                                <span class="text-[10px] uppercase font-bold text-white/60 tracking-wider">MENIT</span>
                            </div>
                            <span class="text-xl font-bold text-[#e5c382]">:</span>
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3 min-w-[70px] text-center border border-white/10">
                                <span class="block text-2xl font-bold font-mono text-[#e5c382]" id="timer-seconds">27</span>
                                <span class="text-[10px] uppercase font-bold text-white/60 tracking-wider">DETIK</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <a href="#booking" class="inline-flex items-center justify-center gap-2 bg-[#ca9e54] hover:bg-[#b88c43] text-white font-semibold px-8 py-3.5 rounded-2xl shadow-lg transition duration-300 w-full sm:w-auto">
                            <span>Ambil Penawaran Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Right Promo: VIP Member Bonus -->
                <div class="bg-gradient-to-br from-[#d4af37] via-[#ca9e54] to-[#b88c43] text-white rounded-3xl p-8 md:p-10 shadow-xl relative overflow-hidden flex flex-col justify-between group">
                    <div class="absolute bottom-0 right-0 -mr-12 -mb-12 w-64 h-64 bg-black/10 rounded-full blur-2xl group-hover:scale-110 transition-transform"></div>
                    <div>
                        <div class="inline-flex items-center gap-2 bg-black/20 backdrop-blur-md px-3.5 py-1 rounded-full text-xs font-semibold text-white mb-6 border border-white/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                            <span>Khusus Member VIP</span>
                        </div>
                        <h3 class="font-serif-title text-3xl md:text-4xl font-bold mb-4 leading-tight">
                            Bonus Booking Pertama
                        </h3>
                        <p class="text-white/90 font-light text-sm md:text-base mb-6 max-w-md">
                            Dapatkan diskon eksklusif 35% untuk reservasi villa pertama Anda
                        </p>

                        <!-- Features list -->
                        <ul class="space-y-2.5 mb-8 text-sm font-medium text-white/95">
                            <li class="flex items-center gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-xs">✨</div>
                                <span>Transfer bandara gratis</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-xs">✨</div>
                                <span>Makan malam selamat datang gratis</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-xs">✨</div>
                                <span>Layanan concierge 24/7</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <a href="#masuk" class="inline-flex items-center justify-center gap-2 bg-white text-slate-900 hover:bg-slate-50 font-bold px-8 py-3.5 rounded-2xl shadow-lg transition duration-300 w-full sm:w-auto">
                            <span>Mulai Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom 3 Promo Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Feature Promo 1 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-navy-main/10 text-navy-main flex items-center justify-center text-xl font-bold mb-4">
                        %
                    </div>
                    <h4 class="font-serif-title text-xl font-bold text-slate-900 mb-2">Spesial Musim Panas</h4>
                    <p class="text-xs text-slate-600 font-light mb-4 leading-relaxed">
                        Hemat 25% untuk booking lebih dari 7 malam
                    </p>
                    <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-navy-main hover:text-[#ca9e54] transition-colors">
                        <span>Pelajari Lebih Lanjut</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <!-- Feature Promo 2 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-[#ca9e54]/10 text-[#ca9e54] flex items-center justify-center text-xl font-bold mb-4">
                        🎁
                    </div>
                    <h4 class="font-serif-title text-xl font-bold text-slate-900 mb-2">Refer & Dapatkan</h4>
                    <p class="text-xs text-slate-600 font-light mb-4 leading-relaxed">
                        Dapatkan kredit $100 untuk setiap referral teman
                    </p>
                    <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-navy-main hover:text-[#ca9e54] transition-colors">
                        <span>Pelajari Lebih Lanjut</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <!-- Feature Promo 3 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-xl font-bold mb-4">
                        🏷️
                    </div>
                    <h4 class="font-serif-title text-xl font-bold text-slate-900 mb-2">Promo Last Minute</h4>
                    <p class="text-xs text-slate-600 font-light mb-4 leading-relaxed">
                        Hingga 50% off untuk booking minggu yang sama
                    </p>
                    <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-navy-main hover:text-[#ca9e54] transition-colors">
                        <span>Pelajari Lebih Lanjut</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: PERBEDAN NISKALA ("Why Choose Us") -->
    <section id="tentang" class="py-24 px-6 md:px-12 bg-white section-lazy">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-16">
                <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 mb-3">
                    <svg class="w-3.5 h-3.5 text-[#ca9e54]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2.4 7.4H22l-6 4.5 2.3 7.1-6.3-4.6-6.3 4.6 2.3-7.1-6-4.5h7.6z"/></svg>
                    <span>Mengapa Memilih Kami</span>
                </div>
                <h2 class="font-serif-title text-3xl md:text-5xl font-bold text-navy-main mb-4">
                    Perbedaan Niskala
                </h2>
                <p class="text-slate-600 font-light text-base md:text-lg">
                    Rasakan kemewahan dan layanan tak tertandingi yang melampaui ekspektasi
                </p>
            </div>

            <!-- Value Cards Grid (3 Columns) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Value 1 -->
                <div class="p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-navy-main text-white flex items-center justify-center mb-6 shadow-md">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="font-serif-title text-2xl font-bold text-slate-900 mb-3">
                        Properti Terverifikasi
                    </h3>
                    <p class="text-slate-600 font-light text-sm leading-relaxed">
                        Setiap villa diperiksa dan diverifikasi secara personal oleh tim ahli kami untuk menjamin standar kualitas tertinggi.
                    </p>
                </div>

                <!-- Value 2 -->
                <div class="p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-[#ca9e54] text-white flex items-center justify-center mb-6 shadow-md">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-serif-title text-2xl font-bold text-slate-900 mb-3">
                        Jaminan Harga Terbaik
                    </h3>
                    <p class="text-slate-600 font-light text-sm leading-relaxed">
                        Temukan harga lebih rendah? Kami akan menyamai dan memberikan 110% kembali dari selisih harga tersebut.
                    </p>
                </div>

                <!-- Value 3 -->
                <div class="p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-teal-600 text-white flex items-center justify-center mb-6 shadow-md">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-serif-title text-2xl font-bold text-slate-900 mb-3">
                        Concierge 24/7
                    </h3>
                    <p class="text-slate-600 font-light text-sm leading-relaxed">
                        Dukungan sepanjang waktu dari booking hingga checkout untuk memastikan pengalaman menginap Anda sempurna.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-navy-dark text-slate-400 pt-20 pb-10 px-6 md:px-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 mb-16">
                <!-- Col 1: Brand Info -->
                <div class="lg:col-span-2">
                    <a href="#" class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-[#ca9e54] flex items-center justify-center text-white font-bold text-xl">
                            N
                        </div>
                        <span class="font-serif-title text-2xl font-bold text-white tracking-tight">
                            Niskala
                        </span>
                    </a>
                    <p class="text-sm font-light text-slate-400 max-w-sm mb-6 leading-relaxed">
                        Platform pemesanan villa mewah eksklusif yang menawarkan keindahan, kenyamanan, dan privasi terbaik untuk pengalaman liburan tak terlupakan.
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-9 h-9 rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-white transition-colors">
                            <span class="sr-only">Instagram</span>
                            📸
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-white transition-colors">
                            <span class="sr-only">Facebook</span>
                            🌐
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-white transition-colors">
                            <span class="sr-only">Twitter</span>
                            🐤
                        </a>
                    </div>
                </div>

                <!-- Col 2: Destinasi -->
                <div>
                    <h4 class="text-white font-semibold text-sm tracking-wider uppercase mb-5">Destinasi</h4>
                    <ul class="space-y-3 text-sm font-light">
                        <li><a href="#" class="hover:text-white transition-colors">Seminyak, Bali</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Ubud, Bali</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Uluwatu, Bali</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Canggu, Bali</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Nusa Dua, Bali</a></li>
                    </ul>
                </div>

                <!-- Col 3: Perusahaan -->
                <div>
                    <h4 class="text-white font-semibold text-sm tracking-wider uppercase mb-5">Perusahaan</h4>
                    <ul class="space-y-3 text-sm font-light">
                        <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Karir</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Mitra Villa</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog & Berita</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>

                <!-- Col 4: Buletin -->
                <div>
                    <h4 class="text-white font-semibold text-sm tracking-wider uppercase mb-5">Buletin</h4>
                    <p class="text-xs text-slate-400 mb-4 font-light">
                        Dapatkan penawaran eksklusif dan berita inspirasi villa langsung ke email Anda.
                    </p>
                    <form class="space-y-2">
                        <input type="email" placeholder="Email Anda..." class="w-full bg-white/5 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white placeholder:text-slate-500 focus:outline-none focus:border-[#ca9e54]">
                        <button type="submit" class="w-full bg-[#ca9e54] hover:bg-[#b88c43] text-white font-semibold text-xs py-2.5 rounded-xl transition duration-300">
                            Berlangganan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 border-t border-slate-800/80 flex flex-col md:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; 2026 Niskala Luxury Villas. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-slate-400 transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-slate-400 transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-slate-400 transition-colors">Peta Situs</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- INTERACTIVE JS -->
    <script>
        // Navbar Scroll Behavior
        const navbar = document.getElementById('navbar');
        const navLogoText = document.getElementById('nav-logo-text');
        const navMenu = document.getElementById('nav-menu');
        const navSearchIcon = document.getElementById('nav-search-icon');
        const navFavIcon = document.getElementById('nav-fav-icon');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-md', 'py-3');
                navbar.classList.remove('py-4');
                navLogoText.classList.remove('text-white');
                navLogoText.classList.add('text-navy-main');
                navMenu.classList.remove('text-white/90');
                navMenu.classList.add('text-slate-700');
                navSearchIcon.classList.remove('text-white');
                navSearchIcon.classList.add('text-slate-700');
                navFavIcon.classList.remove('text-[#ca9e54]');
                navFavIcon.classList.remove('text-white');
                navFavIcon.classList.add('text-slate-700');
            } else {
                navbar.classList.remove('bg-white/95', 'backdrop-blur-md', 'shadow-md', 'py-3');
                navbar.classList.add('py-4');
                navLogoText.classList.add('text-white');
                navLogoText.classList.remove('text-navy-main');
                navMenu.classList.add('text-white/90');
                navMenu.classList.remove('text-slate-700');
                navSearchIcon.classList.add('text-white');
                navSearchIcon.classList.remove('text-slate-700');
                navFavIcon.classList.add('text-white');
                navFavIcon.classList.remove('text-slate-700');
            }
        });

        // Flash Sale Live Timer Animation
        let hours = 23, minutes = 42, seconds = 27;
        const hElem = document.getElementById('timer-hours');
        const mElem = document.getElementById('timer-minutes');
        const sElem = document.getElementById('timer-seconds');

        setInterval(() => {
            if (seconds > 0) {
                seconds--;
            } else {
                seconds = 59;
                if (minutes > 0) {
                    minutes--;
                } else {
                    minutes = 59;
                    if (hours > 0) hours--;
                }
            }
            if (hElem) hElem.innerText = String(hours).padStart(2, '0');
            if (mElem) mElem.innerText = String(minutes).padStart(2, '0');
            if (sElem) sElem.innerText = String(seconds).padStart(2, '0');
        }, 1000);
    </script>
</body>
</html>