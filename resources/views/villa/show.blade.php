@extends('layouts.frontend.main')

@section('title', 'Villa Azure Ocean Sanctuary - Seminyak, Bali | Palma Luxury')

@section('content')
    <!-- BREADCRUMB & HEADER -->
    <section class="pt-28 pb-6 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi">
        <div class="flex items-center justify-between gap-4 mb-4 flex-wrap">
            <!-- Breadcrumbs Trail -->
            <div class="flex items-center gap-2 text-xs sm:text-sm text-slate-500 font-medium">
                <a href="{{ route('home') }}" class="hover:text-[#ca9e54] transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('villa.index') }}" class="hover:text-[#ca9e54] transition-colors">Villa</a>
                <span>/</span>
                <span class="text-slate-700 font-semibold truncate">Villa Azure Ocean Sanctuary</span>
            </div>

            <!-- Elegant Minimalist Back Button (Pure Text) -->
            <a href="{{ route('villa.index') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 hover:text-[#ca9e54] transition-colors">
                <i class="ri-arrow-left-line text-sm sm:text-base"></i>
                <span>Kembali ke Daftar Villa</span>
            </a>
        </div>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-[#ca9e54] text-white text-xs font-bold px-3.5 py-1 rounded-full uppercase tracking-wider">Superhost</span>
                    <span class="bg-[#152c4e]/10 text-[#152c4e] text-xs font-bold px-3.5 py-1 rounded-full uppercase tracking-wider">Beachfront Sanctuary</span>
                </div>
                <h1 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-slate-900 leading-tight">
                    Villa Azure Ocean Sanctuary
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 font-medium flex items-center gap-2 mt-2 flex-wrap">
                    <i class="ri-map-pin-2-fill text-[#ca9e54]"></i>
                    <span>Jl. Kayu Aya No. 88, Seminyak, Bali, Indonesia</span>
                    <span>•</span>
                    <span class="flex items-center gap-1 font-bold text-slate-900">
                        <i class="ri-star-fill text-[#ca9e54]"></i> 4.95 (142 Ulasan)
                    </span>
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2.5 flex-wrap sm:flex-nowrap">
                <button onclick="shareVilla()" class="px-4 py-2.5 rounded-full border border-slate-200 text-slate-700 hover:border-slate-900 text-xs font-bold flex items-center gap-2 transition-colors cursor-pointer">
                    <i class="ri-share-line text-sm"></i> Bagikan
                </button>
                <button id="detail-fav-btn" onclick="toggleFav(this)" class="px-4 py-2.5 rounded-full border border-slate-200 text-slate-700 hover:text-red-500 hover:border-red-200 text-xs font-bold flex items-center gap-2 transition-colors cursor-pointer">
                    <i class="ri-heart-line text-sm" id="fav-icon"></i> Simpan
                </button>
            </div>
        </div>
    </section>

    <!-- PHOTO GALLERY GRID SECTION (TRAVELOKA STYLE) -->
    <section class="px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi mb-12">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-2 sm:gap-3 overflow-hidden relative p-1.5 group/gallery">
            
            <!-- Main Featured Image (Mobile: Wide Banner across 2 cols, Desktop: Left 2 Cols x 2 Rows) -->
            <div class="col-span-2 md:col-span-2 md:row-span-2 h-52 sm:h-72 md:h-[460px] relative overflow-hidden rounded-2xl group cursor-pointer" onclick="openLightbox(0)">
                <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1400&q=85" alt="Villa Azure Exterior" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors"></div>
            </div>

            <!-- Grid Image 1 (Mobile: Col 1, Row 2) -->
            <div class="col-span-1 h-32 sm:h-44 md:h-[224px] relative overflow-hidden rounded-2xl group cursor-pointer" onclick="openLightbox(1)">
                <img src="https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=800&q=85" alt="Infinity Pool" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <!-- Grid Image 2 (Mobile: Col 2, Row 2) -->
            <div class="col-span-1 h-32 sm:h-44 md:h-[224px] relative overflow-hidden rounded-2xl group cursor-pointer" onclick="openLightbox(2)">
                <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=800&q=85" alt="Master Bedroom" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <!-- Grid Image 3 (Mobile: Col 1, Row 3) -->
            <div class="col-span-1 h-32 sm:h-44 md:h-[224px] relative overflow-hidden rounded-2xl group cursor-pointer" onclick="openLightbox(3)">
                <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=85" alt="Gazebo Lounge" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <!-- Grid Image 4 (Mobile: Col 2, Row 3) -->
            <div class="col-span-1 h-32 sm:h-44 md:h-[224px] relative overflow-hidden rounded-2xl group cursor-pointer" onclick="openLightbox(4)">
                <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=800&q=85" alt="Sunset Terrace" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <!-- Grid Image 5 (Mobile: Col 1, Row 4) -->
            <div class="col-span-1 h-32 sm:h-44 md:h-[224px] relative overflow-hidden rounded-2xl group cursor-pointer" onclick="openLightbox(5)">
                <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=800&q=85" alt="Marble Bathroom" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <!-- Grid Image 6 (Mobile: Col 2, Row 4 - With 'Lihat Semua Foto' Overlay) -->
            <div class="col-span-1 h-32 sm:h-44 md:h-[224px] relative overflow-hidden rounded-2xl group cursor-pointer" onclick="openLightbox(0)">
                <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=85" alt="Garden View" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-slate-950/65 backdrop-blur-[2px] group-hover:bg-slate-950/50 transition-colors flex flex-col items-center justify-center text-white text-center p-2">
                    <i class="ri-grid-fill text-lg sm:text-2xl text-[#e5c382] mb-0.5"></i>
                    <span class="font-bold text-[11px] sm:text-sm">Lihat Semua Foto</span>
                    <span class="text-[9px] sm:text-[10px] text-white/75 font-light mt-0.5">9 Foto Galeri</span>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT & POV BOOKING SIDEBAR GRID -->
    <section class="px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- LEFT COLUMN: VILLA SPECIFICATIONS & DETAILS -->
            <div class="lg:col-span-2 space-y-10">

                <!-- Host Profile & Highlights -->
                <div class="flex items-center justify-between pb-8 border-b border-slate-200/80">
                    <div class="space-y-1">
                        <h2 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">
                            Dipandu oleh Concierge Tim Palma VIP
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500">
                            10 Tamu • 5 Kamar Tidur • 5 Kamar Mandi • 6 Tempat Tidur • Oceanfront Pool
                        </p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-[#152c4e] text-white flex items-center justify-center font-bold text-lg shadow-md shrink-0">
                        PLM
                    </div>
                </div>

                <!-- Feature Highlights Badges -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-8 border-b border-slate-200/80">
                    <div class="flex gap-4 p-4 rounded-2xl bg-white border border-slate-100 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-[#ca9e54]/10 text-[#ca9e54] flex items-center justify-center text-xl shrink-0">
                            <i class="ri-shield-star-line"></i>
                        </div>
                        <div>
                            <h4 class="text-xs sm:text-sm font-bold text-slate-900">Keamanan & Kebersihan Bintang 5</h4>
                            <p class="text-[11px] text-slate-500 font-light mt-0.5">Disterilkan sebelum kedatangan dengan butler pribadi 24 jam.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 p-4 rounded-2xl bg-white border border-slate-100 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-[#152c4e]/10 text-[#152c4e] flex items-center justify-center text-xl shrink-0">
                            <i class="ri-cup-line"></i>
                        </div>
                        <div>
                            <h4 class="text-xs sm:text-sm font-bold text-slate-900">Sarapan Apung & Koki Pribadi</h4>
                            <p class="text-[11px] text-slate-500 font-light mt-0.5">Nikmati Floating Breakfast gratis di hari pertama menginap.</p>
                        </div>
                    </div>
                </div>

                <!-- Villa Description -->
                <div class="space-y-4 pb-8 border-b border-slate-200/80">
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">Tentang Villa Ini</h3>
                    <div class="text-xs sm:text-sm text-slate-600 font-light leading-relaxed space-y-3">
                        <p>
                            Selamat datang di <strong>Villa Azure Ocean Sanctuary</strong>, sebuah mahakarya arsitektur tropis modern yang terletak tepat di tepi pantai privat Seminyak, Bali. Memadukan keanggunan kemewahan bintang lima dengan suasana hangat alam Samudra Hindia.
                        </p>
                        <p>
                            Villa ini dilengkapi dengan kolam renang infinity sepanjang 18 meter yang menghadap ke matahari terbenam, ruang santai udara terbuka (*open-air lounge*), dapur lengkap dengan peralatan koki profesional, serta 5 kamar tidur utama (*master suite*) berpemandangan laut lepas dengan kamar mandi marmer dan bathtub berdiri bebas (*standalone tub*).
                        </p>
                    </div>
                </div>

                <!-- Amenities Checklist -->
                <div class="space-y-6 pb-8 border-b border-slate-200/80">
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">Fasilitas Mewah Utama</h3>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs sm:text-sm font-medium text-slate-800">
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                            <i class="ri-contrast-drop-line text-lg text-[#ca9e54]"></i>
                            <span>Infinity Pool 18m</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                            <i class="ri-wifi-line text-lg text-[#ca9e54]"></i>
                            <span>Starlink High-Speed WiFi</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                            <i class="ri-user-star-line text-lg text-[#ca9e54]"></i>
                            <span>Butler 24/7 Service</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                            <i class="ri-car-line text-lg text-[#ca9e54]"></i>
                            <span>Transfer Bandara Alphard</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                            <i class="ri-restaurant-line text-lg text-[#ca9e54]"></i>
                            <span>Koki Pribadi In-Villa</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                            <i class="ri-sun-line text-lg text-[#ca9e54]"></i>
                            <span>Akses Pantai Privat</span>
                        </div>
                    </div>
                </div>

                <!-- Location & Nearby Tourist Attractions -->
                <div class="space-y-6 pb-8 border-b border-slate-200/80">
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">Rekomendasi Wisata Terdekat</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('wisata.index') }}" class="p-4 rounded-2xl border border-slate-100 bg-white hover:border-[#ca9e54] transition-colors flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=150&q=75" alt="Seminyak Beach" class="w-12 h-12 rounded-xl object-cover">
                                <div>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#152c4e]">Seminyak Beach Club</h4>
                                    <span class="text-[11px] text-slate-400">3 Menit Jalan Kaki</span>
                                </div>
                            </div>
                            <i class="ri-arrow-right-s-line text-slate-400 group-hover:text-[#ca9e54]"></i>
                        </a>

                        <a href="{{ route('wisata.index') }}" class="p-4 rounded-2xl border border-slate-100 bg-white hover:border-[#ca9e54] transition-colors flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=150&q=75" alt="Uluwatu Temple" class="w-12 h-12 rounded-xl object-cover">
                                <div>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#152c4e]">Pura Uluwatu & Kecak</h4>
                                    <span class="text-[11px] text-slate-400">25 Menit Berkendara</span>
                                </div>
                            </div>
                            <i class="ri-arrow-right-s-line text-slate-400 group-hover:text-[#ca9e54]"></i>
                        </a>
                    </div>
                </div>

                <!-- GOOGLE MAPS LOCATION SECTION -->
                <div class="space-y-4 pt-8 border-t border-slate-200/80">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold tracking-widest text-[#ca9e54] uppercase block">LOKASI & PETA VILLA</span>
                            <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">Seminyak, Kuta, Bali</h3>
                        </div>
                        <a href="https://maps.google.com/?q=Seminyak,+Bali" target="_blank" class="px-4 py-2 rounded-full border border-slate-200 text-slate-700 hover:border-[#152c4e] hover:text-[#152c4e] text-xs font-bold transition-colors flex items-center gap-1.5 cursor-pointer">
                            <i class="ri-map-pin-2-fill text-[#ca9e54]"></i> Buka di Google Maps
                        </a>
                    </div>
                    <p class="text-xs text-slate-500 flex items-center gap-1.5">
                        <i class="ri-map-pin-line text-slate-400"></i> Jl. Kayu Aya No. 88, Seminyak, Kuta, Kabupaten Badung, Bali 80361
                    </p>

                    <!-- Embedded Interactive Google Maps Container -->
                    <div class="w-full h-72 sm:h-96 overflow-hidden border border-slate-200/80 relative">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15777.625447702812!2d115.15041492671511!3d-8.688326776100902!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2472714a51e6b%3A0xb30d319e64e5c464!2sSeminyak%2C%20Kuta%2C%20Badung%20Regency%2C%20Bali!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                            class="w-full h-full border-0" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                <!-- Verified Reviews -->
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">Ulasan Tamu Terverifikasi</h3>
                        <span class="text-xs font-bold text-[#ca9e54] flex items-center gap-1">
                            <i class="ri-star-fill"></i> 4.95 / 5.0
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-5 rounded-2xl bg-slate-50 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=75" alt="Sarah J." class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <h5 class="text-xs font-bold text-slate-900">Sarah Jenkins</h5>
                                        <span class="text-[10px] text-slate-400">Australia • Juli 2026</span>
                                    </div>
                                </div>
                                <div class="flex text-[#ca9e54] text-xs">
                                    <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 font-light leading-relaxed">
                                "Pengalaman paling berkesan! Pemandangan sunset dari infinity pool sangat menakjubkan, dan layanan koki pribadinya luar biasa lezat."
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=75" alt="Michael R." class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <h5 class="text-xs font-bold text-slate-900">Michael Ross</h5>
                                        <span class="text-[10px] text-slate-400">Singapura • Juni 2026</span>
                                    </div>
                                </div>
                                <div class="flex text-[#ca9e54] text-xs">
                                    <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 font-light leading-relaxed">
                                "Sangat direkomendasikan untuk staycation keluarga. Anak-anak sangat menyukai kolam renangnya dan fasilitasnya amat lengkap."
                            </p>
                        </div>
                    </div>

                    <!-- CTA BUTTON TO OPEN ALL REVIEWS MODAL -->
                    <button onclick="openReviewsModal()" class="w-full py-4 bg-slate-50 hover:bg-slate-100 text-[#152c4e] font-bold text-xs rounded-2xl border border-slate-200/80 hover:border-[#152c4e] transition-colors flex items-center justify-center gap-2 cursor-pointer group shadow-sm">
                        <i class="ri-chat-smile-2-line text-base text-[#ca9e54]"></i>
                        <span>Lihat Semua 142 Ulasan & Komentar Tamu</span>
                        <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>

            </div>

            <!-- RIGHT COLUMN: POV INTERACTIVE BOOKING CARD (STATIC POSITION) -->
            <div class="lg:col-span-1" id="booking-form-box">
                <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-2xl border border-slate-100 space-y-6 border-t-4 border-t-[#ca9e54] relative overflow-hidden">
                    
                    <!-- VIP Badge Top Banner -->
                    <div class="flex items-center justify-between bg-[#152c4e] text-white p-3.5 -mx-6 sm:-mx-7 -mt-6 sm:-mt-7 mb-2">
                        <div class="flex items-center gap-2">
                            <i class="ri-vip-crown-fill text-[#e5c382]"></i>
                            <span class="text-[10px] font-bold tracking-widest uppercase text-white">RESERVASI VILLA REKOMENDASI</span>
                        </div>
                        <span class="bg-[#ca9e54]/20 text-[#e5c382] border border-[#ca9e54]/40 text-[9px] font-bold px-2 py-0.5 rounded-full">⭐ 4.95 Superhost</span>
                    </div>

                    <!-- Price Header -->
                    <div class="flex items-baseline justify-between pb-5 border-b border-slate-100">
                        <div>
                            <span class="text-xs text-slate-400 line-through mr-1.5 font-mono">$650</span>
                            <span class="text-3xl font-bold text-[#152c4e] font-serif-title" id="display-price-per-night">$450</span>
                            <span class="text-xs font-light text-slate-500">/ malam</span>
                        </div>
                        <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider border border-emerald-200/60">Hemat 30% Hari Ini</span>
                    </div>

                    <!-- Date & Guest Selector Form -->
                    <div class="space-y-4">
                        <!-- Dates Picker -->
                        <div class="grid grid-cols-2 gap-2 bg-slate-50/80 p-3 rounded-2xl border border-slate-200/80">
                            <div>
                                <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                                    <i class="ri-calendar-event-line text-[#ca9e54]"></i> CHECK-IN
                                </label>
                                <input type="date" id="book-checkin" value="2026-08-15" onchange="calculateBookingTotal()" class="w-full bg-transparent text-xs font-bold text-slate-900 focus:outline-none cursor-pointer">
                            </div>
                            <div class="border-l border-slate-200/80 pl-3">
                                <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                                    <i class="ri-calendar-check-line text-[#ca9e54]"></i> CHECK-OUT
                                </label>
                                <input type="date" id="book-checkout" value="2026-08-18" onchange="calculateBookingTotal()" class="w-full bg-transparent text-xs font-bold text-slate-900 focus:outline-none cursor-pointer">
                            </div>
                        </div>

                        <!-- Guest Select -->
                        <div class="bg-slate-50/80 p-3 rounded-2xl border border-slate-200/80">
                            <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                                <i class="ri-user-star-line text-[#ca9e54]"></i> JUMLAH TAMU RESERVASI
                            </label>
                            <select id="book-guests" class="w-full bg-transparent text-xs font-bold text-slate-900 focus:outline-none cursor-pointer">
                                <option value="2">2 Tamu (Pasangan / Private Couple)</option>
                                <option value="4">4 Tamu (Keluarga Kecil)</option>
                                <option value="6">6 Tamu (Grup / Keluarga)</option>
                                <option value="8" selected>8 - 10 Tamu (Keluarga Besar VVIP)</option>
                            </select>
                        </div>

                        <!-- Optional Add-ons Checkboxes -->
                        <div class="space-y-2 pt-1">
                            <span class="text-[10px] uppercase font-bold text-slate-500 block tracking-wider flex items-center gap-1">
                                <i class="ri-add-circle-line text-[#ca9e54]"></i> LAYANAN TAMBAHAN (OPTIONAL):
                            </span>
                            
                            <label class="flex items-center justify-between p-3 rounded-2xl border border-slate-200/80 hover:bg-slate-50/80 transition-colors cursor-pointer text-xs group">
                                <div class="flex items-center gap-2.5">
                                    <input type="checkbox" id="addon-transfer" onchange="calculateBookingTotal()" checked class="w-4 h-4 rounded border-slate-300 text-[#ca9e54] focus:ring-[#ca9e54] cursor-pointer">
                                    <span class="text-slate-700 font-semibold group-hover:text-slate-900 flex items-center gap-1.5">
                                        <i class="ri-car-fill text-slate-400"></i> Alphard Transfer Bandara
                                    </span>
                                </div>
                                <span class="font-bold text-slate-900 font-mono">+$50</span>
                            </label>

                            <label class="flex items-center justify-between p-3 rounded-2xl border border-slate-200/80 hover:bg-slate-50/80 transition-colors cursor-pointer text-xs group">
                                <div class="flex items-center gap-2.5">
                                    <input type="checkbox" id="addon-chef" onchange="calculateBookingTotal()" class="w-4 h-4 rounded border-slate-300 text-[#ca9e54] focus:ring-[#ca9e54] cursor-pointer">
                                    <span class="text-slate-700 font-semibold group-hover:text-slate-900 flex items-center gap-1.5">
                                        <i class="ri-restaurant-2-fill text-slate-400"></i> Koki Pribadi Dinner
                                    </span>
                                </div>
                                <span class="font-bold text-slate-900 font-mono">+$120</span>
                            </label>
                        </div>
                    </div>

                    <!-- Price Breakdown Summary Card -->
                    <div class="bg-slate-50/90 p-4 rounded-2xl space-y-2.5 border border-slate-200/70 text-xs">
                        <div class="flex justify-between text-slate-600">
                            <span>$450 × <span id="summary-nights" class="font-bold text-slate-900">3</span> malam</span>
                            <span class="font-bold text-slate-900 font-mono" id="summary-subtotal">$1,350</span>
                        </div>
                        <div class="flex justify-between text-slate-600" id="row-addon">
                            <span>Layanan Tambahan</span>
                            <span class="font-bold text-slate-900 font-mono" id="summary-addons">$50</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Pajak & Layanan (10%)</span>
                            <span class="font-bold text-slate-900 font-mono" id="summary-tax">$140</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-slate-900 pt-3 border-t border-slate-200/80">
                            <span class="flex items-center gap-1">Total Pembayaran</span>
                            <span class="text-2xl font-bold text-[#152c4e] font-serif-title" id="summary-total">$1,540</span>
                        </div>
                    </div>

                    <!-- CTA BUTTON TO LAUNCH POV BOOKING MODAL -->
                    <button onclick="openPovModal()" class="w-full bg-[#152c4e] hover:bg-[#0f1d32] text-white font-bold py-4 rounded-2xl text-xs uppercase tracking-wider transition duration-300 shadow-xl flex items-center justify-center gap-2 cursor-pointer group">
                        <i class="ri-shield-check-fill text-base text-[#e5c382]"></i>
                        <span>Konfirmasi Reservasi POV</span>
                        <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform"></i>
                    </button>

                    <!-- Trust Seals -->
                    <div class="grid grid-cols-3 gap-1 text-[9px] text-center text-slate-400 font-medium pt-1 border-t border-slate-100">
                        <div class="flex items-center justify-center gap-1"><i class="ri-lock-line text-emerald-600"></i> SSL 256-Bit</div>
                        <div class="flex items-center justify-center gap-1"><i class="ri-flashlight-fill text-[#ca9e54]"></i> Instan Konfirmasi</div>
                        <div class="flex items-center justify-center gap-1"><i class="ri-price-tag-3-line text-blue-600"></i> Garansi Terbaik</div>
                    </div>
                </div>
            </div>

        </div>    <!-- STEP-BY-STEP POV BOOKING MODAL -->
    <div id="pov-booking-modal" onclick="closePovModal()" class="fixed inset-0 bg-[#0c182b]/80 backdrop-blur-md z-[70] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl w-full max-w-xl overflow-hidden shadow-2xl border border-slate-100 font-satoshi transform scale-95 transition-transform duration-300 relative max-h-[90vh] flex flex-col" id="pov-modal-box" onclick="event.stopPropagation()">
            
            <!-- Modal Header -->
            <div class="p-5 sm:p-6 bg-[#152c4e] text-white flex items-center justify-between shrink-0">
                <div>
                    <span class="text-[9px] uppercase font-bold tracking-widest text-[#e5c382] block">POV RESERVASI VILLA</span>
                    <h3 class="font-serif-title text-xl font-bold">Konfirmasi Pemesanan Langsung</h3>
                </div>
                <button onclick="closePovModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer">
                    <i class="ri-close-line text-lg"></i>
                </button>
            </div>

            <!-- Modal Body (Steps) -->
            <div class="p-6 sm:p-8 overflow-y-auto space-y-6 flex-1" id="pov-modal-body">
                
                <!-- STEP 1: GUEST FORM -->
                <div id="pov-step-1" class="space-y-4">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-400 pb-2 border-b border-slate-100">
                        <span>LANGKAH 1 DARI 2</span>
                        <span class="text-[#ca9e54]">Data Tamu Utama</span>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">NAMA LENGKAP TAMU</label>
                            <input type="text" id="pov-name" value="Budi Santoso" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-semibold text-slate-900 focus:outline-none focus:border-[#ca9e54]">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">EMAIL KONFIRMASI</label>
                                <input type="email" id="pov-email" value="budi.santoso@gmail.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-semibold text-slate-900 focus:outline-none focus:border-[#ca9e54]">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">NOMOR WHATSAPP</label>
                                <input type="tel" id="pov-phone" value="+62 812 3456 7890" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-semibold text-slate-900 focus:outline-none focus:border-[#ca9e54]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">METODE PEMBAYARAN</label>
                            <select id="pov-payment" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-bold text-slate-900 focus:outline-none focus:border-[#ca9e54] cursor-pointer">
                                <option value="bca">BCA Virtual Account (Otomatis)</option>
                                <option value="mandiri">Mandiri Virtual Account</option>
                                <option value="qris">QRIS (GoPay / OVO / ShopeePay)</option>
                                <option value="card">Kartu Kredit Visa / Mastercard</option>
                            </select>
                        </div>
                    </div>

                    <button onclick="goToPovStep2()" class="w-full bg-[#152c4e] hover:bg-[#0f1e36] text-white font-bold py-3.5 rounded-xl text-xs uppercase tracking-wider transition-colors mt-4 cursor-pointer">
                        Lanjut ke Pembayaran Simulator &rarr;
                    </button>
                </div>

                <!-- STEP 2: SUCCESS CHECKOUT (POV SIMULATION RESULT - VIP BOARDING PASS CARD) -->
                <div id="pov-step-2" class="space-y-5 hidden text-center py-2">
                    <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-3xl shadow-md">
                        <i class="ri-checkbox-circle-fill"></i>
                    </div>

                    <div class="space-y-1">
                        <span class="text-[9px] uppercase font-bold tracking-widest text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">RESERVASI VVIP TERKONFIRMASI LUNAS</span>
                        <h4 class="font-serif-title text-xl font-bold text-slate-900 pt-1">E-Voucher Tiket Resmi Terbit!</h4>
                    </div>

                    <!-- Luxury Boarding Pass Ticket Preview Card -->
                    <div class="bg-[#152c4e] text-white rounded-3xl p-5 border border-slate-800 text-left space-y-4 shadow-xl relative overflow-hidden">
                        <!-- Background Pattern Accent -->
                        <div class="absolute -right-10 -bottom-10 w-32 h-32 rounded-full bg-[#ca9e54]/10 blur-2xl pointer-events-none"></div>

                        <!-- Ticket Header -->
                        <div class="flex items-center justify-between border-b border-white/10 pb-3">
                            <div>
                                <span class="text-[9px] text-[#e5c382] font-bold uppercase tracking-widest block">PALMA LUXURY TICKET</span>
                                <h5 class="font-serif-title font-bold text-sm text-white">Villa Azure Ocean Sanctuary</h5>
                            </div>
                            <div class="text-right">
                                <span class="text-[9px] text-white/50 block font-mono">KODE VOUCHER</span>
                                <strong class="font-mono text-[#e5c382] text-xs font-bold" id="pov-voucher-code">#PLM-88942</strong>
                            </div>
                        </div>

                        <!-- Ticket Body Details -->
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div>
                                <span class="text-white/50 block text-[9px] font-medium">NAMA TAMU VVIP:</span>
                                <strong class="text-white font-bold" id="res-name">Budi Santoso</strong>
                            </div>
                            <div>
                                <span class="text-white/50 block text-[9px] font-medium">DURASI MENGINAP:</span>
                                <strong class="text-white font-bold">3 Malam (15-18 Ags 2026)</strong>
                            </div>
                            <div>
                                <span class="text-white/50 block text-[9px] font-medium">TIPE PROPERTI:</span>
                                <span class="text-slate-300 font-medium">5-Bedroom Beachfront Suite</span>
                            </div>
                            <div>
                                <span class="text-white/50 block text-[9px] font-medium">STATUS PEMBAYARAN:</span>
                                <span class="bg-emerald-500/20 text-emerald-300 border border-emerald-400/40 text-[9px] font-bold px-2 py-0.5 rounded-full inline-block mt-0.5">LUNAS / VERIFIED</span>
                            </div>
                        </div>

                        <!-- Dashed Divider & QR Code Bar -->
                        <div class="pt-3 border-t border-dashed border-white/20 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="ri-qr-code-line text-3xl text-[#e5c382]"></i>
                                <div class="text-[10px]">
                                    <span class="text-white/80 font-bold block">Tunjukkan QR ke Concierge</span>
                                    <span class="text-white/50 text-[9px]">Layanan Butler 24/7 Siap Menyambut</span>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-[#e5c382] bg-white/10 px-2.5 py-1 rounded-lg">PALMA VIP PASS</span>
                        </div>
                    </div>

                    <div class="space-y-2 pt-1">
                        <button onclick="simulatedDownloadPdf()" class="w-full bg-[#ca9e54] hover:bg-[#b88c43] text-white font-bold py-3.5 rounded-2xl text-xs uppercase tracking-wider transition-colors shadow-md flex items-center justify-center gap-2 cursor-pointer">
                            <i class="ri-file-download-line text-base"></i>
                            <span>Unduh E-Voucher PDF Resmi</span>
                        </button>

                        <button onclick="closePovModal()" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3.5 rounded-2xl text-xs uppercase tracking-wider transition-colors cursor-pointer">
                            Selesai & Kembalikan ke Detail
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- FULLSCREEN INTERACTIVE LIGHTBOX GALLERY MODAL (PURE IMAGES ONLY) -->
    <div id="gallery-lightbox-modal" onclick="closeLightbox()" class="fixed inset-0 bg-[#0c182b]/85 backdrop-blur-2xl z-[100] flex flex-col justify-between p-3 sm:p-6 hidden opacity-0 transition-opacity duration-300 select-none">
        
        <!-- Lightbox Top Control Bar -->
        <div class="flex items-center justify-between text-white z-20 pb-2 border-b border-white/10" onclick="event.stopPropagation()">
            <div class="flex items-center gap-2">
                <span class="text-[#ca9e54] font-bold text-xs sm:text-sm uppercase tracking-wider font-mono" id="lightbox-counter-text">1 / 9</span>
            </div>
            <button onclick="closeLightbox()" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer text-lg" title="Tutup (ESC)">
                <i class="ri-close-line"></i>
            </button>
        </div>

        <!-- Main Display Container (Image + Floating Arrows) -->
        <div class="relative flex-1 flex items-center justify-center my-auto py-2">
            
            <!-- Floating Left Arrow Button -->
            <button onclick="event.stopPropagation(); prevPhoto();" class="absolute left-2 sm:left-12 z-30 w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-slate-900/80 hover:bg-[#ca9e54] text-white flex items-center justify-center transition-all duration-300 shadow-2xl backdrop-blur-md cursor-pointer border border-white/20 hover:border-transparent active:scale-95">
                <i class="ri-arrow-left-s-line text-2xl sm:text-3xl"></i>
            </button>

            <!-- Active Photo Frame -->
            <div class="relative max-w-5xl max-h-[70vh] flex items-center justify-center" onclick="event.stopPropagation()">
                <img id="lightbox-main-img" src="" alt="Gallery Active Photo" class="max-w-full max-h-[68vh] object-contain rounded-2xl shadow-2xl transition-all duration-300">
            </div>

            <!-- Floating Right Arrow Button -->
            <button onclick="event.stopPropagation(); nextPhoto();" class="absolute right-2 sm:right-12 z-30 w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-slate-900/80 hover:bg-[#ca9e54] text-white flex items-center justify-center transition-all duration-300 shadow-2xl backdrop-blur-md cursor-pointer border border-white/20 hover:border-transparent active:scale-95">
                <i class="ri-arrow-right-s-line text-2xl sm:text-3xl"></i>
            </button>

        </div>

        <!-- Bottom Thumbnail Strip -->
        <div class="border-t border-white/10 pt-3 max-w-5xl mx-auto w-full z-20" onclick="event.stopPropagation()">
            <div class="flex items-center justify-center gap-2 overflow-x-auto py-1 no-scrollbar" id="lightbox-thumbnails">
                <!-- JS Rendered Thumbnail Items -->
            </div>
        </div>

    </div>

    <!-- INTERACTIVE ALL REVIEWS MODAL -->
    <div id="all-reviews-modal" onclick="closeReviewsModal()" class="fixed inset-0 bg-[#0c182b]/80 backdrop-blur-md z-[80] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl w-full max-w-3xl overflow-hidden shadow-2xl border border-slate-100 font-satoshi transform scale-95 transition-transform duration-300 relative max-h-[90vh] flex flex-col" id="reviews-modal-box" onclick="event.stopPropagation()">
            
            <!-- Modal Header -->
            <div class="p-5 sm:p-6 bg-[#152c4e] text-white flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center text-[#e5c382]">
                        <i class="ri-star-fill text-xl"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-lg">4.95 / 5.0</span>
                            <span class="text-xs text-[#e5c382] font-semibold">• 142 Ulasan Terverifikasi</span>
                        </div>
                        <p class="text-xs text-white/70 font-light">Ulasan otentik dari tamu yang telah menginap di Villa Azure</p>
                    </div>
                </div>
                <button onclick="closeReviewsModal()" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer text-lg">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <!-- Modal Rating Sub-Breakdown -->
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200/70 grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs shrink-0">
                <div class="flex flex-col">
                    <span class="text-slate-500 text-[10px]">Kebersihan</span>
                    <span class="font-bold text-slate-900 flex items-center gap-1">4.9 <i class="ri-star-fill text-[#ca9e54] text-[10px]"></i></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-slate-500 text-[10px]">Pelayanan Butler</span>
                    <span class="font-bold text-slate-900 flex items-center gap-1">5.0 <i class="ri-star-fill text-[#ca9e54] text-[10px]"></i></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-slate-500 text-[10px]">Akses Lokasi</span>
                    <span class="font-bold text-slate-900 flex items-center gap-1">4.9 <i class="ri-star-fill text-[#ca9e54] text-[10px]"></i></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-slate-500 text-[10px]">Fasilitas Luxe</span>
                    <span class="font-bold text-slate-900 flex items-center gap-1">4.8 <i class="ri-star-fill text-[#ca9e54] text-[10px]"></i></span>
                </div>
            </div>

            <!-- Search & Reviews List -->
            <div class="p-6 sm:p-8 overflow-y-auto space-y-6 flex-1">
                
                <!-- Live Search Bar -->
                <div class="relative">
                    <i class="ri-search-line absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                    <input type="text" id="review-search-input" onkeyup="filterGuestReviews()" placeholder="Cari ulasan tamu (misal: kolam, koki, kebersihan, sunset)..." class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs focus:outline-none focus:border-[#152c4e] transition-colors">
                </div>

                <!-- Reviews Feed Container -->
                <div class="space-y-4" id="reviews-feed-container">
                    <!-- Rendered via JS -->
                </div>
            </div>

            <!-- Modal Footer: Submit Review Action -->
            <div class="p-4 sm:p-5 bg-slate-50 border-t border-slate-200/80 flex items-center justify-between text-xs shrink-0">
                <span class="text-slate-500">Pernah menginap di sini? Berikan pengalaman Anda</span>
                <button onclick="alert('Formulir Ulasan Tamu: Kirimkan penilaian bintang dan ulasan Anda untuk Villa Azure!')" class="bg-[#152c4e] hover:bg-[#0f1d32] text-white font-bold px-4 py-2.5 rounded-xl transition-colors cursor-pointer flex items-center gap-1.5 shadow-md">
                    <i class="ri-edit-line"></i> Tulis Ulasan
                </button>
            </div>

        </div>
    </div>

    <!-- ULTRA-MINIMALIST FLOATING MOBILE BOOKING BAR (ALWAYS VISIBLE AT TOP Z-INDEX 95) -->
    <div id="mobile-sticky-booking-bar" class="fixed bottom-4 inset-x-3 sm:inset-x-6 z-[95] lg:hidden font-satoshi pointer-events-auto transition-all duration-300">
        <div class="bg-[#152c4e]/95 backdrop-blur-2xl text-white rounded-full p-2.5 pl-5 shadow-[0_12px_35px_rgba(0,0,0,0.3)] border border-white/15 flex items-center justify-between gap-3 max-w-lg mx-auto">
            
            <!-- Left Info: Minimalist Price & Rating -->
            <div class="flex items-center gap-2">
                <span class="font-serif-title font-bold text-lg sm:text-xl text-white">$450</span>
                <span class="text-[10px] text-white/60 font-light">/ malam</span>
                <span class="text-white/30 text-xs">•</span>
                <div class="flex items-center gap-1 text-[11px] text-[#e5c382] font-semibold">
                    <i class="ri-star-fill text-[11px]"></i> 4.95
                </div>
            </div>

            <!-- Right CTA Button: Minimalist Gold Button -->
            <button onclick="openPovModal()" class="bg-[#ca9e54] hover:bg-[#b88c43] text-slate-950 font-bold px-5 py-2.5 rounded-full text-xs transition-transform active:scale-95 cursor-pointer shadow-lg flex items-center gap-1.5 shrink-0">
                <span>Pesan Sekarang</span>
                <i class="ri-arrow-right-line text-sm"></i>
            </button>
        </div>
    </div>

@push('scripts')
<script>
    // Villa Gallery Dataset
    const villaGalleryPhotos = [
        { url: "https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1600&q=85", title: "Eksterior Utama Villa Azure" },
        { url: "https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=1600&q=85", title: "Infinity Pool Tepi Pantai 18M" },
        { url: "https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1600&q=85", title: "Kamar Tidur Utama King Suite" },
        { url: "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1600&q=85", title: "Gazebo Lounge Tropis" },
        { url: "https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1600&q=85", title: "Teras Sunset Malam Hari" },
        { url: "https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=85", title: "Kamar Mandi Marmer & Bathtub" },
        { url: "https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1600&q=85", title: "Area Taman Sunset & Pool" },
        { url: "https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1600&q=85", title: "Kamar Tidur Tamu VVIP" },
        { url: "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1600&q=85", title: "Bathtub Terbuka Pemandangan Laut" }
    ];

    let currentPhotoIndex = 0;

    function openLightbox(index = 0) {
        const modal = document.getElementById('gallery-lightbox-modal');
        if (!modal) return;
        currentPhotoIndex = index % villaGalleryPhotos.length;
        updateLightboxContent();
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
        }, 10);
        document.body.classList.add('overflow-hidden');
    }

    function closeLightbox() {
        const modal = document.getElementById('gallery-lightbox-modal');
        if (!modal) return;
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    function nextPhoto() {
        currentPhotoIndex = (currentPhotoIndex + 1) % villaGalleryPhotos.length;
        updateLightboxContent();
    }

    function prevPhoto() {
        currentPhotoIndex = (currentPhotoIndex - 1 + villaGalleryPhotos.length) % villaGalleryPhotos.length;
        updateLightboxContent();
    }

    function updateLightboxContent() {
        const photo = villaGalleryPhotos[currentPhotoIndex];
        const mainImg = document.getElementById('lightbox-main-img');
        const counterText = document.getElementById('lightbox-counter-text');
        const thumbContainer = document.getElementById('lightbox-thumbnails');

        if (mainImg) {
            mainImg.style.opacity = '0';
            setTimeout(() => {
                mainImg.src = photo.url;
                mainImg.alt = photo.title;
                mainImg.style.opacity = '1';
            }, 100);
        }

        if (counterText) counterText.innerText = `${currentPhotoIndex + 1} / ${villaGalleryPhotos.length}`;

        if (thumbContainer) {
            thumbContainer.innerHTML = villaGalleryPhotos.map((p, idx) => `
                <button onclick="currentPhotoIndex=${idx}; updateLightboxContent();" class="w-12 h-9 sm:w-16 sm:h-11 rounded-lg overflow-hidden border-2 transition-all duration-200 shrink-0 cursor-pointer ${idx === currentPhotoIndex ? 'border-[#ca9e54] scale-105 opacity-100 shadow-lg' : 'border-transparent opacity-40 hover:opacity-100'}">
                    <img src="${p.url}" alt="${p.title}" class="w-full h-full object-cover">
                </button>
            `).join('');
        }
    }

    document.addEventListener('keydown', (e) => {
        const modal = document.getElementById('gallery-lightbox-modal');
        if (modal && !modal.classList.contains('hidden')) {
            if (e.key === 'ArrowRight') nextPhoto();
            if (e.key === 'ArrowLeft') prevPhoto();
            if (e.key === 'Escape') closeLightbox();
        }
    });

    // Price Breakdown
    function calculateBookingTotal() {
        const checkinInput = document.getElementById('book-checkin');
        const checkoutInput = document.getElementById('book-checkout');
        const addonTransfer = document.getElementById('addon-transfer');
        const addonChef = document.getElementById('addon-chef');

        let nights = 3;
        if (checkinInput && checkoutInput && checkinInput.value && checkoutInput.value) {
            const date1 = new Date(checkinInput.value);
            const date2 = new Date(checkoutInput.value);
            const diffTime = Math.abs(date2 - date1);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            if (diffDays > 0) nights = diffDays;
        }

        const pricePerNight = 450;
        const subtotal = pricePerNight * nights;

        let addonsTotal = 0;
        if (addonTransfer && addonTransfer.checked) addonsTotal += 50;
        if (addonChef && addonChef.checked) addonsTotal += 120;

        const tax = Math.round((subtotal + addonsTotal) * 0.1);
        const grandTotal = subtotal + addonsTotal + tax;

        document.getElementById('summary-nights').innerText = nights;
        document.getElementById('summary-subtotal').innerText = '$' + subtotal.toLocaleString();
        document.getElementById('summary-addons').innerText = '$' + addonsTotal;
        document.getElementById('summary-tax').innerText = '$' + tax.toLocaleString();
        document.getElementById('summary-total').innerText = '$' + grandTotal.toLocaleString();
    }

    // Toggle Favorite Heart
    function toggleFav(btn) {
        const icon = document.getElementById('fav-icon');
        if (icon) {
            if (icon.classList.contains('ri-heart-line')) {
                icon.classList.remove('ri-heart-line');
                icon.classList.add('ri-heart-fill', 'text-red-500');
                btn.classList.add('border-red-200');
            } else {
                icon.classList.remove('ri-heart-fill', 'text-red-500');
                icon.classList.add('ri-heart-line');
                btn.classList.remove('border-red-200');
            }
        }
    }

    function shareVilla() {
        if (navigator.share) {
            navigator.share({ title: 'Villa Azure Ocean Sanctuary', url: window.location.href });
        } else {
            navigator.clipboard.writeText(window.location.href);
            alert('Tautan villa berhasil disalin ke clipboard!');
        }
    }

    // POV Booking Modal Handlers
    function openPovModal() {
        const modal = document.getElementById('pov-booking-modal');
        const box = document.getElementById('pov-modal-box');
        document.getElementById('pov-step-1').classList.remove('hidden');
        document.getElementById('pov-step-2').classList.add('hidden');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            box.classList.remove('scale-95');
        }, 10);
    }

    function closePovModal() {
        const modal = document.getElementById('pov-booking-modal');
        const box = document.getElementById('pov-modal-box');
        modal.classList.add('opacity-0');
        box.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function goToPovStep2() {
        const guestName = document.getElementById('pov-name').value || 'Budi Santoso';
        document.getElementById('res-name').innerText = guestName;
        document.getElementById('pov-step-1').classList.add('hidden');
        document.getElementById('pov-step-2').classList.remove('hidden');
    }

    function simulatedDownloadPdf() {
        alert('Simulasi Unduh: E-Voucher Reservasi Villa Azure PDF telah diunduh!');
    }

    // All Guest Reviews Dataset & Handlers
    const guestReviewsData = [
        { name: "Sarah Jenkins", country: "Australia 🇦🇺", date: "Juli 2026", rating: 5, avatar: "https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=75", comment: "Pengalaman paling berkesan! Pemandangan sunset dari infinity pool sangat menakjubkan, dan layanan koki pribadinya luar biasa lezat." },
        { name: "Michael Ross", country: "Singapura 🇸🇬", date: "Juni 2026", rating: 5, avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=75", comment: "Sangat direkomendasikan untuk staycation keluarga. Anak-anak sangat menyukai kolam renangnya dan fasilitasnya amat lengkap." },
        { name: "Jessica Taylor", country: "Inggris 🇬🇧", date: "Mei 2026", rating: 5, avatar: "https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=100&q=75", comment: "Butler 24 jam sangat responsif dan membantu semua kebutuhan acara ulang tahun kami. Kebersihan kamar 10/10." },
        { name: "Kenji Sato", country: "Jepang 🇯🇵", date: "April 2026", rating: 5, avatar: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=100&q=75", comment: "Lokasinya sangat strategis di Seminyak, tenang dan dekat ke pantai. Layanan penjemputan Alphard sangat nyaman." },
        { name: "Amanda & David", country: "Amerika Serikat 🇺🇸", date: "Maret 2026", rating: 5, avatar: "https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=100&q=75", comment: "Tempat favorit kami di Bali untuk honeymoon! Kasur sangat nyaman dan bathtub marmernya sangat mewah." },
        { name: "Budi Santoso", country: "Indonesia 🇮🇩", date: "Februari 2026", rating: 5, avatar: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=100&q=75", comment: "Villanya sangat luas dan bersih. Makanan koki in-villa bintang lima!" }
    ];

    function openReviewsModal() {
        const modal = document.getElementById('all-reviews-modal');
        const box = document.getElementById('reviews-modal-box');
        if (!modal) return;
        renderReviewsFeed(guestReviewsData);
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            box.classList.remove('scale-95');
        }, 10);
    }

    function closeReviewsModal() {
        const modal = document.getElementById('all-reviews-modal');
        const box = document.getElementById('reviews-modal-box');
        if (!modal) return;
        modal.classList.add('opacity-0');
        box.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function filterGuestReviews() {
        const query = (document.getElementById('review-search-input')?.value || '').toLowerCase();
        const filtered = guestReviewsData.filter(r => 
            r.name.toLowerCase().includes(query) || 
            r.comment.toLowerCase().includes(query) || 
            r.country.toLowerCase().includes(query)
        );
        renderReviewsFeed(filtered);
    }

    function renderReviewsFeed(list) {
        const container = document.getElementById('reviews-feed-container');
        if (!container) return;
        if (list.length === 0) {
            container.innerHTML = `<div class="text-center py-8 text-slate-400 text-xs">Tidak ada ulasan yang cocok dengan pencarian Anda.</div>`;
            return;
        }
        container.innerHTML = list.map(r => `
            <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="${r.avatar}" alt="${r.name}" class="w-10 h-10 rounded-full object-cover shadow-sm">
                        <div>
                            <div class="flex items-center gap-2">
                                <h5 class="text-xs font-bold text-slate-900">${r.name}</h5>
                                <span class="bg-emerald-50 text-emerald-600 text-[9px] font-bold px-2 py-0.5 rounded-full">Tamu Terverifikasi</span>
                            </div>
                            <span class="text-[10px] text-slate-400">${r.country} • ${r.date}</span>
                        </div>
                    </div>
                    <div class="flex text-[#ca9e54] text-xs">
                        <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                    </div>
                </div>
                <p class="text-xs text-slate-600 font-light leading-relaxed">
                    "${r.comment}"
                </p>
            </div>
        `).join('');
    }
</script>
@endpush

<!-- FLOATING MOBILE STICKY BOOKING BAR (Khusus Tampilan Smartphone / Tablet < 1024px) -->
<div class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-xl border-t border-slate-200/80 p-3.5 px-4 sm:px-6 flex items-center justify-between lg:hidden shadow-[0_-8px_30px_rgba(0,0,0,0.12)]">
    <div>
        <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block">Mulai dari</span>
        <div class="flex items-baseline gap-1">
            <span class="text-xl font-extrabold text-[#152c4e] font-serif-title">$450</span>
            <span class="text-xs font-light text-slate-500">/ malam</span>
        </div>
    </div>
    <a href="#booking-form-box" class="bg-[#ca9e54] hover:bg-[#b88c43] text-white font-bold text-xs uppercase tracking-wider px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition-all active:scale-95 flex items-center gap-1.5 gold-glow">
        <span>Pesan Sekarang</span>
        <i class="ri-arrow-right-line text-sm"></i>
    </a>
</div>
@endsection
