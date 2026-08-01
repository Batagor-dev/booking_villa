@extends('layouts.frontend.main')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative min-h-screen flex flex-col justify-between pt-20 sm:pt-24 md:pt-28 pb-6 sm:pb-10 px-4 sm:px-6 font-satoshi overflow-hidden">
        <!-- Hero Background Image -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=80" 
                 alt="Luxury Villa Resort" 
                 fetchpriority="high"
                 decoding="async"
                 class="w-full h-full object-cover object-center scale-105 transition-transform duration-10000 hover:scale-100">
            <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/60 to-black/90"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 max-w-4xl mx-auto text-center text-white space-y-4 sm:space-y-6 my-auto pt-8 sm:pt-12">
            <!-- Editorial Subhead Text -->
            <span class="text-[10px] sm:text-xs font-bold tracking-[0.25em] text-[#e5c382] uppercase block mb-1">
                Bali, Indonesia • Private Sanctuaries
            </span>

            <!-- Title -->
            <h1 class="font-serif-title text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-normal leading-tight md:leading-none tracking-tight">
                Keindahan & Ketenangan <br class="hidden md:inline"/>
                <span class="italic font-normal gold-gradient-text">Mewah di Bali</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-xs sm:text-base md:text-lg text-slate-200 font-light max-w-2xl mx-auto leading-relaxed px-2">
                Koleksi villa & resort eksklusif terverifikasi di Seminyak, Ubud, Uluwatu, dan Canggu. Dirancang untuk menghadirkan privasi penuh.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 pt-2 px-4 sm:px-0">
                <a href="#villa" class="w-full sm:w-auto bg-[#ca9e54] hover:bg-[#b88c43] text-white font-semibold px-8 py-3.5 sm:py-4 rounded-full shadow-lg hover:shadow-xl transition duration-300 flex items-center justify-center gap-2 group text-xs uppercase tracking-wider gold-glow">
                    <span>Pesan Sekarang</span>
                    <i class="ri-arrow-right-line text-lg group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#destinasi" class="w-full sm:w-auto border border-white/40 hover:border-white bg-white/10 hover:bg-white/20 text-white font-medium px-8 py-3.5 sm:py-4 rounded-full transition duration-300 flex items-center justify-center text-xs uppercase tracking-wider backdrop-blur-md">
                    Destinasi Favorit
                </a>
            </div>
        </div>

        <!-- SEARCH BAR CONTAINER -->
        <div class="relative z-30 w-full max-w-5xl mx-auto transform translate-y-2 sm:translate-y-4 md:translate-y-6 px-2 sm:px-6 mb-2">
            <div class="bg-white/95 backdrop-blur-xl rounded-2xl sm:rounded-3xl p-3.5 sm:p-5 md:p-6 shadow-2xl border border-slate-100 text-slate-900">
                <form class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-2.5 sm:gap-4 items-center">
                    <!-- Destinasi -->
                    <div class="p-3 sm:p-3.5 rounded-xl sm:rounded-2xl bg-slate-50 hover:bg-slate-100/80 transition-colors border border-slate-200/60">
                        <label class="block text-[9px] sm:text-xs font-bold tracking-wider text-slate-500 uppercase mb-1">DESTINASI</label>
                        <div class="flex items-center gap-2 text-slate-900">
                            <i class="ri-map-pin-line text-base sm:text-xl text-[#ca9e54]"></i>
                            <input type="text" placeholder="Bali, Ubud, Seminyak..." class="w-full bg-transparent text-xs sm:text-sm font-bold text-slate-900 focus:outline-none placeholder:text-slate-400">
                        </div>
                    </div>

                    <!-- Check In -->
                    <div class="p-3 sm:p-3.5 rounded-xl sm:rounded-2xl bg-slate-50 hover:bg-slate-100/80 transition-colors border border-slate-200/60">
                        <label for="search-checkin-date" class="block text-[9px] sm:text-xs font-bold tracking-wider text-slate-500 uppercase mb-1">CHECK IN</label>
                        <div class="flex items-center gap-2 text-slate-900">
                            <i class="ri-calendar-event-line text-base sm:text-xl text-[#ca9e54]"></i>
                            <input type="date" id="search-checkin-date" aria-label="Tanggal Check In" class="w-full bg-transparent text-xs sm:text-sm font-bold text-slate-900 focus:outline-none cursor-pointer">
                        </div>
                    </div>

                    <!-- Tamu -->
                    <div class="p-3 sm:p-3.5 rounded-xl sm:rounded-2xl bg-slate-50 hover:bg-slate-100/80 transition-colors border border-slate-200/60">
                        <label for="search-guest-count" class="block text-[9px] sm:text-xs font-bold tracking-wider text-slate-500 uppercase mb-1">TAMU</label>
                        <div class="flex items-center gap-2 text-slate-900">
                            <i class="ri-user-3-line text-base sm:text-xl text-[#ca9e54]"></i>
                            <select id="search-guest-count" aria-label="Jumlah Tamu" class="w-full bg-transparent text-xs sm:text-sm font-bold text-slate-900 focus:outline-none cursor-pointer">
                                <option value="2">2 tamu</option>
                                <option value="4">4 tamu</option>
                                <option value="6">6+ tamu</option>
                            </select>
                        </div>
                    </div>

                    <!-- Search & Filter Button -->
                    <div class="flex items-center gap-2 col-span-1 sm:col-span-2 md:col-span-1">
                        <button type="submit" class="flex-1 bg-[#152c4e] hover:bg-[#0f1e36] text-white font-semibold py-3.5 sm:py-4 px-5 rounded-xl sm:rounded-2xl shadow-md hover:shadow-lg transition duration-300 flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                            <i class="ri-search-line text-base sm:text-lg"></i>
                            <span>Cari</span>
                        </button>
                        <button type="button" class="p-3.5 sm:p-4 bg-slate-100 text-slate-700 rounded-xl sm:rounded-2xl hover:bg-slate-200 transition-colors border border-slate-200" title="Filter Tambahan" aria-label="Filter Tambahan">
                            <i class="ri-equalizer-line text-base sm:text-lg"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- SECTION: DESTINASI REKOMENDASI FAVORIT TURIS -->
    <section id="destinasi" class="pt-12 sm:pt-16 md:pt-20 pb-12 sm:pb-16 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto section-lazy font-satoshi">
        <!-- Section Header -->
        <div class="flex flex-row items-end justify-between mb-6 sm:mb-10 gap-4">
            <div>
                <span class="text-[10px] sm:text-xs font-bold tracking-[0.2em] text-[#ca9e54] uppercase block mb-1">Destinasi Ikonik</span>
                <h2 class="font-serif-title text-2xl sm:text-3xl md:text-5xl font-normal text-slate-900 mt-0.5 sm:mt-1">
                    Daerah Favorit Turis
                </h2>
            </div>
            
            <!-- Slider Navigation Buttons -->
            <div class="flex items-center gap-2">
                <button id="destinasi-prev" class="w-9 h-9 sm:w-11 sm:h-11 rounded-full border border-slate-200 hover:border-[#ca9e54] bg-white text-slate-700 hover:text-[#ca9e54] flex items-center justify-center transition-all shadow-sm active:scale-95 cursor-pointer" title="Sebelumnya" aria-label="Destinasi Sebelumnya">
                    <i class="ri-arrow-left-line text-base sm:text-lg"></i>
                </button>
                <button id="destinasi-next" class="w-9 h-9 sm:w-11 sm:h-11 rounded-full border border-slate-200 hover:border-[#ca9e54] bg-white text-slate-700 hover:text-[#ca9e54] flex items-center justify-center transition-all shadow-sm active:scale-95 cursor-pointer" title="Berikutnya" aria-label="Destinasi Berikutnya">
                    <i class="ri-arrow-right-line text-base sm:text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Destination Cards Horizontal Touch & Drag Slider -->
        <div id="destinasi-slider" class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-4 pb-4 -mx-4 px-4 sm:mx-0 sm:px-0 scroll-smooth touch-pan-x cursor-grab active:cursor-grabbing select-none">

            <!-- Destination 1: Seminyak -->
            <a href="#villa" class="snap-start shrink-0 w-[260px] sm:w-[280px] md:w-[300px] group relative h-80 sm:h-96 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl flex flex-col justify-end p-5 sm:p-6 border border-slate-100">
                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=600&q=75" 
                     alt="Seminyak" 
                     draggable="false"
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 pointer-events-none">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent pointer-events-none"></div>
                
                <div class="relative z-10 text-white space-y-2 pointer-events-none">
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-white tracking-wide">Seminyak</h3>
                    
                    <!-- Ada Apa Saja -->
                    <div class="flex flex-wrap gap-1">
                        <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">Beach Club</span>
                        <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">Kuliner</span>
                        <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">Belanja</span>
                    </div>
                    
                    <!-- Daya Tarik Utama -->
                    <p class="text-[11px] sm:text-xs text-slate-300 font-light leading-snug pt-1 border-t border-white/10">
                        <strong class="text-[#e5c382] font-semibold">Daya Tarik:</strong> Sunset spektakuler & gaya hidup pantai mewah.
                    </p>
                </div>
            </a>

            <!-- Destination 2: Ubud -->
            <a href="#villa" class="snap-start shrink-0 w-[260px] sm:w-[280px] md:w-[300px] group relative h-80 sm:h-96 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl flex flex-col justify-end p-5 sm:p-6 border border-slate-100">
                <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=600&q=75" 
                     alt="Ubud" 
                     draggable="false"
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 pointer-events-none">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent pointer-events-none"></div>
                
                <div class="relative z-10 text-white space-y-2 pointer-events-none">
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-white tracking-wide">Ubud</h3>
                    
                    <!-- Ada Apa Saja -->
                    <div class="flex flex-wrap gap-1">
                        <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">Hutan Tropis</span>
                        <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">Sawah Siring</span>
                        <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">Seni & Spa</span>
                    </div>
                    
                    <!-- Daya Tarik Utama -->
                    <p class="text-[11px] sm:text-xs text-slate-300 font-light leading-snug pt-1 border-t border-white/10">
                        <strong class="text-[#e5c382] font-semibold">Daya Tarik:</strong> Ketenangan alam tropis & pusat kebudayaan autentik Bali.
                    </p>
                </div>
            </a>

            <!-- Destination 3: Uluwatu -->
            <a href="#villa" class="snap-start shrink-0 w-[260px] sm:w-[280px] md:w-[300px] group relative h-80 sm:h-96 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl flex flex-col justify-end p-5 sm:p-6 border border-slate-100">
                <img src="https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=600&q=75" 
                     alt="Uluwatu" 
                     draggable="false"
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 pointer-events-none">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent pointer-events-none"></div>
                
                <div class="relative z-10 text-white space-y-2 pointer-events-none">
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-white tracking-wide">Uluwatu</h3>
                    
                    <!-- Ada Apa Saja -->
                    <div class="flex flex-wrap gap-1">
                        <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">Tebing Laut</span>
                        <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">Pura Uluwatu</span>
                        <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">Surfing</span>
                    </div>
                    
                    <!-- Daya Tarik Utama -->
                    <p class="text-[11px] sm:text-xs text-slate-300 font-light leading-snug pt-1 border-t border-white/10">
                        <strong class="text-[#e5c382] font-semibold">Daya Tarik:</strong> Pemandangan tebing samudra & pertunjukan Tari Kecak.
                    </p>
                </div>
            </a>

            <!-- Destination 4: Canggu -->
            <a href="#villa" class="snap-start shrink-0 w-[260px] sm:w-[280px] md:w-[300px] group relative h-80 sm:h-96 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl flex flex-col justify-end p-5 sm:p-6 border border-slate-100">
                <img src="https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?auto=format&fit=crop&w=600&q=75" 
                     alt="Canggu" 
                     draggable="false"
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 pointer-events-none">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent pointer-events-none"></div>
                
                <div class="relative z-10 text-white space-y-2 pointer-events-none">
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-white tracking-wide">Canggu</h3>
                    
                    <!-- Ada Apa Saja -->
                    <div class="flex flex-wrap gap-1">
                        <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">Kafe Estetik</span>
                        <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">Echo Beach</span>
                        <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">Surfing</span>
                    </div>
                    
                    <!-- Daya Tarik Utama -->
                    <p class="text-[11px] sm:text-xs text-slate-300 font-light leading-snug pt-1 border-t border-white/10">
                        <strong class="text-[#e5c382] font-semibold">Daya Tarik:</strong> Gaya hidup santai, olahraga air & spot nongkrong modern.
                    </p>
                </div>
            </a>

            <!-- Destination 5: Nusa Dua -->
            <a href="#villa" class="snap-start shrink-0 w-[260px] sm:w-[280px] md:w-[300px] group relative h-80 sm:h-96 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl flex flex-col justify-end p-5 sm:p-6 border border-slate-100">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=75" 
                     alt="Nusa Dua" 
                     draggable="false"
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 pointer-events-none">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent pointer-events-none"></div>
                
                <div class="relative z-10 text-white space-y-2 pointer-events-none">
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-white tracking-wide">Nusa Dua</h3>
                    
                    <!-- Ada Apa Saja -->
                    <div class="flex flex-wrap gap-1">
                        <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">Resort Bintang 5</span>
                        <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">Waterblow</span>
                        <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">Pasir Putih</span>
                    </div>
                    
                    <!-- Daya Tarik Utama -->
                    <p class="text-[11px] sm:text-xs text-slate-300 font-light leading-snug pt-1 border-t border-white/10">
                        <strong class="text-[#e5c382] font-semibold">Daya Tarik:</strong> Kawasan resort eksklusif dengan pantai tenang nan berseri.
                    </p>
                </div>
            </a>

        </div>
    </section>

    <!-- SECTION: VILLA MEWAH TERPILIH -->
    <section id="villa" class="pt-12 sm:pt-16 pb-16 sm:pb-20 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto section-lazy font-satoshi">
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-16 space-y-2 sm:space-y-3">
            <span class="text-[10px] sm:text-xs font-bold tracking-[0.2em] text-[#ca9e54] uppercase block mb-1">Koleksi Terkurasi</span>
            <h2 class="font-serif-title text-2xl sm:text-3xl md:text-5xl font-normal text-slate-900 mt-1">
                Villa Terpilih Palma
            </h2>
            <p class="text-slate-600 font-light text-xs sm:text-base md:text-lg">
                Temukan pilihan properti luar biasa kami di destinasi paling menakjubkan di dunia
            </p>
        </div>

        <!-- Villa Grid (6 Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8 mb-10 sm:mb-12">

            <!-- Villa Card 1 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-56 sm:h-64 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=600&q=75" 
                         alt="Villa Azure Paradise" 
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4 flex gap-1.5 sm:gap-2">
                        <span class="bg-[#ca9e54] text-white text-[10px] sm:text-xs font-bold px-2.5 sm:px-3 py-1 rounded-full shadow-md">-30% OFF</span>
                        <span class="bg-white/90 backdrop-blur-md text-slate-800 text-[10px] sm:text-xs font-semibold px-2.5 sm:px-3 py-1 rounded-full shadow-md">Pilihan</span>
                    </div>
                    <button class="absolute top-4 right-4 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-base sm:text-lg"></i>
                    </button>
                </div>
                <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-lg sm:text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">
                                Villa Azure Paradise
                            </h3>
                            <div class="flex items-center gap-1 text-xs sm:text-sm font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>4.9</span> <span class="text-[10px] sm:text-xs font-normal text-slate-400">(127)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i>
                            Seminyak, Bali
                        </p>
                        <div class="flex items-center justify-between text-[11px] sm:text-xs text-slate-600 pt-3 border-t border-slate-100 mb-5 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-sm text-[#ca9e54]"></i> 5 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-sm text-[#ca9e54]"></i> 4 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-sm text-[#ca9e54]"></i> 10 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-xs text-slate-400 line-through mr-1">$650</span>
                            <span class="text-xl sm:text-2xl font-bold text-[#152c4e]">$450</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="{{ route('villa.show', 1) }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors flex items-center gap-1">
                            Detail <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Villa Card 2 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-56 sm:h-64 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=600&q=75" 
                         alt="Villa Ocean Breeze" 
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4">
                        <span class="bg-white/90 backdrop-blur-md text-slate-800 text-[10px] sm:text-xs font-semibold px-2.5 sm:px-3 py-1 rounded-full shadow-md">Pilihan</span>
                    </div>
                    <button class="absolute top-4 right-4 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-base sm:text-lg"></i>
                    </button>
                </div>
                <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-lg sm:text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">
                                Villa Ocean Breeze
                            </h3>
                            <div class="flex items-center gap-1 text-xs sm:text-sm font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>5.0</span> <span class="text-[10px] sm:text-xs font-normal text-slate-400">(89)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i>
                            Uluwatu, Bali
                        </p>
                        <div class="flex items-center justify-between text-[11px] sm:text-xs text-slate-600 pt-3 border-t border-slate-100 mb-5 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-sm text-[#ca9e54]"></i> 6 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-sm text-[#ca9e54]"></i> 5 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-sm text-[#ca9e54]"></i> 12 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-xl sm:text-2xl font-bold text-[#152c4e]">$680</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="{{ route('villa.show', 1) }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors flex items-center gap-1">
                            Detail <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Villa Card 3 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-56 sm:h-64 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=600&q=75" 
                         alt="Villa Tropical Serenity" 
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4">
                        <span class="bg-[#ca9e54] text-white text-[10px] sm:text-xs font-bold px-2.5 sm:px-3 py-1 rounded-full shadow-md">-28% OFF</span>
                    </div>
                    <button class="absolute top-4 right-4 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-base sm:text-lg"></i>
                    </button>
                </div>
                <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-lg sm:text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">
                                Villa Tropical Serenity
                            </h3>
                            <div class="flex items-center gap-1 text-xs sm:text-sm font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>4.8</span> <span class="text-[10px] sm:text-xs font-normal text-slate-400">(203)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i>
                            Canggu, Bali
                        </p>
                        <div class="flex items-center justify-between text-[11px] sm:text-xs text-slate-600 pt-3 border-t border-slate-100 mb-5 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-sm text-[#ca9e54]"></i> 4 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-sm text-[#ca9e54]"></i> 3 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-sm text-[#ca9e54]"></i> 8 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-xs text-slate-400 line-through mr-1">$450</span>
                            <span class="text-xl sm:text-2xl font-bold text-[#152c4e]">$320</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="{{ route('villa.show', 1) }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors flex items-center gap-1">
                            Detail <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Villa Card 4 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-56 sm:h-64 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=600&q=75" 
                         alt="Villa Sunset Cliff" 
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <button class="absolute top-4 right-4 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-base sm:text-lg"></i>
                    </button>
                </div>
                <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-lg sm:text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">
                                Villa Sunset Cliff
                            </h3>
                            <div class="flex items-center gap-1 text-xs sm:text-sm font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>4.9</span> <span class="text-[10px] sm:text-xs font-normal text-slate-400">(156)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i>
                            Nusa Dua, Bali
                        </p>
                        <div class="flex items-center justify-between text-[11px] sm:text-xs text-slate-600 pt-3 border-t border-slate-100 mb-5 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-sm text-[#ca9e54]"></i> 5 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-sm text-[#ca9e54]"></i> 4 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-sm text-[#ca9e54]"></i> 10 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-xl sm:text-2xl font-bold text-[#152c4e]">$550</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="{{ route('villa.show', 1) }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors flex items-center gap-1">
                            Detail <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Villa Card 5 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-56 sm:h-64 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=600&q=75" 
                         alt="Villa Emerald Hills" 
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4">
                        <span class="bg-[#ca9e54] text-white text-[10px] sm:text-xs font-bold px-2.5 sm:px-3 py-1 rounded-full shadow-md">-30% OFF</span>
                    </div>
                    <button class="absolute top-4 right-4 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-base sm:text-lg"></i>
                    </button>
                </div>
                <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-lg sm:text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">
                                Villa Emerald Hills
                            </h3>
                            <div class="flex items-center gap-1 text-xs sm:text-sm font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>4.7</span> <span class="text-[10px] sm:text-xs font-normal text-slate-400">(94)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i>
                            Ubud, Bali
                        </p>
                        <div class="flex items-center justify-between text-[11px] sm:text-xs text-slate-600 pt-3 border-t border-slate-100 mb-5 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-sm text-[#ca9e54]"></i> 3 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-sm text-[#ca9e54]"></i> 3 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-sm text-[#ca9e54]"></i> 6 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-xs text-slate-400 line-through mr-1">$400</span>
                            <span class="text-xl sm:text-2xl font-bold text-[#152c4e]">$280</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="{{ route('villa.show', 1) }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors flex items-center gap-1">
                            Detail <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Villa Card 6 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-56 sm:h-64 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=600&q=75" 
                         alt="Villa Coastal Dream" 
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <button class="absolute top-4 right-4 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-base sm:text-lg"></i>
                    </button>
                </div>
                <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-lg sm:text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">
                                Villa Coastal Dream
                            </h3>
                            <div class="flex items-center gap-1 text-xs sm:text-sm font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>4.8</span> <span class="text-[10px] sm:text-xs font-normal text-slate-400">(178)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i>
                            Jimbaran, Bali
                        </p>
                        <div class="flex items-center justify-between text-[11px] sm:text-xs text-slate-600 pt-3 border-t border-slate-100 mb-5 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-sm text-[#ca9e54]"></i> 4 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-sm text-[#ca9e54]"></i> 4 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-sm text-[#ca9e54]"></i> 8 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-xl sm:text-2xl font-bold text-[#152c4e]">$420</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="{{ route('villa.show', 1) }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors flex items-center gap-1">
                            Detail <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Section Action Button -->
        <div class="text-center">
            <a href="{{ route('villa.index') }}" class="inline-flex items-center gap-2 bg-[#152c4e] hover:bg-[#0f1e36] text-white font-semibold px-8 py-3.5 sm:py-4 rounded-full shadow-md hover:shadow-lg transition duration-300 text-xs uppercase tracking-wider group">
                <span>Lihat Semua Villa</span>
                <i class="ri-arrow-right-line text-base group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </section>

    <!-- SECTION: PROMO TERBATAS -->
    <section id="promo" class="py-14 sm:py-20 px-4 sm:px-6 md:px-12 bg-gradient-to-b from-[#f4f6fa] to-[#f8f9fb] section-lazy font-satoshi">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-16 space-y-2 sm:space-y-3">
                <span class="text-[10px] sm:text-xs font-bold tracking-[0.2em] text-[#ca9e54] uppercase block mb-1">Penawaran Eksklusif</span>
                <h2 class="font-serif-title text-2xl sm:text-3xl md:text-5xl font-normal text-slate-900 mt-1">
                    Promo Terbatas
                </h2>
                <p class="text-slate-600 font-light text-xs sm:text-base md:text-lg">
                    Jangan lewatkan pengalaman villa premium kami dengan harga terbaik
                </p>
            </div>

            <!-- Top Promo Grid (2 Main Banner Cards) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mb-8 sm:mb-10">

                <!-- Left Promo: Flash Sale -->
                <div class="bg-[#152c4e] text-white rounded-3xl p-6 sm:p-8 md:p-10 shadow-xl relative overflow-hidden flex flex-col justify-between group">
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/5 rounded-full blur-2xl group-hover:scale-110 transition-transform"></div>
                    <div>
                        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-3.5 py-1 rounded-full text-[10px] sm:text-xs font-semibold text-[#e5c382] mb-4 sm:mb-6 border border-white/10">
                            <i class="ri-time-line text-sm"></i>
                            <span>Flash Sale</span>
                        </div>
                        <h3 class="font-serif-title text-2xl sm:text-3xl md:text-4xl font-bold mb-3 sm:mb-4 leading-tight">
                            Spesial Weekend Escape
                        </h3>
                        <p class="text-white/80 font-light text-xs sm:text-base mb-6 sm:mb-8 max-w-md">
                            Hemat hingga 40% untuk booking weekend di villa mewah pilihan
                        </p>

                        <!-- Countdown Timer -->
                        <div class="flex items-center gap-2 sm:gap-3 mb-6 sm:mb-8" id="countdown-timer">
                            <div class="bg-white/10 backdrop-blur-md rounded-xl sm:rounded-2xl p-2.5 sm:p-3 min-w-[58px] sm:min-w-[70px] text-center border border-white/10">
                                <span class="block text-xl sm:text-2xl font-bold font-mono text-[#e5c382]" id="timer-hours">23</span>
                                <span class="text-[9px] sm:text-[10px] uppercase font-bold text-white/60 tracking-wider">JAM</span>
                            </div>
                            <span class="text-lg sm:text-xl font-bold text-[#e5c382]">:</span>
                            <div class="bg-white/10 backdrop-blur-md rounded-xl sm:rounded-2xl p-2.5 sm:p-3 min-w-[58px] sm:min-w-[70px] text-center border border-white/10">
                                <span class="block text-xl sm:text-2xl font-bold font-mono text-[#e5c382]" id="timer-minutes">42</span>
                                <span class="text-[9px] sm:text-[10px] uppercase font-bold text-white/60 tracking-wider">MENIT</span>
                            </div>
                            <span class="text-lg sm:text-xl font-bold text-[#e5c382]">:</span>
                            <div class="bg-white/10 backdrop-blur-md rounded-xl sm:rounded-2xl p-2.5 sm:p-3 min-w-[58px] sm:min-w-[70px] text-center border border-white/10">
                                <span class="block text-xl sm:text-2xl font-bold font-mono text-[#e5c382]" id="timer-seconds">27</span>
                                <span class="text-[9px] sm:text-[10px] uppercase font-bold text-white/60 tracking-wider">DETIK</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('promo.index') }}" class="inline-flex items-center justify-center gap-2 bg-[#ca9e54] hover:bg-[#b88c43] text-white font-semibold px-8 py-3.5 rounded-full shadow-lg transition duration-300 w-full sm:w-auto text-xs uppercase tracking-wider">
                            <span>Ambil Penawaran Sekarang</span>
                            <i class="ri-arrow-right-line text-base"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Promo: VIP Member Bonus -->
                <div class="bg-gradient-to-br from-[#d4af37] via-[#ca9e54] to-[#b88c43] text-white rounded-3xl p-6 sm:p-8 md:p-10 shadow-xl relative overflow-hidden flex flex-col justify-between group">
                    <div class="absolute bottom-0 right-0 -mr-12 -mb-12 w-64 h-64 bg-black/10 rounded-full blur-2xl group-hover:scale-110 transition-transform"></div>
                    <div>
                        <div class="inline-flex items-center gap-2 bg-black/20 backdrop-blur-md px-3.5 py-1 rounded-full text-[10px] sm:text-xs font-semibold text-white mb-4 sm:mb-6 border border-white/20">
                            <i class="ri-vip-crown-line text-sm"></i>
                            <span>Khusus Member VIP</span>
                        </div>
                        <h3 class="font-serif-title text-2xl sm:text-3xl md:text-4xl font-bold mb-3 sm:mb-4 leading-tight">
                            Bonus Booking Pertama
                        </h3>
                        <p class="text-white/90 font-light text-xs sm:text-base mb-6 max-w-md">
                            Dapatkan diskon eksklusif 35% untuk reservasi villa pertama Anda
                        </p>

                        <!-- Features list -->
                        <ul class="space-y-2.5 sm:space-y-3 mb-6 sm:mb-8 text-xs sm:text-sm font-medium text-white/95">
                            <li class="flex items-center gap-2.5 sm:gap-3">
                                <i class="ri-checkbox-circle-fill text-base sm:text-lg text-white"></i>
                                <span>Transfer bandara gratis</span>
                            </li>
                            <li class="flex items-center gap-2.5 sm:gap-3">
                                <i class="ri-checkbox-circle-fill text-base sm:text-lg text-white"></i>
                                <span>Makan malam selamat datang gratis</span>
                            </li>
                            <li class="flex items-center gap-2.5 sm:gap-3">
                                <i class="ri-checkbox-circle-fill text-base sm:text-lg text-white"></i>
                                <span>Layanan concierge 24/7</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <a href="{{ route('promo.index') }}" class="inline-flex items-center justify-center gap-2 bg-white text-slate-900 hover:bg-slate-50 font-bold px-8 py-3.5 rounded-full shadow-lg transition duration-300 w-full sm:w-auto text-xs uppercase tracking-wider">
                            <span>Mulai Sekarang</span>
                            <i class="ri-arrow-right-line text-base"></i>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom 3 Promo Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">

                <!-- Feature Promo 1 -->
                <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition duration-300 space-y-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-[#152c4e]/10 text-[#152c4e] flex items-center justify-center text-lg sm:text-xl">
                        <i class="ri-percent-line"></i>
                    </div>
                    <h4 class="font-serif-title text-lg sm:text-xl font-bold text-slate-900">Spesial Musim Panas</h4>
                    <p class="text-xs text-slate-600 font-light leading-relaxed">
                        Hemat 25% untuk booking lebih dari 7 malam
                    </p>
                    <a href="#villa" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors pt-1">
                        <span>Pelajari Lebih Lanjut</span>
                        <i class="ri-arrow-right-line text-sm"></i>
                    </a>
                </div>

                <!-- Feature Promo 2 -->
                <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition duration-300 space-y-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-[#ca9e54]/10 text-[#ca9e54] flex items-center justify-center text-lg sm:text-xl">
                        <i class="ri-gift-line"></i>
                    </div>
                    <h4 class="font-serif-title text-lg sm:text-xl font-bold text-slate-900">Refer & Dapatkan</h4>
                    <p class="text-xs text-slate-600 font-light leading-relaxed">
                        Dapatkan kredit $100 untuk setiap referral teman
                    </p>
                    <a href="#villa" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors pt-1">
                        <span>Pelajari Lebih Lanjut</span>
                        <i class="ri-arrow-right-line text-sm"></i>
                    </a>
                </div>

                <!-- Feature Promo 3 -->
                <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition duration-300 space-y-3 sm:col-span-2 md:col-span-1">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-lg sm:text-xl">
                        <i class="ri-price-tag-3-line"></i>
                    </div>
                    <h4 class="font-serif-title text-lg sm:text-xl font-bold text-slate-900">Promo Last Minute</h4>
                    <p class="text-xs text-slate-600 font-light leading-relaxed">
                        Hingga 50% off untuk booking minggu yang sama
                    </p>
                    <a href="#villa" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors pt-1">
                        <span>Pelajari Lebih Lanjut</span>
                        <i class="ri-arrow-right-line text-sm"></i>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: PERBEDAN PALMA ("Why Choose Us") -->
    <section id="tentang" class="py-14 sm:py-24 px-4 sm:px-6 md:px-12 bg-white section-lazy font-satoshi">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-16 space-y-2 sm:space-y-3">
                <span class="text-[10px] sm:text-xs font-bold tracking-[0.2em] text-[#ca9e54] uppercase block mb-1">Komitmen Kami</span>
                <h2 class="font-serif-title text-2xl sm:text-3xl md:text-5xl font-normal text-slate-900 mt-1">
                    Mengapa Memilih Palma
                </h2>
                <p class="text-slate-600 font-light text-xs sm:text-base md:text-lg">
                    Rasakan kemewahan dan layanan tak tertandingi yang melampaui ekspektasi
                </p>
            </div>

            <!-- Value Cards Grid (6 Columns) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8">

                <!-- Value 1 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-3 sm:space-y-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-[#152c4e] text-white flex items-center justify-center shadow-md text-xl sm:text-2xl">
                        <i class="ri-shield-check-line"></i>
                    </div>
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">
                        Properti Terverifikasi
                    </h3>
                    <p class="text-slate-600 font-light text-xs sm:text-sm leading-relaxed">
                        Setiap villa diperiksa dan diverifikasi secara personal oleh tim ahli kami untuk menjamin standar kualitas tertinggi.
                    </p>
                </div>

                <!-- Value 2 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-3 sm:space-y-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-[#ca9e54] text-white flex items-center justify-center shadow-md text-xl sm:text-2xl">
                        <i class="ri-award-line"></i>
                    </div>
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">
                        Jaminan Harga Terbaik
                    </h3>
                    <p class="text-slate-600 font-light text-xs sm:text-sm leading-relaxed">
                        Temukan harga lebih rendah? Kami akan menyamai dan memberikan 110% kembali dari selisih harga tersebut.
                    </p>
                </div>

                <!-- Value 3 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-3 sm:space-y-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-teal-600 text-white flex items-center justify-center shadow-md text-xl sm:text-2xl">
                        <i class="ri-customer-service-2-line"></i>
                    </div>
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">
                        Concierge 24/7
                    </h3>
                    <p class="text-slate-600 font-light text-xs sm:text-sm leading-relaxed">
                        Dukungan sepanjang waktu dari booking hingga checkout untuk memastikan pengalaman menginap Anda sempurna.
                    </p>
                </div>

                <!-- Value 4 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-3 sm:space-y-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-[#152c4e] text-white flex items-center justify-center shadow-md text-xl sm:text-2xl">
                        <i class="ri-heart-3-line"></i>
                    </div>
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">
                        Layanan Personal
                    </h3>
                    <p class="text-slate-600 font-light text-xs sm:text-sm leading-relaxed">
                        Rekomendasi villa yang disesuaikan secara khusus berdasarkan kebutuhan spesifik dan kenyamanan liburan keluarga Anda.
                    </p>
                </div>

                <!-- Value 5 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-3 sm:space-y-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-[#ca9e54] text-white flex items-center justify-center shadow-md text-xl sm:text-2xl">
                        <i class="ri-rocket-line"></i>
                    </div>
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">
                        Konfirmasi Instan
                    </h3>
                    <p class="text-slate-600 font-light text-xs sm:text-sm leading-relaxed">
                        Proses booking cepat tanpa perlu menunggu konfirmasi manual lama, jadwal ketersediaan terbarui secara otomatis.
                    </p>
                </div>

                <!-- Value 6 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-3 sm:space-y-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-teal-600 text-white flex items-center justify-center shadow-md text-xl sm:text-2xl">
                        <i class="ri-vip-crown-line"></i>
                    </div>
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">
                        Keuntungan Eksklusif
                    </h3>
                    <p class="text-slate-600 font-light text-xs sm:text-sm leading-relaxed">
                        Akses khusus ke promo rahasia, welcome drink spesial, dan bonus upgrade fasilitas villa pada setiap pemesanan.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: CTA BANNER -->
    <section class="py-14 sm:py-20 px-4 sm:px-6 md:px-12 bg-[#152c4e] text-white font-satoshi relative overflow-hidden">
        <div class="max-w-5xl mx-auto text-center space-y-4 sm:space-y-6 relative z-10">
            <h2 class="font-serif-title text-2xl sm:text-3xl md:text-5xl font-bold">
                Siap Merasakan Kemewahan?
            </h2>
            <p class="text-white/80 font-light text-xs sm:text-base md:text-lg max-w-2xl mx-auto leading-relaxed px-2">
                Bergabunglah dengan ribuan tamu puas yang telah menemukan villa sempurna mereka bersama Palma.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 pt-2 sm:pt-4 px-4 sm:px-0">
                <a href="#villa" class="w-full sm:w-auto bg-[#ca9e54] hover:bg-[#b88c43] text-white font-semibold px-9 py-3.5 sm:py-4 rounded-full shadow-lg transition duration-300 text-xs uppercase tracking-wider gold-glow">
                    Jelajahi Villa Sekarang
                </a>
                <a href="#tentang" class="w-full sm:w-auto border border-white/40 hover:border-white bg-white/10 hover:bg-white/20 text-white font-medium px-9 py-3.5 sm:py-4 rounded-full transition duration-300 text-xs uppercase tracking-wider backdrop-blur-md">
                    Hubungi Concierge
                </a>
            </div>
        </div>
    </section>    <!-- SECTION: KATA TAMU KAMI (PHOTO MOSAIC & TESTIMONIALS MATCHING REFERENCE DESIGN) -->
    <section class="py-16 sm:py-28 px-4 sm:px-6 md:px-12 bg-white font-satoshi section-lazy border-t border-slate-100 overflow-hidden">
        <div class="max-w-7xl mx-auto space-y-12 sm:space-y-16">

            <!-- CENTER HEADLINE SECTION (MATCHING REFERENCE DESIGN) -->
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-slate-900 leading-tight">
                    Dipercaya oleh Wisatawan & Tokoh Dunia
                </h2>
                <p class="text-slate-500 font-normal text-base sm:text-lg md:text-xl max-w-xl mx-auto">
                    dari berbagai kalangan, negara, & industri
                </p>
            </div>

            <!-- BOTTOM 3 MINIMALIST TESTIMONIAL CARDS (MATCHING REFERENCE DESIGN) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 sm:gap-10 pt-4">
                
                <!-- Review 1 -->
                <div class="space-y-4 font-satoshi">
                    <!-- 5 Stars -->
                    <div class="flex text-[#ca9e54] gap-1 text-base sm:text-lg">
                        <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                    </div>

                    <!-- Quote Text -->
                    <p class="text-xs sm:text-sm text-slate-600 font-normal leading-relaxed">
                        "Palma membuat proses menemukan villa mewah di Bali sangat mudah! Saya dapat memesan villa pantai dalam beberapa menit dan langsung mendapatkan konfirmasi instan. Sangat merekomendasikan!"
                    </p>

                    <!-- Author Row -->
                    <div class="flex items-center gap-3 pt-2">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=75" alt="Joao M." class="w-11 h-11 rounded-full object-cover shadow-sm ring-1 ring-slate-200">
                        <div>
                            <h4 class="font-bold text-xs sm:text-sm text-slate-900">Joao M. 🇦🇺</h4>
                            <span class="text-xs text-slate-400 font-light block">Startup Founder</span>
                        </div>
                    </div>
                </div>

                <!-- Review 2 -->
                <div class="space-y-4 font-satoshi">
                    <!-- 5 Stars -->
                    <div class="flex text-[#ca9e54] gap-1 text-base sm:text-lg">
                        <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                    </div>

                    <!-- Quote Text -->
                    <p class="text-xs sm:text-sm text-slate-600 font-normal leading-relaxed">
                        "Tim kami membutuhkan villa privat yang fleksibel untuk retreat perusahaan. Pelayanan dari Palma sangat lancar, villa bersih luar biasa, dan fasilitasnya persis sesuai kebutuhan kami!"
                    </p>

                    <!-- Author Row -->
                    <div class="flex items-center gap-3 pt-2">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=75" alt="Bruno K." class="w-11 h-11 rounded-full object-cover shadow-sm ring-1 ring-slate-200">
                        <div>
                            <h4 class="font-bold text-xs sm:text-sm text-slate-900">Bruno K. 🇸🇬</h4>
                            <span class="text-xs text-slate-400 font-light block">UX Designer</span>
                        </div>
                    </div>
                </div>

                <!-- Review 3 -->
                <div class="space-y-4 font-satoshi">
                    <!-- 5 Stars -->
                    <div class="flex text-[#ca9e54] gap-1 text-base sm:text-lg">
                        <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                    </div>

                    <!-- Quote Text -->
                    <p class="text-xs sm:text-sm text-slate-600 font-normal leading-relaxed">
                        "Saya sangat menyukai keanekaragaman pilihan villa yang tersedia! Baik saat membutuhkan suasana tenang pantai atau tempat luas untuk keluarga, Palma selalu punya pilihan sempurna."
                    </p>

                    <!-- Author Row -->
                    <div class="flex items-center gap-3 pt-2">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=75" alt="Lais A." class="w-11 h-11 rounded-full object-cover shadow-sm ring-1 ring-slate-200">
                        <div>
                            <h4 class="font-bold text-xs sm:text-sm text-slate-900">Lais A. 🇬🇧</h4>
                            <span class="text-xs text-slate-400 font-light block">Digital Marketer</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>ion>
@endsection

@push('scripts')
<script>
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

    // Destinasi Slider Navigation & Drag Scroll
    document.addEventListener('DOMContentLoaded', () => {
        const destSlider = document.getElementById('destinasi-slider');
        const destPrev = document.getElementById('destinasi-prev');
        const destNext = document.getElementById('destinasi-next');

        if (destSlider) {
            if (destPrev) {
                destPrev.addEventListener('click', () => {
                    destSlider.scrollBy({ left: -300, behavior: 'smooth' });
                });
            }
            if (destNext) {
                destNext.addEventListener('click', () => {
                    destSlider.scrollBy({ left: 300, behavior: 'smooth' });
                });
            }

            // Mouse Drag to Scroll Logic for Desktop/Laptop mouse testing
            let isDragging = false;
            let startX, scrollLeft;

            destSlider.addEventListener('mousedown', (e) => {
                isDragging = true;
                startX = e.pageX - destSlider.offsetLeft;
                scrollLeft = destSlider.scrollLeft;
            });
            destSlider.addEventListener('mouseleave', () => { isDragging = false; });
            destSlider.addEventListener('mouseup', () => { isDragging = false; });
            destSlider.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
                const x = e.pageX - destSlider.offsetLeft;
                const walk = (x - startX) * 1.8;
                destSlider.scrollLeft = scrollLeft - walk;
            });
        }
    });
</script>
@endpush
