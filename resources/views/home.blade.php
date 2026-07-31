@extends('layouts.frontend.main')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative min-h-[90vh] flex flex-col justify-between pt-28 pb-16 px-6 font-satoshi">
        <!-- Hero Background Image -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=80" 
                 alt="Luxury Villa Resort" 
                 fetchpriority="high"
                 decoding="async"
                 class="w-full h-full object-cover object-center scale-105 transition-transform duration-10000 hover:scale-100">
            <div class="absolute inset-0 bg-gradient-to-b from-black/75 via-black/55 to-black/85"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 max-w-4xl mx-auto text-center text-white space-y-6 my-auto">
            <!-- Editorial Subhead -->
            <span class="font-satoshi text-xs font-semibold uppercase tracking-[0.3em] text-[#e5c382] block">
                Bali, Indonesia • Private Sanctuaries
            </span>

            <!-- Title -->
            <h1 class="font-serif-title text-4xl md:text-6xl lg:text-7xl font-normal leading-tight md:leading-none tracking-tight">
                Keindahan & Ketenangan <br class="hidden md:inline"/>
                <span class="italic font-normal text-[#f5e6c8]">Mewah di Bali</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-base md:text-lg text-slate-200 font-light max-w-2xl mx-auto leading-relaxed">
                Koleksi villa & resort eksklusif terverifikasi di Seminyak, Ubud, Uluwatu, dan Canggu. Dirancang untuk menghadirkan privasi penuh.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                <a href="#villa" class="w-full sm:w-auto bg-[#ca9e54] hover:bg-[#b88c43] text-white font-semibold px-8 py-4 rounded-full shadow-lg hover:shadow-xl transition duration-300 flex items-center justify-center gap-2 group text-xs uppercase tracking-wider">
                    <span>Pesan Sekarang</span>
                    <i class="ri-arrow-right-line text-lg group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#destinasi" class="w-full sm:w-auto border border-white/40 hover:border-white bg-white/10 hover:bg-white/20 text-white font-medium px-8 py-4 rounded-full transition duration-300 flex items-center justify-center text-xs uppercase tracking-wider">
                    Destinasi Favorit
                </a>
            </div>
        </div>

        <!-- SEARCH BAR CONTAINER -->
        <div class="relative z-30 w-full max-w-5xl mx-auto transform translate-y-[65%] px-4">
            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-2xl border border-slate-100 text-slate-900">
                <form class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                    <!-- Destinasi -->
                    <div class="p-3.5 rounded-xl bg-slate-50 hover:bg-slate-100/80 transition-colors border border-slate-200/60">
                        <label class="block text-xs font-bold tracking-wider text-slate-500 uppercase mb-1">DESTINASI</label>
                        <div class="flex items-center gap-2.5 text-slate-900">
                            <i class="ri-map-pin-line text-xl text-[#ca9e54]"></i>
                            <input type="text" placeholder="Bali, Ubud, Seminyak..." class="w-full bg-transparent text-sm font-bold text-slate-900 focus:outline-none placeholder:text-slate-400">
                        </div>
                    </div>

                    <!-- Check In -->
                    <div class="p-3.5 rounded-xl bg-slate-50 hover:bg-slate-100/80 transition-colors border border-slate-200/60">
                        <label class="block text-xs font-bold tracking-wider text-slate-500 uppercase mb-1">CHECK IN</label>
                        <div class="flex items-center gap-2.5 text-slate-900">
                            <i class="ri-calendar-event-line text-xl text-[#ca9e54]"></i>
                            <input type="text" onfocus="(this.type='date')" placeholder="Pilih tanggal" class="w-full bg-transparent text-sm font-bold text-slate-900 focus:outline-none placeholder:text-slate-400">
                        </div>
                    </div>

                    <!-- Tamu -->
                    <div class="p-3.5 rounded-xl bg-slate-50 hover:bg-slate-100/80 transition-colors border border-slate-200/60">
                        <label class="block text-xs font-bold tracking-wider text-slate-500 uppercase mb-1">TAMU</label>
                        <div class="flex items-center gap-2.5 text-slate-900">
                            <i class="ri-user-3-line text-xl text-[#ca9e54]"></i>
                            <select class="w-full bg-transparent text-sm font-bold text-slate-900 focus:outline-none cursor-pointer">
                                <option value="2">2 tamu</option>
                                <option value="4">4 tamu</option>
                                <option value="6">6+ tamu</option>
                            </select>
                        </div>
                    </div>

                    <!-- Search & Filter Button -->
                    <div class="flex items-center gap-2">
                        <button type="submit" class="flex-1 bg-[#152c4e] hover:bg-[#0f1e36] text-white font-semibold py-4 px-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                            <i class="ri-search-line text-lg"></i>
                            <span>Cari</span>
                        </button>
                        <button type="button" class="p-4 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition-colors border border-slate-200" title="Filter Tambahan">
                            <i class="ri-equalizer-line text-lg"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- SECTION: DESTINASI REKOMENDASI FAVORIT TURIS -->
    <section id="destinasi" class="pt-28 pb-16 px-6 md:px-12 max-w-7xl mx-auto section-lazy font-satoshi">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold tracking-[0.2em] text-[#ca9e54] uppercase block mb-1">Destinasi Ikonik</span>
                <h2 class="font-serif-title text-3xl md:text-5xl font-normal text-slate-900 mt-1">
                    Topik Favorit di Bali
                </h2>
            </div>
            <p class="text-slate-500 font-light text-sm max-w-md">
                Pilih topik & lokasi favorit Anda di Bali untuk pengalaman menginap yang sesuai dengan suasana liburan impian.
            </p>
        </div>

        <!-- Destination Cards Grid (5 Topic Columns) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">

            <!-- Topic 1: Seminyak -->
            <a href="#villa" class="group relative h-96 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 flex flex-col justify-end p-6 border border-slate-100">
                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=600&q=75" 
                     alt="Seminyak Bali" 
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                
                <div class="relative z-10 space-y-2 text-white">
                    <span class="text-[10px] uppercase font-bold tracking-[0.2em] text-[#e5c382]">BEACH & LUXURY</span>
                    <h3 class="font-serif-title text-2xl font-normal pt-1">Seminyak</h3>
                    <p class="text-xs text-slate-300 font-light leading-relaxed">
                        Beach Clubs, Kuliner Gourmet & Sunset.
                    </p>
                    <div class="pt-2 flex items-center justify-between text-xs text-[#e5c382] font-semibold border-t border-white/20">
                        <span>18 Villa Eksklusif</span>
                        <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </a>

            <!-- Topic 2: Ubud -->
            <a href="#villa" class="group relative h-96 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 flex flex-col justify-end p-6 border border-slate-100">
                <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=600&q=75" 
                     alt="Ubud Bali" 
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                
                <div class="relative z-10 space-y-2 text-white">
                    <span class="text-[10px] uppercase font-bold tracking-[0.2em] text-[#e5c382]">RAINFOREST & VALLEY</span>
                    <h3 class="font-serif-title text-2xl font-normal pt-1">Ubud</h3>
                    <p class="text-xs text-slate-300 font-light leading-relaxed">
                        Hutan Tropis, Lembah Sungai & Spa.
                    </p>
                    <div class="pt-2 flex items-center justify-between text-xs text-[#e5c382] font-semibold border-t border-white/20">
                        <span>12 Sanctuary Villa</span>
                        <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </a>

            <!-- Topic 3: Uluwatu -->
            <a href="#villa" class="group relative h-96 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 flex flex-col justify-end p-6 border border-slate-100">
                <img src="https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=600&q=75" 
                     alt="Uluwatu Bali" 
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                
                <div class="relative z-10 space-y-2 text-white">
                    <span class="text-[10px] uppercase font-bold tracking-[0.2em] text-[#e5c382]">CLIFFSIDE ESTATES</span>
                    <h3 class="font-serif-title text-2xl font-normal pt-1">Uluwatu</h3>
                    <p class="text-xs text-slate-300 font-light leading-relaxed">
                        Pemandangan Tebing Laut & Ocean Sunset.
                    </p>
                    <div class="pt-2 flex items-center justify-between text-xs text-[#e5c382] font-semibold border-t border-white/20">
                        <span>9 Ocean Estate</span>
                        <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </a>

            <!-- Topic 4: Canggu -->
            <a href="#villa" class="group relative h-96 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 flex flex-col justify-end p-6 border border-slate-100">
                <img src="https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?auto=format&fit=crop&w=600&q=75" 
                     alt="Canggu Bali" 
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                
                <div class="relative z-10 space-y-2 text-white">
                    <span class="text-[10px] uppercase font-bold tracking-[0.2em] text-[#e5c382]">SURF & LIFESTYLE</span>
                    <h3 class="font-serif-title text-2xl font-normal pt-1">Canggu</h3>
                    <p class="text-xs text-slate-300 font-light leading-relaxed">
                        Kafe Estetik, Surfing & Sunset Chill.
                    </p>
                    <div class="pt-2 flex items-center justify-between text-xs text-[#e5c382] font-semibold border-t border-white/20">
                        <span>15 Tropical Villa</span>
                        <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </a>

            <!-- Topic 5: Nusa Dua -->
            <a href="#villa" class="group relative h-96 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 flex flex-col justify-end p-6 border border-slate-100">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=75" 
                     alt="Nusa Dua Bali" 
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                
                <div class="relative z-10 space-y-2 text-white">
                    <span class="text-[10px] uppercase font-bold tracking-[0.2em] text-[#e5c382]">RESORT EKSKLUSIF</span>
                    <h3 class="font-serif-title text-2xl font-normal pt-1">Nusa Dua</h3>
                    <p class="text-xs text-slate-300 font-light leading-relaxed">
                        Pantai Pasir Putih, Golf & Keheningan.
                    </p>
                    <div class="pt-2 flex items-center justify-between text-xs text-[#e5c382] font-semibold border-t border-white/20">
                        <span>8 Resort Villa</span>
                        <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </a>

        </div>
    </section>

    <!-- SECTION: VILLA MEWAH TERPILIH -->
    <section id="villa" class="pt-16 pb-20 px-6 md:px-12 max-w-7xl mx-auto section-lazy font-satoshi">
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
            <span class="text-xs font-bold tracking-[0.2em] text-[#ca9e54] uppercase block mb-1">Koleksi Terkurasi</span>
            <h2 class="font-serif-title text-3xl md:text-5xl font-normal text-slate-900 mt-1">
                Villa Terpilih Palma
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
                    <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-lg"></i>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">
                                Villa Azure Paradise
                            </h3>
                            <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>4.9</span> <span class="text-xs font-normal text-slate-400">(127)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i>
                            Seminyak, Bali
                        </p>
                        <div class="flex items-center justify-between text-xs text-slate-600 pt-3 border-t border-slate-100 mb-6 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-sm text-[#ca9e54]"></i> 5 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-sm text-[#ca9e54]"></i> 4 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-sm text-[#ca9e54]"></i> 10 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-xs text-slate-400 line-through mr-1.5">$650</span>
                            <span class="text-2xl font-bold text-[#152c4e]">$450</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="#villa" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors flex items-center gap-1">
                            Detail <i class="ri-arrow-right-line"></i>
                        </a>
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
                    <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-lg"></i>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">
                                Villa Ocean Breeze
                            </h3>
                            <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>5.0</span> <span class="text-xs font-normal text-slate-400">(89)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i>
                            Uluwatu, Bali
                        </p>
                        <div class="flex items-center justify-between text-xs text-slate-600 pt-3 border-t border-slate-100 mb-6 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-sm text-[#ca9e54]"></i> 6 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-sm text-[#ca9e54]"></i> 5 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-sm text-[#ca9e54]"></i> 12 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-2xl font-bold text-[#152c4e]">$680</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="#villa" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors flex items-center gap-1">
                            Detail <i class="ri-arrow-right-line"></i>
                        </a>
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
                    <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-lg"></i>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">
                                Villa Tropical Serenity
                            </h3>
                            <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>4.8</span> <span class="text-xs font-normal text-slate-400">(203)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i>
                            Canggu, Bali
                        </p>
                        <div class="flex items-center justify-between text-xs text-slate-600 pt-3 border-t border-slate-100 mb-6 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-sm text-[#ca9e54]"></i> 4 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-sm text-[#ca9e54]"></i> 3 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-sm text-[#ca9e54]"></i> 8 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-xs text-slate-400 line-through mr-1.5">$450</span>
                            <span class="text-2xl font-bold text-[#152c4e]">$320</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="#villa" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors flex items-center gap-1">
                            Detail <i class="ri-arrow-right-line"></i>
                        </a>
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
                    <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-lg"></i>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">
                                Villa Sunset Cliff
                            </h3>
                            <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>4.9</span> <span class="text-xs font-normal text-slate-400">(156)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i>
                            Nusa Dua, Bali
                        </p>
                        <div class="flex items-center justify-between text-xs text-slate-600 pt-3 border-t border-slate-100 mb-6 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-sm text-[#ca9e54]"></i> 5 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-sm text-[#ca9e54]"></i> 4 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-sm text-[#ca9e54]"></i> 10 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-2xl font-bold text-[#152c4e]">$550</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="#villa" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors flex items-center gap-1">
                            Detail <i class="ri-arrow-right-line"></i>
                        </a>
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
                    <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-lg"></i>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">
                                Villa Emerald Hills
                            </h3>
                            <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>4.7</span> <span class="text-xs font-normal text-slate-400">(94)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i>
                            Ubud, Bali
                        </p>
                        <div class="flex items-center justify-between text-xs text-slate-600 pt-3 border-t border-slate-100 mb-6 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-sm text-[#ca9e54]"></i> 3 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-sm text-[#ca9e54]"></i> 3 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-sm text-[#ca9e54]"></i> 6 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-xs text-slate-400 line-through mr-1.5">$400</span>
                            <span class="text-2xl font-bold text-[#152c4e]">$280</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="#villa" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors flex items-center gap-1">
                            Detail <i class="ri-arrow-right-line"></i>
                        </a>
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
                    <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-lg"></i>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">
                                Villa Coastal Dream
                            </h3>
                            <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>4.8</span> <span class="text-xs font-normal text-slate-400">(178)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i>
                            Jimbaran, Bali
                        </p>
                        <div class="flex items-center justify-between text-xs text-slate-600 pt-3 border-t border-slate-100 mb-6 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-sm text-[#ca9e54]"></i> 4 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-sm text-[#ca9e54]"></i> 4 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-sm text-[#ca9e54]"></i> 8 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-2xl font-bold text-[#152c4e]">$420</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="#villa" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors flex items-center gap-1">
                            Detail <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Section Action Button -->
        <div class="text-center">
            <a href="#villa" class="inline-flex items-center gap-2 bg-[#152c4e] hover:bg-[#0f1e36] text-white font-semibold px-8 py-4 rounded-full shadow-md hover:shadow-lg transition duration-300 text-xs uppercase tracking-wider group">
                <span>Lihat Semua Villa</span>
                <i class="ri-arrow-right-line text-base group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </section>

    <!-- SECTION: PROMO TERBATAS -->
    <section id="promo" class="py-20 px-6 md:px-12 bg-gradient-to-b from-[#f4f6fa] to-[#f8f9fb] section-lazy font-satoshi">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold tracking-[0.2em] text-[#ca9e54] uppercase block mb-1">Penawaran Eksklusif</span>
                <h2 class="font-serif-title text-3xl md:text-5xl font-normal text-slate-900 mt-1">
                    Promo Terbatas
                </h2>
                <p class="text-slate-600 font-light text-base md:text-lg">
                    Jangan lewatkan pengalaman villa premium kami dengan harga terbaik
                </p>
            </div>

            <!-- Top Promo Grid (2 Main Banner Cards) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">

                <!-- Left Promo: Flash Sale -->
                <div class="bg-[#152c4e] text-white rounded-3xl p-8 md:p-10 shadow-xl relative overflow-hidden flex flex-col justify-between group">
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/5 rounded-full blur-2xl group-hover:scale-110 transition-transform"></div>
                    <div>
                        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-3.5 py-1 rounded-full text-xs font-semibold text-[#e5c382] mb-6 border border-white/10">
                            <i class="ri-time-line text-sm"></i>
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
                        <a href="#villa" class="inline-flex items-center justify-center gap-2 bg-[#ca9e54] hover:bg-[#b88c43] text-white font-semibold px-8 py-3.5 rounded-full shadow-lg transition duration-300 w-full sm:w-auto text-xs uppercase tracking-wider">
                            <span>Ambil Penawaran Sekarang</span>
                            <i class="ri-arrow-right-line text-base"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Promo: VIP Member Bonus -->
                <div class="bg-gradient-to-br from-[#d4af37] via-[#ca9e54] to-[#b88c43] text-white rounded-3xl p-8 md:p-10 shadow-xl relative overflow-hidden flex flex-col justify-between group">
                    <div class="absolute bottom-0 right-0 -mr-12 -mb-12 w-64 h-64 bg-black/10 rounded-full blur-2xl group-hover:scale-110 transition-transform"></div>
                    <div>
                        <div class="inline-flex items-center gap-2 bg-black/20 backdrop-blur-md px-3.5 py-1 rounded-full text-xs font-semibold text-white mb-6 border border-white/20">
                            <i class="ri-vip-crown-line text-sm"></i>
                            <span>Khusus Member VIP</span>
                        </div>
                        <h3 class="font-serif-title text-3xl md:text-4xl font-bold mb-4 leading-tight">
                            Bonus Booking Pertama
                        </h3>
                        <p class="text-white/90 font-light text-sm md:text-base mb-6 max-w-md">
                            Dapatkan diskon eksklusif 35% untuk reservasi villa pertama Anda
                        </p>

                        <!-- Features list -->
                        <ul class="space-y-3 mb-8 text-sm font-medium text-white/95">
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-lg text-white"></i>
                                <span>Transfer bandara gratis</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-lg text-white"></i>
                                <span>Makan malam selamat datang gratis</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-lg text-white"></i>
                                <span>Layanan concierge 24/7</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 bg-white text-slate-900 hover:bg-slate-50 font-bold px-8 py-3.5 rounded-full shadow-lg transition duration-300 w-full sm:w-auto text-xs uppercase tracking-wider">
                            <span>Mulai Sekarang</span>
                            <i class="ri-arrow-right-line text-base"></i>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom 3 Promo Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Feature Promo 1 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition duration-300 space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-[#152c4e]/10 text-[#152c4e] flex items-center justify-center text-xl">
                        <i class="ri-percent-line"></i>
                    </div>
                    <h4 class="font-serif-title text-xl font-bold text-slate-900">Spesial Musim Panas</h4>
                    <p class="text-xs text-slate-600 font-light leading-relaxed">
                        Hemat 25% untuk booking lebih dari 7 malam
                    </p>
                    <a href="#villa" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors pt-2">
                        <span>Pelajari Lebih Lanjut</span>
                        <i class="ri-arrow-right-line text-sm"></i>
                    </a>
                </div>

                <!-- Feature Promo 2 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition duration-300 space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-[#ca9e54]/10 text-[#ca9e54] flex items-center justify-center text-xl">
                        <i class="ri-gift-line"></i>
                    </div>
                    <h4 class="font-serif-title text-xl font-bold text-slate-900">Refer & Dapatkan</h4>
                    <p class="text-xs text-slate-600 font-light leading-relaxed">
                        Dapatkan kredit $100 untuk setiap referral teman
                    </p>
                    <a href="#villa" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors pt-2">
                        <span>Pelajari Lebih Lanjut</span>
                        <i class="ri-arrow-right-line text-sm"></i>
                    </a>
                </div>

                <!-- Feature Promo 3 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition duration-300 space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-xl">
                        <i class="ri-price-tag-3-line"></i>
                    </div>
                    <h4 class="font-serif-title text-xl font-bold text-slate-900">Promo Last Minute</h4>
                    <p class="text-xs text-slate-600 font-light leading-relaxed">
                        Hingga 50% off untuk booking minggu yang sama
                    </p>
                    <a href="#villa" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors pt-2">
                        <span>Pelajari Lebih Lanjut</span>
                        <i class="ri-arrow-right-line text-sm"></i>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: PERBEDAN PALMA ("Why Choose Us") -->
    <section id="tentang" class="py-24 px-6 md:px-12 bg-white section-lazy font-satoshi">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold tracking-[0.2em] text-[#ca9e54] uppercase block mb-1">Komitmen Kami</span>
                <h2 class="font-serif-title text-3xl md:text-5xl font-normal text-slate-900 mt-1">
                    Mengapa Memilih Palma
                </h2>
                <p class="text-slate-600 font-light text-base md:text-lg">
                    Rasakan kemewahan dan layanan tak tertandingi yang melampaui ekspektasi
                </p>
            </div>

            <!-- Value Cards Grid (6 Columns) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- Value 1 -->
                <div class="p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-[#152c4e] text-white flex items-center justify-center shadow-md text-2xl">
                        <i class="ri-shield-check-line"></i>
                    </div>
                    <h3 class="font-serif-title text-2xl font-bold text-slate-900">
                        Properti Terverifikasi
                    </h3>
                    <p class="text-slate-600 font-light text-sm leading-relaxed">
                        Setiap villa diperiksa dan diverifikasi secara personal oleh tim ahli kami untuk menjamin standar kualitas tertinggi.
                    </p>
                </div>

                <!-- Value 2 -->
                <div class="p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-[#ca9e54] text-white flex items-center justify-center shadow-md text-2xl">
                        <i class="ri-award-line"></i>
                    </div>
                    <h3 class="font-serif-title text-2xl font-bold text-slate-900">
                        Jaminan Harga Terbaik
                    </h3>
                    <p class="text-slate-600 font-light text-sm leading-relaxed">
                        Temukan harga lebih rendah? Kami akan menyamai dan memberikan 110% kembali dari selisih harga tersebut.
                    </p>
                </div>

                <!-- Value 3 -->
                <div class="p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-teal-600 text-white flex items-center justify-center shadow-md text-2xl">
                        <i class="ri-customer-service-2-line"></i>
                    </div>
                    <h3 class="font-serif-title text-2xl font-bold text-slate-900">
                        Concierge 24/7
                    </h3>
                    <p class="text-slate-600 font-light text-sm leading-relaxed">
                        Dukungan sepanjang waktu dari booking hingga checkout untuk memastikan pengalaman menginap Anda sempurna.
                    </p>
                </div>

                <!-- Value 4 -->
                <div class="p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-[#152c4e] text-white flex items-center justify-center shadow-md text-2xl">
                        <i class="ri-heart-pulse-line"></i>
                    </div>
                    <h3 class="font-serif-title text-2xl font-bold text-slate-900">
                        Layanan Personal
                    </h3>
                    <p class="text-slate-600 font-light text-sm leading-relaxed">
                        Rekomendasi villa yang disesuaikan secara khusus berdasarkan kebutuhan spesifik dan kenyamanan liburan keluarga Anda.
                    </p>
                </div>

                <!-- Value 5 -->
                <div class="p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-[#ca9e54] text-white flex items-center justify-center shadow-md text-2xl">
                        <i class="ri-flashlight-line"></i>
                    </div>
                    <h3 class="font-serif-title text-2xl font-bold text-slate-900">
                        Konfirmasi Instan
                    </h3>
                    <p class="text-slate-600 font-light text-sm leading-relaxed">
                        Proses booking cepat tanpa perlu menunggu konfirmasi manual lama, jadwal ketersediaan terbarui secara otomatis.
                    </p>
                </div>

                <!-- Value 6 -->
                <div class="p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-teal-600 text-white flex items-center justify-center shadow-md text-2xl">
                        <i class="ri-sparkles-line"></i>
                    </div>
                    <h3 class="font-serif-title text-2xl font-bold text-slate-900">
                        Keuntungan Eksklusif
                    </h3>
                    <p class="text-slate-600 font-light text-sm leading-relaxed">
                        Akses khusus ke promo rahasia, welcome drink spesial, dan bonus upgrade fasilitas villa pada setiap pemesanan.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: CTA BANNER -->
    <section class="py-20 px-6 md:px-12 bg-[#152c4e] text-white font-satoshi relative overflow-hidden">
        <div class="max-w-5xl mx-auto text-center space-y-6 relative z-10">
            <h2 class="font-serif-title text-3xl md:text-5xl font-bold">
                Siap Merasakan Kemewahan?
            </h2>
            <p class="text-white/80 font-light text-base md:text-lg max-w-2xl mx-auto leading-relaxed">
                Bergabunglah dengan ribuan tamu puas yang telah menemukan villa sempurna mereka bersama Palma.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                <a href="#villa" class="w-full sm:w-auto bg-[#ca9e54] hover:bg-[#b88c43] text-white font-semibold px-9 py-4 rounded-full shadow-lg transition duration-300 text-xs uppercase tracking-wider">
                    Jelajahi Villa Sekarang
                </a>
                <a href="#tentang" class="w-full sm:w-auto glass-pill hover:bg-white/20 text-white font-medium px-9 py-4 rounded-full transition duration-300 text-xs uppercase tracking-wider">
                    Hubungi Concierge
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION: KATA TAMU KAMI (TESTIMONIALS & TRUST STATS) -->
    <section class="py-24 px-6 md:px-12 bg-[#f8f9fb] font-satoshi section-lazy">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold tracking-[0.2em] text-[#ca9e54] uppercase block mb-1">Ulasan Tamu</span>
                <h2 class="font-serif-title text-3xl md:text-5xl font-normal text-slate-900 mt-1">
                    Kata Mereka
                </h2>
                <p class="text-slate-600 font-light text-base md:text-lg">
                    Pengalaman jujur dari para tamu yang telah menikmati liburan bersama Palma
                </p>
            </div>

            <!-- Testimonial Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Testimonial 1 -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <div class="flex text-[#ca9e54] gap-1 text-lg">
                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                        </div>
                        <p class="text-xs text-slate-600 font-light leading-relaxed italic">
                            "Liburan keluarga terbaik kami di Seminyak. Pelayanan dari concierge Palma sangat luar biasa ramah dan villa persis sesuai dengan foto!"
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=75" alt="Sarah J." class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h4 class="font-bold text-xs text-slate-900">Sarah & Family</h4>
                            <span class="text-[10px] text-[#152c4e] font-semibold block">Menginap di Villa Azure Paradise</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <div class="flex text-[#ca9e54] gap-1 text-lg">
                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                        </div>
                        <p class="text-xs text-slate-600 font-light leading-relaxed italic">
                            "Pemandangan tebing Uluwatu dari villa ini benar-benar tidak ada tandingannya. Kebersihan dan privasinya 100% terjaga."
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=75" alt="Michael T." class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h4 class="font-bold text-xs text-slate-900">Michael Thompson</h4>
                            <span class="text-[10px] text-[#152c4e] font-semibold block">Menginap di Villa Ocean Breeze</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <div class="flex text-[#ca9e54] gap-1 text-lg">
                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                        </div>
                        <p class="text-xs text-slate-600 font-light leading-relaxed italic">
                            "Proses booking instan tanpa ribet. Dan jaminan harga terbaik dari Palma terbukti nyata. Kami pasti akan reservasi kembali!"
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=75" alt="Jessica M." class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h4 class="font-bold text-xs text-slate-900">Jessica & David</h4>
                            <span class="text-[10px] text-[#152c4e] font-semibold block">Menginap di Villa Tropical Serenity</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Trust Bar -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm grid grid-cols-1 md:grid-cols-3 gap-6 text-center divide-y md:divide-y-0 md:divide-x divide-slate-100">
                <div class="py-2">
                    <span class="text-3xl font-bold text-[#152c4e] font-serif-title block">4.9 ★</span>
                    <span class="text-xs text-slate-500 font-light uppercase tracking-wider">Rating Pelanggan</span>
                </div>
                <div class="py-2">
                    <span class="text-3xl font-bold text-[#152c4e] font-serif-title block">2,500+</span>
                    <span class="text-xs text-slate-500 font-light uppercase tracking-wider">Tamu Senang</span>
                </div>
                <div class="py-2">
                    <span class="text-3xl font-bold text-[#152c4e] font-serif-title block">98%</span>
                    <span class="text-xs text-slate-500 font-light uppercase tracking-wider">Tingkat Kepuasan</span>
                </div>
            </div>
        </div>
    </section>
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
</script>
@endpush
