@extends('layouts.frontend.main')

@section('content')
    <!-- HERO HEADER LAYANAN -->
    <section class="relative pt-32 pb-20 px-4 sm:px-6 md:px-12 bg-[#152c4e] text-white font-satoshi overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-30 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=75" alt="Layanan Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-[#152c4e]/90 via-[#152c4e]/75 to-[#152c4e]"></div>
        </div>
        <div class="max-w-7xl mx-auto text-center relative z-10 space-y-4">
            <span class="text-[10px] sm:text-xs font-bold tracking-[0.25em] text-[#e5c382] uppercase block">Layanan Eksklusif</span>
            <h1 class="font-serif-title text-3xl sm:text-5xl font-normal">Concierge & Layanan Villa VIP</h1>
            <p class="text-xs sm:text-base text-white/80 font-light max-w-2xl mx-auto leading-relaxed">
                Nikmati kenyamanan tanpa batas dari penjemputan bandara luxury, koki pribadi di villa, spa aromaterapi, hingga penyewaan yacht & mobil mewah.
            </p>
        </div>
    </section>

    <!-- SERVICES LIST SECTION -->
    <section class="py-16 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Service 1 -->
            <div class="p-8 rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition duration-300 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-[#152c4e] text-white flex items-center justify-center text-2xl">
                    <i class="ri-car-line"></i>
                </div>
                <h3 class="font-serif-title text-2xl font-bold text-slate-900">Transfer Bandara VIP</h3>
                <p class="text-xs text-slate-600 font-light leading-relaxed">
                    Armada mobil mewah Alphard / SUV dengan pengemudi profesional yang siap menjemput Anda langsung di pintu keluar Bandara Ngurah Rai Bali.
                </p>
            </div>

            <!-- Service 2 -->
            <div class="p-8 rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition duration-300 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-[#ca9e54] text-white flex items-center justify-center text-2xl">
                    <i class="ri-restaurant-line"></i>
                </div>
                <h3 class="font-serif-title text-2xl font-bold text-slate-900">Koki Pribadi (Private Chef)</h3>
                <p class="text-xs text-slate-600 font-light leading-relaxed">
                    Sajian kuliner privat di villa oleh koki berpengalaman. Mulai dari Floating Breakfast instagenic, BBQ seafood beachside, hingga fine dining romantic dinner.
                </p>
            </div>

            <!-- Service 3 -->
            <div class="p-8 rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition duration-300 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-teal-600 text-white flex items-center justify-center text-2xl">
                    <i class="ri-heart-pulse-line"></i>
                </div>
                <h3 class="font-serif-title text-2xl font-bold text-slate-900">In-Villa Spa & Massage</h3>
                <p class="text-xs text-slate-600 font-light leading-relaxed">
                    Relaksasi pijat tradisional Balinese massage & perawatan spa aromaterapi oleh terapis bersertifikat tanpa perlu meninggalkan kenyamanan villa Anda.
                </p>
            </div>

            <!-- Service 4 -->
            <div class="p-8 rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition duration-300 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-amber-600 text-white flex items-center justify-center text-2xl">
                    <i class="ri-compass-line"></i>
                </div>
                <h3 class="font-serif-title text-2xl font-bold text-slate-900">Tour Guide & Pemandu Wisata</h3>
                <p class="text-xs text-slate-600 font-light leading-relaxed">
                    Pemandu wisata berpengalaman yang paham lokasi rahasia (*hidden gems*) terbaik di Bali untuk foto aesthetic dan pengalaman budaya autentik.
                </p>
            </div>

            <!-- Service 5 -->
            <div class="p-8 rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition duration-300 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-[#152c4e] text-white flex items-center justify-center text-2xl">
                    <i class="ri-sailboat-line"></i>
                </div>
                <h3 class="font-serif-title text-2xl font-bold text-slate-900">Sewa Yacht & Speedsboat</h3>
                <p class="text-xs text-slate-600 font-light leading-relaxed">
                    Perjalanan laut eksklusif ke Nusa Penida, Nusa Lembongan, atau Gili Trawangan dengan yacht mewah pribadi dan fasilitas snorkeling terlengkap.
                </p>
            </div>

            <!-- Service 6 -->
            <div class="p-8 rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition duration-300 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-[#ca9e54] text-white flex items-center justify-center text-2xl">
                    <i class="ri-shield-star-line"></i>
                </div>
                <h3 class="font-serif-title text-2xl font-bold text-slate-900">Butler & Concierge 24/7</h3>
                <p class="text-xs text-slate-600 font-light leading-relaxed">
                    Pelayan pribadi (*Butler*) yang siap membantu segala kebutuhan menginap Anda 24 jam nonstop dari pemesanan tiket hingga perawatan khusus.
                </p>
            </div>

        </div>
    </section>
@endsection
