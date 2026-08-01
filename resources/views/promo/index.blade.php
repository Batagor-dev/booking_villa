@extends('layouts.frontend.main')

@section('content')
    <!-- HERO HEADER PROMO -->
    <section class="relative pt-32 pb-24 px-4 sm:px-6 md:px-12 bg-[#152c4e] text-white font-satoshi overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-40 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=80" alt="Promo Hero" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-[#152c4e]/90 via-[#152c4e]/75 to-[#152c4e]"></div>
        </div>

        <div class="max-w-7xl mx-auto text-center relative z-10 space-y-4 sm:space-y-6">
            <span class="text-[10px] sm:text-xs font-bold tracking-[0.25em] text-[#e5c382] uppercase block">
                Penawaran Eksklusif Terbatas
            </span>

            <h1 class="font-serif-title text-3xl sm:text-5xl md:text-6xl font-normal leading-tight">
                Hak Istimewa & <br class="hidden sm:inline"/>
                <span class="italic font-normal gold-gradient-text">Promo Villa Mewah Bali</span>
            </h1>

            <p class="text-xs sm:text-base text-slate-200 font-light max-w-2xl mx-auto leading-relaxed px-2">
                Nikmati penawaran khusus reservasi villa bintang 5 dengan potongan harga spesial, voucher promo instan, dan hak istimewa gratis layanan VIP.
            </p>
        </div>
    </section>

    <!-- PROMO CARDS SECTION -->
    <section class="py-14 sm:py-20 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi">
        
        <!-- Top Main Banners Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            
            <!-- Main Promo 1: Flash Sale Weekend Escape -->
            <div class="bg-gradient-to-br from-[#1e3a66] via-[#152c4e] to-[#0b172a] text-white rounded-3xl p-6 sm:p-10 shadow-2xl relative overflow-hidden flex flex-col justify-between border border-white/10 group">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-[#ca9e54]/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>

                <div>
                    <!-- Badge & Discount Pill -->
                    <div class="flex items-center justify-between gap-2 mb-6">
                        <span class="inline-flex items-center gap-1.5 bg-[#ca9e54] text-white text-[10px] sm:text-xs font-bold px-3.5 py-1 rounded-full uppercase tracking-wider shadow-md">
                            <i class="ri-time-line"></i> Flash Sale Weekend
                        </span>
                        <span class="bg-white/10 backdrop-blur-md text-[#e5c382] text-xs font-bold px-3 py-1 rounded-full border border-white/10">
                            -40% OFF
                        </span>
                    </div>

                    <h3 class="font-serif-title text-2xl sm:text-4xl font-bold mb-3 leading-tight">
                        Weekend Luxury Escape
                    </h3>
                    
                    <p class="text-xs sm:text-sm text-white/80 font-light leading-relaxed mb-6">
                        Reservasi weekend di villa mewah pilihan kawasan Seminyak & Uluwatu. Dapatkan diskon 40% plus bonus gratis makan malam dan welcome drink.
                    </p>

                    <!-- Live Countdown Timer -->
                    <div class="mb-6">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block mb-2">SISA WAKTU PROMO:</span>
                        <div class="flex items-center gap-2 sm:gap-3" id="promo-timer">
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-2.5 sm:p-3 min-w-[62px] text-center border border-white/10">
                                <span class="block text-xl sm:text-2xl font-bold font-mono text-[#e5c382]" id="p-hours">23</span>
                                <span class="text-[9px] uppercase font-bold text-white/60 tracking-wider">JAM</span>
                            </div>
                            <span class="text-lg font-bold text-[#e5c382]">:</span>
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-2.5 sm:p-3 min-w-[62px] text-center border border-white/10">
                                <span class="block text-xl sm:text-2xl font-bold font-mono text-[#e5c382]" id="p-mins">42</span>
                                <span class="text-[9px] uppercase font-bold text-white/60 tracking-wider">MENIT</span>
                            </div>
                            <span class="text-lg font-bold text-[#e5c382]">:</span>
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-2.5 sm:p-3 min-w-[62px] text-center border border-white/10">
                                <span class="block text-xl sm:text-2xl font-bold font-mono text-[#e5c382]" id="p-secs">15</span>
                                <span class="text-[9px] uppercase font-bold text-white/60 tracking-wider">DETIK</span>
                            </div>
                        </div>
                    </div>

                    <!-- Voucher Box -->
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3.5 border border-white/15 flex items-center justify-between mb-8">
                        <div>
                            <span class="text-[9px] uppercase font-bold text-slate-300 block">KODE VOUCHER</span>
                            <span class="text-lg sm:text-xl font-mono font-bold text-[#e5c382]">PALMAWEEKEND</span>
                        </div>
                        <button onclick="copyCode('PALMAWEEKEND', this)" class="bg-[#ca9e54] hover:bg-[#b88c43] text-white text-xs font-bold px-4 py-2 rounded-xl transition-all shadow-md active:scale-95">
                            Salin Kode
                        </button>
                    </div>
                </div>

                <div>
                    <a href="{{ route('villa.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#ca9e54] hover:bg-[#b88c43] text-white font-bold px-8 py-4 rounded-full text-xs uppercase tracking-wider transition duration-300 shadow-lg gold-glow">
                        <span>Gunakan Promo Sekarang</span>
                        <i class="ri-arrow-right-line text-base"></i>
                    </a>
                </div>
            </div>

            <!-- Main Promo 2: VIP Member Welcome Bonus -->
            <div class="bg-gradient-to-br from-[#d4af37] via-[#ca9e54] to-[#b88c43] text-white rounded-3xl p-6 sm:p-10 shadow-2xl relative overflow-hidden flex flex-col justify-between group">
                <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-black/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>

                <div>
                    <!-- Badge -->
                    <div class="flex items-center justify-between gap-2 mb-6">
                        <span class="inline-flex items-center gap-1.5 bg-black/20 backdrop-blur-md text-white text-[10px] sm:text-xs font-bold px-3.5 py-1 rounded-full uppercase tracking-wider border border-white/20">
                            <i class="ri-vip-crown-line"></i> Khusus Member Baru
                        </span>
                        <span class="bg-white/20 backdrop-blur-md text-white text-xs font-bold px-3 py-1 rounded-full border border-white/20">
                            -35% OFF
                        </span>
                    </div>

                    <h3 class="font-serif-title text-2xl sm:text-4xl font-bold mb-3 leading-tight">
                        Bonus Registrasi Pertama
                    </h3>

                    <p class="text-xs sm:text-sm text-white/90 font-light leading-relaxed mb-6">
                        Daftar akun Palma hari ini dan klaim diskon instan 35% untuk reservasi villa pertama Anda beserta paket penjemputan bandara gratis.
                    </p>

                    <!-- Features checklist -->
                    <ul class="space-y-2.5 mb-6 text-xs sm:text-sm font-medium text-white/95">
                        <li class="flex items-center gap-2.5">
                            <i class="ri-checkbox-circle-fill text-lg text-white"></i>
                            <span>Gratis Transfer Bandara VIP (Alphard / SUV)</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="ri-checkbox-circle-fill text-lg text-white"></i>
                            <span>Gratis Romantic Candlelight Dinner</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="ri-checkbox-circle-fill text-lg text-white"></i>
                            <span>Layanan Concierge 24 Jam Nonstop</span>
                        </li>
                    </ul>

                    <!-- Voucher Box -->
                    <div class="bg-black/20 backdrop-blur-md rounded-2xl p-3.5 border border-white/20 flex items-center justify-between mb-8">
                        <div>
                            <span class="text-[9px] uppercase font-bold text-white/70 block">KODE VOUCHER</span>
                            <span class="text-lg sm:text-xl font-mono font-bold text-white">WELCOMEPALMA</span>
                        </div>
                        <button onclick="copyCode('WELCOMEPALMA', this)" class="bg-white hover:bg-slate-100 text-slate-900 text-xs font-bold px-4 py-2 rounded-xl transition-all shadow-md active:scale-95">
                            Salin Kode
                        </button>
                    </div>
                </div>

                <div>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white text-slate-900 hover:bg-slate-50 font-bold px-8 py-4 rounded-full text-xs uppercase tracking-wider transition duration-300 shadow-lg">
                        <span>Daftar & Klaim Diskon</span>
                        <i class="ri-arrow-right-line text-base"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- Section Header for Secondary Deals -->
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-[10px] sm:text-xs font-bold tracking-[0.2em] text-[#ca9e54] uppercase block">Penawaran Tambahan</span>
            <h2 class="font-serif-title text-2xl sm:text-4xl font-normal text-slate-900">
                Pilihan Promo Lainnya
            </h2>
        </div>

        <!-- 4 Curated Feature Promo Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Card 1 -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg transition duration-300 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="w-11 h-11 rounded-2xl bg-[#152c4e]/10 text-[#152c4e] flex items-center justify-center text-xl">
                        <i class="ri-calendar-check-line"></i>
                    </div>
                    <span class="text-[10px] font-bold text-[#ca9e54] uppercase tracking-wider block">LONG STAY SANCTUARY</span>
                    <h4 class="font-serif-title text-xl font-bold text-slate-900">Hemat 25% (> 7 Malam)</h4>
                    <p class="text-xs text-slate-500 font-light leading-relaxed">
                        Nikmati pengalaman liburan panjang. Makin lama Anda menginap, makin hemat harga per malamnya.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] font-mono font-bold text-slate-700">LONGSTAY25</span>
                    <a href="{{ route('villa.index') }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54]">Pesan <i class="ri-arrow-right-line"></i></a>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg transition duration-300 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="w-11 h-11 rounded-2xl bg-[#ca9e54]/10 text-[#ca9e54] flex items-center justify-center text-xl">
                        <i class="ri-gift-line"></i>
                    </div>
                    <span class="text-[10px] font-bold text-[#ca9e54] uppercase tracking-wider block">REFERRAL REWARD</span>
                    <h4 class="font-serif-title text-xl font-bold text-slate-900">Kredit $100 Per Teman</h4>
                    <p class="text-xs text-slate-500 font-light leading-relaxed">
                        Ajak kerabat & teman Anda menginap di Palma dan dapatkan langsung kredit saldo $100 per booking.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] font-mono font-bold text-slate-700">REFER100</span>
                    <a href="{{ route('villa.index') }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54]">Pesan <i class="ri-arrow-right-line"></i></a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg transition duration-300 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="w-11 h-11 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-xl">
                        <i class="ri-price-tag-3-line"></i>
                    </div>
                    <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider block">LAST MINUTE DEAL</span>
                    <h4 class="font-serif-title text-xl font-bold text-slate-900">Diskon Hingga 50%</h4>
                    <p class="text-xs text-slate-500 font-light leading-relaxed">
                        Penawaran istimewa untuk pemesanan tanggal spontan di minggu yang sama.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] font-mono font-bold text-slate-700">LASTMIN50</span>
                    <a href="{{ route('villa.index') }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54]">Pesan <i class="ri-arrow-right-line"></i></a>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg transition duration-300 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="w-11 h-11 rounded-2xl bg-rose-500/10 text-rose-600 flex items-center justify-center text-xl">
                        <i class="ri-heart-3-line"></i>
                    </div>
                    <span class="text-[10px] font-bold text-rose-600 uppercase tracking-wider block">HONEYMOON SPECIAL</span>
                    <h4 class="font-serif-title text-xl font-bold text-slate-900">Paket Pasangan Romantis</h4>
                    <p class="text-xs text-slate-500 font-light leading-relaxed">
                        Gratis dekorasi bunga tempat tidur, botol wine premium, dan perawatan spa pasangan 90 menit.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] font-mono font-bold text-slate-700">ROMANCEVIP</span>
                    <a href="{{ route('villa.index') }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54]">Pesan <i class="ri-arrow-right-line"></i></a>
                </div>
            </div>

        </div>

    </section>

@push('scripts')
<script>
    // Copy Promo Code to Clipboard Helper
    function copyCode(code, btnElement) {
        navigator.clipboard.writeText(code).then(() => {
            const originalText = btnElement.innerText;
            btnElement.innerText = "Tersalin! ✓";
            btnElement.classList.add('bg-emerald-600', 'text-white');
            setTimeout(() => {
                btnElement.innerText = originalText;
                btnElement.classList.remove('bg-emerald-600');
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }

    // Ticking Countdown Timer JS
    let pHours = 23, pMins = 42, pSecs = 15;
    const hEl = document.getElementById('p-hours');
    const mEl = document.getElementById('p-mins');
    const sEl = document.getElementById('p-secs');

    setInterval(() => {
        if (pSecs > 0) {
            pSecs--;
        } else {
            pSecs = 59;
            if (pMins > 0) {
                pMins--;
            } else {
                pMins = 59;
                if (pHours > 0) pHours--;
            }
        }
        if (hEl) hEl.innerText = String(pHours).padStart(2, '0');
        if (mEl) mEl.innerText = String(pMins).padStart(2, '0');
        if (sEl) sEl.innerText = String(pSecs).padStart(2, '0');
    }, 1000);
</script>
@endpush
@endsection
