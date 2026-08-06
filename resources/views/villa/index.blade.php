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

        <!-- Villa Grid (Dynamic) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-12">
            @if(isset($properties) && $properties->count() > 0)
                @foreach($properties as $villa)
                    <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                        <div class="relative h-60 overflow-hidden bg-slate-100">
                            <img src="{{ $villa->main_image ? asset('storage/' . $villa->main_image) : 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=600&q=75' }}" alt="{{ $villa->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute top-4 left-4 flex gap-2">
                                <span class="bg-[#ca9e54] text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-md uppercase">{{ $villa->code ?? 'PLM' }}</span>
                                <span class="bg-white/90 backdrop-blur-md text-slate-800 text-[10px] font-semibold px-2.5 py-1 rounded-full shadow-md">{{ $villa->type ?? 'Villa' }}</span>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <a href="{{ route('villa.show', $villa->slug) }}" class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors line-clamp-1">{{ $villa->name }}</a>
                                    <div class="flex items-center gap-1 text-xs font-semibold text-slate-700 shrink-0 ml-2">
                                        <i class="ri-star-fill text-[#ca9e54]"></i>
                                        <span>{{ number_format($villa->rating ?? 4.9, 1) }}</span>
                                    </div>
                                </div>
                                <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                                    <i class="ri-map-pin-line text-slate-400 text-sm"></i> {{ $villa->city ?? 'Seminyak' }}, {{ $villa->province ?? 'Bali' }}
                                </p>
                                <div class="flex items-center justify-between text-xs text-slate-600 pt-3 border-t border-slate-100 mb-5 font-medium">
                                    <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-[#ca9e54]"></i> {{ $villa->bedrooms }} Kamar</span>
                                    <span class="flex items-center gap-1"><i class="ri-group-line text-[#ca9e54]"></i> {{ $villa->capacity }} Tamu</span>
                                </div>
                            </div>
                            <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                                <div>
                                    <x-ui.price :value="$villa->price" class="text-xl font-bold text-[#152c4e]" />
                                    <span class="text-xs font-normal text-slate-500">/ malam</span>
                                </div>
                                <a href="{{ route('villa.show', $villa->slug) }}" class="bg-[#152c4e] hover:bg-[#ca9e54] text-white text-xs font-bold px-4 py-2 rounded-full transition-colors">Pesan</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Load More Pagination -->
        <div class="text-center">
            <button class="bg-white border border-slate-200 hover:border-[#152c4e] text-slate-800 font-semibold px-8 py-3.5 rounded-full shadow-sm hover:shadow-md transition duration-300 text-xs uppercase tracking-wider">
                Muat Lebih Banyak Villa
            </button>
        </div>

    </section>
@endsection
