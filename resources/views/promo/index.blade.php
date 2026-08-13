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

    @php
        $dbPromos = isset($promotions) && $promotions->count() > 0 ? $promotions : collect();
        $featuredPromos = $dbPromos->where('is_featured', true)->values();
        
        if ($featuredPromos->count() === 0) {
            $featuredPromos = $dbPromos->take(2);
            $otherPromos = $dbPromos->slice(2);
        } else {
            $featuredIds = $featuredPromos->pluck('id')->toArray();
            $otherPromos = $dbPromos->reject(fn($p) => in_array($p->id, $featuredIds));
        }

        $p1 = $featuredPromos->get(0);
        $p2 = $featuredPromos->get(1);

        $getThemeClass = function($theme, $default = 'navy') {
            return match($theme ?? $default) {
                'gold' => 'bg-gradient-to-br from-[#d4af37] via-[#ca9e54] to-[#b88c43]',
                'dark' => 'bg-gradient-to-br from-[#0f172a] via-[#1e293b] to-[#020617]',
                default => 'bg-gradient-to-br from-[#1e3a66] via-[#152c4e] to-[#0b172a]'
            };
        };
    @endphp

    <!-- PROMO CARDS SECTION -->
    <section class="py-14 sm:py-20 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi">
        
        <!-- Top Main Banners Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            
            <!-- Main Promo Card 1 -->
            <div class="{{ $getThemeClass($p1?->banner_theme, 'navy') }} text-white rounded-3xl p-6 sm:p-10 shadow-2xl relative overflow-hidden flex flex-col justify-between border border-white/10 group">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-[#ca9e54]/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>

                <div>
                    <!-- Badge & Discount Pill -->
                    <div class="flex items-center justify-between gap-2 mb-6">
                        <span class="inline-flex items-center gap-1.5 bg-[#ca9e54] text-white text-[10px] sm:text-xs font-bold px-3.5 py-1 rounded-full uppercase tracking-wider shadow-md">
                            <i class="ri-time-line"></i> {{ $p1 ? ($p1->badge_text ?: ($p1->promotion_type === 'automatic' ? 'Promo Otomatis' : 'Flash Sale Special')) : 'FLASH SALE WEEKEND' }}
                        </span>
                        <span class="bg-white/10 backdrop-blur-md text-[#e5c382] text-xs font-bold px-3 py-1 rounded-full border border-white/10">
                            @if($p1)
                                {{ $p1->discount_type === 'percentage' ? '-' . number_format($p1->discount_value, 0) . '% OFF' : 'Diskon Rp ' . number_format($p1->discount_value, 0, ',', '.') }}
                            @else
                                -40% OFF
                            @endif
                        </span>
                    </div>

                    <h3 class="font-serif-title text-2xl sm:text-4xl font-bold mb-3 leading-tight">
                        {{ $p1 ? $p1->name : 'Weekend Luxury Escape' }}
                    </h3>
                    
                    <p class="text-xs sm:text-sm text-white/80 font-light leading-relaxed mb-6">
                        {{ $p1 ? ($p1->description ?: 'Reservasi weekend di villa mewah pilihan kawasan Seminyak & Uluwatu. Dapatkan diskon 40% plus bonus gratis makan malam dan welcome drink.') : 'Reservasi weekend di villa mewah pilihan kawasan Seminyak & Uluwatu. Dapatkan diskon 40% plus bonus gratis makan malam dan welcome drink.' }}
                    </p>

                    <!-- Features Checklist (If Provided) -->
                    @if($p1 && count($p1->features_list) > 0)
                        <ul class="space-y-2.5 mb-6 text-xs sm:text-sm font-medium text-white/95">
                            @foreach($p1->features_list as $feat)
                                <li class="flex items-center gap-2.5">
                                    <i class="ri-checkbox-circle-fill text-lg text-[#e5c382]"></i>
                                    <span>{{ $feat }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <!-- Live Countdown Timer -->
                    <div class="mb-6">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block mb-2">SISA WAKTU PROMO:</span>
                        <div class="flex items-center gap-2 sm:gap-3" id="promo-timer-1">
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-2.5 sm:p-3 min-w-[62px] text-center border border-white/10">
                                <span class="block text-xl sm:text-2xl font-bold font-mono text-[#e5c382]" id="p1-hours">23</span>
                                <span class="text-[9px] uppercase font-bold text-white/60 tracking-wider">JAM</span>
                            </div>
                            <span class="text-lg font-bold text-[#e5c382]">:</span>
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-2.5 sm:p-3 min-w-[62px] text-center border border-white/10">
                                <span class="block text-xl sm:text-2xl font-bold font-mono text-[#e5c382]" id="p1-mins">42</span>
                                <span class="text-[9px] uppercase font-bold text-white/60 tracking-wider">MENIT</span>
                            </div>
                            <span class="text-lg font-bold text-[#e5c382]">:</span>
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-2.5 sm:p-3 min-w-[62px] text-center border border-white/10">
                                <span class="block text-xl sm:text-2xl font-bold font-mono text-[#e5c382]" id="p1-secs">15</span>
                                <span class="text-[9px] uppercase font-bold text-white/60 tracking-wider">DETIK</span>
                            </div>
                        </div>
                    </div>

                    <!-- Voucher Box -->
                    @php $code1 = $p1 ? ($p1->code ?: 'PALMAWEEKEND') : 'PALMAWEEKEND'; @endphp
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3.5 border border-white/15 flex items-center justify-between mb-8">
                        <div>
                            <span class="text-[9px] uppercase font-bold text-slate-300 block">KODE VOUCHER</span>
                            <span class="text-lg sm:text-xl font-mono font-bold text-[#e5c382]">{{ $code1 }}</span>
                        </div>
                        <button onclick="copyCode('{{ $code1 }}', this)" class="bg-[#ca9e54] hover:bg-[#b88c43] text-white text-xs font-bold px-4 py-2 rounded-xl transition-all shadow-md active:scale-95 cursor-pointer">
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

            <!-- Main Promo Card 2 -->
            <div class="{{ $getThemeClass($p2?->banner_theme, 'gold') }} text-white rounded-3xl p-6 sm:p-10 shadow-2xl relative overflow-hidden flex flex-col justify-between group">
                <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-black/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>

                <div>
                    <!-- Badge -->
                    <div class="flex items-center justify-between gap-2 mb-6">
                        <span class="inline-flex items-center gap-1.5 bg-black/20 backdrop-blur-md text-white text-[10px] sm:text-xs font-bold px-3.5 py-1 rounded-full uppercase tracking-wider border border-white/20">
                            <i class="ri-vip-crown-line"></i> {{ $p2 ? ($p2->badge_text ?: 'KHUSUS MEMBER BARU') : 'KHUSUS MEMBER BARU' }}
                        </span>
                        <span class="bg-white/20 backdrop-blur-md text-white text-xs font-bold px-3 py-1 rounded-full border border-white/20">
                            @if($p2)
                                {{ $p2->discount_type === 'percentage' ? '-' . number_format($p2->discount_value, 0) . '% OFF' : 'Diskon Rp ' . number_format($p2->discount_value, 0, ',', '.') }}
                            @else
                                -35% OFF
                            @endif
                        </span>
                    </div>

                    <h3 class="font-serif-title text-2xl sm:text-4xl font-bold mb-3 leading-tight">
                        {{ $p2 ? $p2->name : 'Bonus Registrasi Pertama' }}
                    </h3>

                    <p class="text-xs sm:text-sm text-white/90 font-light leading-relaxed mb-6">
                        {{ $p2 ? ($p2->description ?: 'Daftar akun Palma hari ini dan klaim diskon instan 35% untuk reservasi villa pertama Anda beserta paket penjemputan bandara gratis.') : 'Daftar akun Palma hari ini dan klaim diskon instan 35% untuk reservasi villa pertama Anda beserta paket penjemputan bandara gratis.' }}
                    </p>

                    <!-- Features checklist -->
                    @php
                        $featuresList = $p2 && count($p2->features_list) > 0 
                            ? $p2->features_list 
                            : ['Gratis Transfer Bandara VIP (Alphard / SUV)', 'Gratis Romantic Candlelight Dinner', 'Layanan Concierge 24 Jam Nonstop'];
                    @endphp
                    <ul class="space-y-2.5 mb-6 text-xs sm:text-sm font-medium text-white/95">
                        @foreach($featuresList as $feat)
                            <li class="flex items-center gap-2.5">
                                <i class="ri-checkbox-circle-fill text-lg text-white"></i>
                                <span>{{ $feat }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Voucher Box -->
                    @php $code2 = $p2 ? ($p2->code ?: 'WELCOMEPALMA') : 'WELCOMEPALMA'; @endphp
                    <div class="bg-black/20 backdrop-blur-md rounded-2xl p-3.5 border border-white/20 flex items-center justify-between mb-8">
                        <div>
                            <span class="text-[9px] uppercase font-bold text-white/70 block">KODE VOUCHER</span>
                            <span class="text-lg sm:text-xl font-mono font-bold text-white">{{ $code2 }}</span>
                        </div>
                        <button onclick="copyCode('{{ $code2 }}', this)" class="bg-white hover:bg-slate-100 text-slate-900 text-xs font-bold px-4 py-2 rounded-xl transition-all shadow-md active:scale-95 cursor-pointer">
                            Salin Kode
                        </button>
                    </div>
                </div>

                <div>
                    <a href="{{ auth()->check() ? route('villa.index') : route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white text-slate-900 hover:bg-slate-50 font-bold px-8 py-4 rounded-full text-xs uppercase tracking-wider transition duration-300 shadow-lg">
                        <span>{{ auth()->check() ? 'Gunakan Promo Sekarang' : 'Daftar & Klaim Diskon' }}</span>
                        <i class="ri-arrow-right-line text-base"></i>
                    </a>
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
    const hEl = document.getElementById('p1-hours');
    const mEl = document.getElementById('p1-mins');
    const sEl = document.getElementById('p1-secs');

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
