@extends('layouts.frontend.main')

@section('content')
    <!-- HERO HEADER CATALOG -->
    <section class="relative pt-32 pb-16 px-4 sm:px-6 md:px-12 bg-[#152c4e] text-white font-satoshi overflow-hidden">
        <div class="absolute inset-0 opacity-20 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=80" alt="Villa Background" class="w-full h-full object-cover">
        </div>
        <div class="max-w-7xl mx-auto text-center relative z-10 space-y-4">
            <span class="text-[10px] sm:text-xs font-bold tracking-[0.25em] text-[#e5c382] uppercase block">Eksplorasi Properti</span>
            <h1 class="font-serif-title text-3xl sm:text-5xl font-normal">Katalog Villa Mewah di Bali</h1>
            <p class="text-xs sm:text-base text-white/80 font-light max-w-2xl mx-auto">
                Temukan villa private sanctuary terbaik di Seminyak, Ubud, Uluwatu, Canggu, dan Nusa Dua yang siap memberikan pengalaman menginap tak terlupakan.
            </p>
        </div>
    </section>

    <!-- MAIN CATALOG & FILTER CONTENT -->
    <section class="py-10 sm:py-14 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi">
        
        <!-- Filter & Search Bar Box -->
        <div class="bg-white rounded-3xl p-5 sm:p-6 md:p-8 shadow-xl border border-slate-100 relative z-20 mb-10 sm:mb-12">
            <form action="{{ route('villa.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 sm:gap-4 items-center">
                <!-- Location Filter -->
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/60">
                    <label class="block text-[9px] font-bold text-slate-400 uppercase mb-1">Lokasi Daerah</label>
                    <select class="w-full bg-transparent text-xs font-bold text-slate-900 focus:outline-none cursor-pointer">
                        <option value="">Semua Lokasi</option>
                        <option value="seminyak">Seminyak</option>
                        <option value="ubud">Ubud</option>
                        <option value="uluwatu">Uluwatu</option>
                        <option value="canggu">Canggu</option>
                        <option value="nusa-dua">Nusa Dua</option>
                    </select>
                </div>

                <!-- Tipe Villa -->
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/60">
                    <label class="block text-[9px] font-bold text-slate-400 uppercase mb-1">Tipe Properti</label>
                    <select class="w-full bg-transparent text-xs font-bold text-slate-900 focus:outline-none cursor-pointer">
                        <option value="">Semua Tipe</option>
                        <option value="beachfront">Beachfront Villa</option>
                        <option value="cliffside">Cliffside Ocean View</option>
                        <option value="jungle">Jungle Sanctuary</option>
                        <option value="ricefield">Ricefield View</option>
                    </select>
                </div>

                <!-- Kamar Tidur -->
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/60">
                    <label class="block text-[9px] font-bold text-slate-400 uppercase mb-1">Jumlah Kamar</label>
                    <select class="w-full bg-transparent text-xs font-bold text-slate-900 focus:outline-none cursor-pointer">
                        <option value="">Semua Kamar</option>
                        <option value="2">2 - 3 Kamar</option>
                        <option value="4">4 - 5 Kamar</option>
                        <option value="6">6+ Kamar</option>
                    </select>
                </div>

                <!-- Range Harga -->
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/60">
                    <label class="block text-[9px] font-bold text-slate-400 uppercase mb-1">Rentang Harga</label>
                    <select class="w-full bg-transparent text-xs font-bold text-slate-900 focus:outline-none cursor-pointer">
                        <option value="">Semua Harga</option>
                        <option value="low">< $350 / malam</option>
                        <option value="mid">$350 - $600 / malam</option>
                        <option value="high">$600+ / malam</option>
                    </select>
                </div>

                <!-- Submit & Reset Filter Buttons -->
                <div class="flex items-center gap-2">
                    <button type="submit" class="flex-1 bg-[#ca9e54] hover:bg-[#b88c43] text-white font-semibold py-3.5 px-4 rounded-2xl shadow-md transition duration-300 flex items-center justify-center gap-1.5 text-xs uppercase tracking-wider">
                        <i class="ri-search-line text-sm"></i>
                        <span>Filter</span>
                    </button>
                    <a href="{{ route('villa.index') }}" class="p-3.5 bg-slate-100 text-slate-600 rounded-2xl hover:bg-slate-200 transition-colors border border-slate-200 text-xs font-semibold flex items-center justify-center" title="Reset Filter" aria-label="Reset Filter">
                        <i class="ri-[#152c4e] ri-refresh-line text-base"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Catalog Villa Grid Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
            <div>
                <h2 class="font-serif-title text-2xl sm:text-3xl font-bold text-slate-900">Villa Mewah Terverifikasi</h2>
                <p class="text-xs text-slate-500 font-light mt-1">Menampilkan 9 villa terbaik di Bali dengan jaminan garansi harga resmi</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-400 font-medium">Urutkan:</span>
                <select class="bg-white border border-slate-200 text-xs font-semibold text-slate-800 rounded-full px-4 py-2 focus:outline-none cursor-pointer">
                    <option>Paling Populer</option>
                    <option>Harga: Rendah ke Tinggi</option>
                    <option>Harga: Tinggi ke Rendah</option>
                    <option>Rating Tertinggi</option>
                </select>
            </div>
        </div>

        <!-- Villa Grid (9 Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-12">
            <!-- Villa Card 1 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-60 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=600&q=75" alt="Villa Azure Paradise" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4 flex gap-2">
                        <span class="bg-[#ca9e54] text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-md">-30% OFF</span>
                        <span class="bg-white/90 backdrop-blur-md text-slate-800 text-[10px] font-semibold px-2.5 py-1 rounded-full shadow-md">Beachfront</span>
                    </div>
                    <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-lg"></i>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <a href="{{ route('villa.show', 1) }}" class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">Villa Azure Paradise</a>
                            <div class="flex items-center gap-1 text-xs font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>4.9</span> <span class="text-[10px] text-slate-400">(127)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i> Seminyak, Bali
                        </p>
                        <div class="flex items-center justify-between text-xs text-slate-600 pt-3 border-t border-slate-100 mb-5 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-[#ca9e54]"></i> 5 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-[#ca9e54]"></i> 4 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-[#ca9e54]"></i> 10 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-xs text-slate-400 line-through mr-1">$650</span>
                            <span class="text-2xl font-bold text-[#152c4e]">$450</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="{{ route('villa.show', 1) }}" class="bg-[#152c4e] hover:bg-[#ca9e54] text-white text-xs font-bold px-4 py-2 rounded-full transition-colors">Pesan</a>
                    </div>
                </div>
            </div>

            <!-- Villa Card 2 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-60 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=600&q=75" alt="Villa Ocean Breeze" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4">
                        <span class="bg-white/90 backdrop-blur-md text-slate-800 text-[10px] font-semibold px-2.5 py-1 rounded-full shadow-md">Cliffside View</span>
                    </div>
                    <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-lg"></i>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">Villa Ocean Breeze</h3>
                            <div class="flex items-center gap-1 text-xs font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>5.0</span> <span class="text-[10px] text-slate-400">(89)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i> Uluwatu, Bali
                        </p>
                        <div class="flex items-center justify-between text-xs text-slate-600 pt-3 border-t border-slate-100 mb-5 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-[#ca9e54]"></i> 6 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-[#ca9e54]"></i> 5 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-[#ca9e54]"></i> 12 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-2xl font-bold text-[#152c4e]">$680</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="#booking" class="bg-[#152c4e] hover:bg-[#0f1e36] text-white text-xs font-bold px-4 py-2 rounded-full transition-colors">Pesan</a>
                    </div>
                </div>
            </div>

            <!-- Villa Card 3 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-60 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=600&q=75" alt="Villa Tropical Serenity" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4">
                        <span class="bg-[#ca9e54] text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-md">-28% OFF</span>
                    </div>
                    <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-lg"></i>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">Villa Tropical Serenity</h3>
                            <div class="flex items-center gap-1 text-xs font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>4.8</span> <span class="text-[10px] text-slate-400">(203)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i> Canggu, Bali
                        </p>
                        <div class="flex items-center justify-between text-xs text-slate-600 pt-3 border-t border-slate-100 mb-5 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-[#ca9e54]"></i> 4 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-[#ca9e54]"></i> 3 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-[#ca9e54]"></i> 8 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-xs text-slate-400 line-through mr-1">$450</span>
                            <span class="text-2xl font-bold text-[#152c4e]">$320</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="#booking" class="bg-[#152c4e] hover:bg-[#0f1e36] text-white text-xs font-bold px-4 py-2 rounded-full transition-colors">Pesan</a>
                    </div>
                </div>
            </div>

            <!-- Villa Card 4 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-60 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=600&q=75" alt="Villa Sunset Cliff" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-lg"></i>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">Villa Sunset Cliff</h3>
                            <div class="flex items-center gap-1 text-xs font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>4.9</span> <span class="text-[10px] text-slate-400">(156)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i> Nusa Dua, Bali
                        </p>
                        <div class="flex items-center justify-between text-xs text-slate-600 pt-3 border-t border-slate-100 mb-5 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-[#ca9e54]"></i> 5 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-[#ca9e54]"></i> 4 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-[#ca9e54]"></i> 10 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-2xl font-bold text-[#152c4e]">$550</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="#booking" class="bg-[#152c4e] hover:bg-[#0f1e36] text-white text-xs font-bold px-4 py-2 rounded-full transition-colors">Pesan</a>
                    </div>
                </div>
            </div>

            <!-- Villa Card 5 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-60 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=600&q=75" alt="Villa Emerald Hills" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4">
                        <span class="bg-[#ca9e54] text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-md">-30% OFF</span>
                    </div>
                    <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-lg"></i>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">Villa Emerald Hills</h3>
                            <div class="flex items-center gap-1 text-xs font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>4.7</span> <span class="text-[10px] text-slate-400">(94)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i> Ubud, Bali
                        </p>
                        <div class="flex items-center justify-between text-xs text-slate-600 pt-3 border-t border-slate-100 mb-5 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-[#ca9e54]"></i> 3 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-[#ca9e54]"></i> 3 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-[#ca9e54]"></i> 6 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-xs text-slate-400 line-through mr-1">$400</span>
                            <span class="text-2xl font-bold text-[#152c4e]">$280</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="#booking" class="bg-[#152c4e] hover:bg-[#0f1e36] text-white text-xs font-bold px-4 py-2 rounded-full transition-colors">Pesan</a>
                    </div>
                </div>
            </div>

            <!-- Villa Card 6 -->
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-60 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=600&q=75" alt="Villa Coastal Dream" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 backdrop-blur-md text-slate-600 hover:text-red-500 flex items-center justify-center transition-colors shadow-md">
                        <i class="ri-heart-line text-lg"></i>
                    </button>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors">Villa Coastal Dream</h3>
                            <div class="flex items-center gap-1 text-xs font-semibold text-slate-700">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>4.8</span> <span class="text-[10px] text-slate-400">(178)</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i> Jimbaran, Bali
                        </p>
                        <div class="flex items-center justify-between text-xs text-slate-600 pt-3 border-t border-slate-100 mb-5 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-[#ca9e54]"></i> 4 Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-showers-line text-[#ca9e54]"></i> 4 Mandi</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-[#ca9e54]"></i> 8 Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-2xl font-bold text-[#152c4e]">$420</span>
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="#booking" class="bg-[#152c4e] hover:bg-[#0f1e36] text-white text-xs font-bold px-4 py-2 rounded-full transition-colors">Pesan</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load More Pagination -->
        <div class="text-center">
            <button class="bg-white border border-slate-200 hover:border-[#152c4e] text-slate-800 font-semibold px-8 py-3.5 rounded-full shadow-sm hover:shadow-md transition duration-300 text-xs uppercase tracking-wider">
                Muat Lebih Banyak Villa
            </button>
        </div>

    </section>
@endsection
