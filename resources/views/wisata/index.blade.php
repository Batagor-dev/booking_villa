@extends('layouts.frontend.main')

@section('content')
    <!-- HERO HEADER WISATA BALI -->
    <section class="relative pt-32 pb-20 px-4 sm:px-6 md:px-12 bg-gradient-to-r from-[#152c4e] via-[#1e3a66] to-[#0f1e36] text-white font-satoshi overflow-hidden">
        <div class="absolute inset-0 opacity-25 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1600&q=80" alt="Bali Tourist Spot" class="w-full h-full object-cover">
        </div>
        <div class="max-w-7xl mx-auto text-center relative z-10 space-y-4">
            <span class="text-[10px] sm:text-xs font-bold tracking-[0.25em] text-[#e5c382] uppercase block">
                Panduan Liburan Resmi • Rekomendasi Turis
            </span>
            <h1 class="font-serif-title text-3xl sm:text-5xl md:text-6xl font-normal leading-tight">
                Destinasi Wisata <br class="hidden sm:inline"/>
                <span class="italic font-normal gold-gradient-text">Paling Favorit di Bali</span>
            </h1>
            <p class="text-xs sm:text-base text-slate-200 font-light max-w-2xl mx-auto leading-relaxed">
                Jelajahi keindahan alam, budaya autentik, klub pantai berkelas, dan spot sunset terbaik yang paling direkomendasikan untuk liburan Anda.
            </p>
        </div>
    </section>

    <!-- SECTION: KAWASAN WISATA BALI -->
    <section class="py-14 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi">
        
        <!-- Regional Filter Tabs -->
        <div class="flex items-center justify-center gap-2 flex-wrap mb-12">
            <button class="bg-[#152c4e] text-white text-xs font-bold px-5 py-2.5 rounded-full shadow-md">Semua Daerah</button>
            <button class="bg-white border border-slate-200 hover:border-[#ca9e54] text-slate-700 text-xs font-semibold px-5 py-2.5 rounded-full transition duration-300">Seminyak</button>
            <button class="bg-white border border-slate-200 hover:border-[#ca9e54] text-slate-700 text-xs font-semibold px-5 py-2.5 rounded-full transition duration-300">Ubud</button>
            <button class="bg-white border border-slate-200 hover:border-[#ca9e54] text-slate-700 text-xs font-semibold px-5 py-2.5 rounded-full transition duration-300">Uluwatu</button>
            <button class="bg-white border border-slate-200 hover:border-[#ca9e54] text-slate-700 text-xs font-semibold px-5 py-2.5 rounded-full transition duration-300">Canggu</button>
            <button class="bg-white border border-slate-200 hover:border-[#ca9e54] text-slate-700 text-xs font-semibold px-5 py-2.5 rounded-full transition duration-300">Nusa Dua</button>
        </div>

        <!-- Tourist Spot Cards List (6 Highlights) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            
            <!-- Spot 1: Seminyak Beach Club & Sunset -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-64 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=600&q=75" alt="Seminyak Beach" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4">
                        <span class="bg-[#ca9e54] text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md">Seminyak • Sunset</span>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="font-serif-title text-2xl font-bold text-slate-900">Pantai Seminyak & Beach Club</h3>
                            <span class="text-xs font-bold text-[#ca9e54] flex items-center gap-1"><i class="ri-star-fill"></i> 4.9</span>
                        </div>
                        <p class="text-xs text-slate-500 mb-3 flex items-center gap-1">
                            <i class="ri-map-pin-line text-slate-400"></i> Badung, Bali
                        </p>
                        <p class="text-xs text-slate-600 font-light leading-relaxed">
                            Kawasan ikonik yang terkenal dengan pemandangan matahari terbenam spektakuler, bar pantai warna-warni (Potato Head, Ku De Ta), serta deretan restoran mewah berstandar internasional.
                        </p>
                        
                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <span class="text-[11px] font-bold text-[#152c4e] block mb-1.5">Atraksi Utama:</span>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Potato Head</span>
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Live Music Beach</span>
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Boutique Shopping</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">Rekomendasi Villa Terdekat:</span>
                        <a href="{{ route('villa.index') }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] flex items-center gap-1">
                            Villa Azure <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Spot 2: Ubud Rice Terrace & Monkey Forest -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-64 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=600&q=75" alt="Ubud" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4">
                        <span class="bg-emerald-600 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md">Ubud • Alam & Seni</span>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="font-serif-title text-2xl font-bold text-slate-900">Tegallalang & Monkey Forest</h3>
                            <span class="text-xs font-bold text-[#ca9e54] flex items-center gap-1"><i class="ri-star-fill"></i> 5.0</span>
                        </div>
                        <p class="text-xs text-slate-500 mb-3 flex items-center gap-1">
                            <i class="ri-map-pin-line text-slate-400"></i> Gianyar, Bali
                        </p>
                        <p class="text-xs text-slate-600 font-light leading-relaxed">
                            Pusat ketenangan spiritual dan seni autentik Bali. Nikmati hamparan sawah berundak Tegallalang, hutan suci Monkey Forest, museum seni, serta resort spa tropis di tengah keheningan alam.
                        </p>

                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <span class="text-[11px] font-bold text-[#152c4e] block mb-1.5">Atraksi Utama:</span>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Sacred Monkey Forest</span>
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Sawah Terasering</span>
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Yoga Retreat</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">Rekomendasi Villa Terdekat:</span>
                        <a href="{{ route('villa.index') }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] flex items-center gap-1">
                            Villa Emerald <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Spot 3: Uluwatu Temple & Kecak Dance -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-64 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=600&q=75" alt="Uluwatu Temple" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4">
                        <span class="bg-[#152c4e] text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md">Uluwatu • Budaya & Tebing</span>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="font-serif-title text-2xl font-bold text-slate-900">Pura Uluwatu & Tari Kecak</h3>
                            <span class="text-xs font-bold text-[#ca9e54] flex items-center gap-1"><i class="ri-star-fill"></i> 4.9</span>
                        </div>
                        <p class="text-xs text-slate-500 mb-3 flex items-center gap-1">
                            <i class="ri-map-pin-line text-slate-400"></i> Kuta Selatan, Bali
                        </p>
                        <p class="text-xs text-slate-600 font-light leading-relaxed">
                            Pura yang berdiri di atas tebing karang setinggi 70 meter menghadap Samudra Hindia. Menyuguhkan pertunjukan Tari Kecak magis saat sunset dan ombak kelas dunia bagi para peselancar.
                        </p>

                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <span class="text-[11px] font-bold text-[#152c4e] block mb-1.5">Atraksi Utama:</span>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Tari Kecak Sunset</span>
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Suluban Beach</span>
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Omnia Cliff Club</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">Rekomendasi Villa Terdekat:</span>
                        <a href="{{ route('villa.index') }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] flex items-center gap-1">
                            Villa Ocean Breeze <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Spot 4: Canggu Eco Beach & Surfing -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-64 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?auto=format&fit=crop&w=600&q=75" alt="Canggu Beach" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4">
                        <span class="bg-amber-600 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md">Canggu • Trendy Cafe</span>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="font-serif-title text-2xl font-bold text-slate-900">Pantai Batu Bolong & Echo</h3>
                            <span class="text-xs font-bold text-[#ca9e54] flex items-center gap-1"><i class="ri-star-fill"></i> 4.8</span>
                        </div>
                        <p class="text-xs text-slate-500 mb-3 flex items-center gap-1">
                            <i class="ri-map-pin-line text-slate-400"></i> Canggu, Bali
                        </p>
                        <p class="text-xs text-slate-600 font-light leading-relaxed">
                            Kawasan paling trendi di Bali bagi para pelancong muda, digital nomad, dan pencinta selancar. Penuh dengan kafe organik estetik, studio yoga, dan pasar kerajinan tangan lokal.
                        </p>

                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <span class="text-[11px] font-bold text-[#152c4e] block mb-1.5">Atraksi Utama:</span>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">La Brisa Beach Club</span>
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Batu Bolong Surf</span>
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Organic Cafes</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">Rekomendasi Villa Terdekat:</span>
                        <a href="{{ route('villa.index') }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] flex items-center gap-1">
                            Villa Serenity <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Spot 5: Nusa Dua Waterblow & White Sand -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-64 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=75" alt="Nusa Dua Waterblow" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4">
                        <span class="bg-teal-600 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md">Nusa Dua • Pantai & Waterblow</span>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="font-serif-title text-2xl font-bold text-slate-900">Nusa Dua Waterblow</h3>
                            <span class="text-xs font-bold text-[#ca9e54] flex items-center gap-1"><i class="ri-star-fill"></i> 4.9</span>
                        </div>
                        <p class="text-xs text-slate-500 mb-3 flex items-center gap-1">
                            <i class="ri-map-pin-line text-slate-400"></i> Nusa Dua, Bali
                        </p>
                        <p class="text-xs text-slate-600 font-light leading-relaxed">
                            Kawasan resort bintang 5 eksklusif dengan pantai pasir putih paling tenang di Bali. Terkenal dengan tebing Waterblow tempat gumpalan ombak samudra membumbung tinggi secara dramatis.
                        </p>

                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <span class="text-[11px] font-bold text-[#152c4e] block mb-1.5">Atraksi Utama:</span>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Waterblow Cliff</span>
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Water Sports Benoa</span>
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Pasir Putih Mengiat</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">Rekomendasi Villa Terdekat:</span>
                        <a href="{{ route('villa.index') }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] flex items-center gap-1">
                            Villa Sunset Cliff <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Spot 6: Jimbaran Seafood & Sunset Bay -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-64 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=600&q=75" alt="Jimbaran Bay" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4">
                        <span class="bg-rose-600 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md">Jimbaran • Kuliner Seafood</span>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="font-serif-title text-2xl font-bold text-slate-900">Teluk Jimbaran Seafood</h3>
                            <span class="text-xs font-bold text-[#ca9e54] flex items-center gap-1"><i class="ri-star-fill"></i> 4.8</span>
                        </div>
                        <p class="text-xs text-slate-500 mb-3 flex items-center gap-1">
                            <i class="ri-map-pin-line text-slate-400"></i> Jimbaran, Bali
                        </p>
                        <p class="text-xs text-slate-600 font-light leading-relaxed">
                            Pengalaman makan malam makan laut romantis langsung di atas pasir pantai dengan lilin dan alunan musik tradisional. Garansi kesegaran ikan tangkapan nelayan lokal harian.
                        </p>

                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <span class="text-[11px] font-bold text-[#152c4e] block mb-1.5">Atraksi Utama:</span>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Seafood Candlelight Dinner</span>
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Pantai Muaya Sunset</span>
                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">Pasar Ikan Kedonganan</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">Rekomendasi Villa Terdekat:</span>
                        <a href="{{ route('villa.index') }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] flex items-center gap-1">
                            Villa Coastal Dream <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Travel Tips Banner -->
        <div class="bg-[#152c4e] text-white rounded-3xl p-8 sm:p-12 shadow-xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="space-y-4 max-w-xl">
                <span class="text-[10px] font-bold text-[#e5c382] uppercase tracking-widest block">Tips Perjalanan Bali</span>
                <h3 class="font-serif-title text-3xl font-bold">Butuh Rekomendasi Khusus dari Concierge Asli Bali?</h3>
                <p class="text-white/80 font-light text-xs sm:text-sm leading-relaxed">
                    Tim Concierge Palma siap menyusunkan jadwal liburan (*itinerary*) harian gratis sesuai minat keluarga, hobi selancar, honeymoon romantis, atau wisata kuliner Anda.
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('layanan.index') }}" class="bg-[#ca9e54] hover:bg-[#b88c43] text-white font-bold px-8 py-4 rounded-full shadow-lg transition duration-300 text-xs uppercase tracking-wider block text-center">
                    Konsultasi Concierge Gratis
                </a>
            </div>
        </div>

    </section>
@endsection
