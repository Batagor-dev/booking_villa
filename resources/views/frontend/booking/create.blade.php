@extends('layouts.frontend.main')

@section('title', 'Form Reservasi Villa - ' . ($selectedProperty->name ?? 'Palma Luxury'))

@php
    $propertyOptions = [];
    foreach($properties as $pItem) {
        $propertyOptions[$pItem->slug] = $pItem->name . ' (' . format_rupiah($pItem->price) . '/malam)';
    }

    $paymentOptions = [];
    foreach($paymentMethods as $pm) {
        $paymentOptions[$pm->id] = $pm->name . ' (' . strtoupper($pm->type) . ')';
    }
@endphp

@section('content')
    <!-- HERO HEADER BOOKING PAGE -->
    <section class="relative pt-32 pb-12 px-4 sm:px-6 md:px-12 bg-[#152c4e] text-white font-satoshi overflow-hidden">
        <div class="absolute inset-0 opacity-15 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=80" alt="Villa Sanctuary" class="w-full h-full object-cover">
        </div>
        <div class="max-w-7xl mx-auto relative z-10">
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs text-white/70 mb-3 font-medium">
                <a href="{{ route('home') }}" class="hover:text-[#ca9e54] transition-colors">{{ __('frontend.booking.breadcrumb_home') }}</a>
                <span>/</span>
                <a href="{{ route('villa.index') }}" class="hover:text-[#ca9e54] transition-colors">{{ __('frontend.booking.breadcrumb_villa') }}</a>
                @if($selectedProperty)
                    <span>/</span>
                    <a href="{{ route('villa.show', $selectedProperty->slug) }}" class="hover:text-[#ca9e54] transition-colors">{{ $selectedProperty->name }}</a>
                @endif
                <span>/</span>
                <span class="text-white font-semibold">{{ __('frontend.booking.breadcrumb_form') }}</span>
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <span class="text-[10px] sm:text-xs font-bold tracking-[0.25em] text-[#e5c382] uppercase block mb-1">{{ __('frontend.booking.official_guarantee') }}</span>
                    <h1 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-normal text-white">
                        {{ __('frontend.booking.page_title') }}
                    </h1>
                </div>
                <a href="{{ $selectedProperty ? route('villa.show', $selectedProperty->slug) : route('villa.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition-all border border-white/20 shrink-0 w-fit">
                    <i class="ri-arrow-left-line text-sm"></i> {{ __('frontend.booking.back_to_detail') }}
                </a>
            </div>
        </div>
    </section>

    <!-- MAIN FORM & DETAILS CONTAINER -->
    <section class="py-10 sm:py-14 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <!-- LEFT COLUMN: PROPERTY DETAILS, GALLERY & SETTINGS (5 Cols) -->
            <div class="lg:col-span-5 space-y-6">

                @if($selectedProperty)
                    @php
                        $propSettings = $selectedProperty->settings;
                    @endphp

                    <!-- PROPERTY SUMMARY CARD -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 space-y-4 p-5 sm:p-6">
                        <div class="relative h-56 rounded-2xl overflow-hidden bg-slate-100 group">
                            <img src="{{ $selectedProperty->main_image_url }}" alt="{{ $selectedProperty->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-3 left-3 flex gap-2">
                                <span class="bg-white/90 backdrop-blur-md text-slate-800 text-[10px] font-bold px-3 py-1 rounded-full shadow-sm">
                                    {{ $selectedProperty->type ?? 'Sanctuary' }}
                                </span>
                                @if($headerPromo = $selectedProperty->active_promo_details)
                                    <span class="bg-[#ca9e54] text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-sm uppercase tracking-wider flex items-center gap-1">
                                        <i class="ri-coupon-3-fill"></i> {{ $headerPromo['badge_text'] }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <h3 class="font-serif-title text-xl font-bold text-slate-900">{{ $selectedProperty->name }}</h3>
                                <div class="flex items-center gap-1 text-xs font-bold text-slate-800 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-200 shrink-0">
                                    <i class="ri-star-fill text-[#ca9e54]"></i>
                                    <span>{{ number_format($selectedProperty->rating ?? 4.9, 1) }}</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 flex items-center gap-1">
                                <i class="ri-map-pin-2-fill text-[#ca9e54]"></i>
                                <span>{{ $selectedProperty->address ?? ($selectedProperty->city . ', ' . $selectedProperty->province) }}</span>
                            </p>
                        </div>

                        <!-- Specs List -->
                        <div class="grid grid-cols-2 gap-3 pt-3 border-t border-slate-100 text-xs font-medium text-slate-700">
                            <div class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <i class="ri-hotel-bed-line text-lg text-[#ca9e54]"></i>
                                <div>
                                    <span class="text-[10px] text-slate-400 block uppercase font-bold">{{ __('frontend.booking.bedrooms_label') }}</span>
                                    <span class="font-bold text-slate-900">{{ $selectedProperty->bedrooms ?? 3 }} {{ __('frontend.villa.bedrooms') }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <i class="ri-group-line text-lg text-[#ca9e54]"></i>
                                <div>
                                    <span class="text-[10px] text-slate-400 block uppercase font-bold">{{ __('frontend.booking.capacity_label') }}</span>
                                    <span class="font-bold text-slate-900">{{ $selectedProperty->capacity ?? 6 }} {{ __('frontend.villa.guests') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Price display (Same UI as villa/show.blade.php) -->
                        @php $promoDetails = $selectedProperty->active_promo_details; @endphp
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-medium text-slate-500">{{ __('frontend.booking.price_per_night') }}</span>
                            <div class="text-right space-y-0.5">
                                @if($promoDetails)
                                    <div class="flex items-center gap-2 justify-end">
                                        <span class="line-through text-slate-400 text-xs font-medium font-mono">
                                            {{ format_rupiah($promoDetails['original_price']) }}
                                        </span>
                                        <span class="bg-[#ca9e54] text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow-xs">
                                            {{ $promoDetails['badge_text'] }}
                                        </span>
                                    </div>
                                    <div class="flex items-baseline gap-1 justify-end">
                                        <x-ui.price :value="(float) $promoDetails['final_price']" class="text-xl font-bold text-[#152c4e] font-serif-title tracking-tight" />
                                        <span class="text-xs text-slate-500 font-normal">{{ __('frontend.villa.per_night') }}</span>
                                    </div>
                                @else
                                    <x-ui.price :value="$selectedProperty->price" suffix="/malam" class="text-xl font-bold text-[#152c4e]" containerClass="inline-block text-right" />
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- PROPERTY SETTINGS & POLICIES (`PropertyRule`) -->
                    <div class="bg-slate-50/80 p-5 sm:p-6 rounded-3xl border border-slate-200/80 space-y-4 text-xs font-medium text-slate-700">
                        <div class="flex items-center justify-between border-b border-slate-200/60 pb-3">
                            <h4 class="font-bold text-slate-900 uppercase tracking-wider flex items-center gap-1.5 text-xs">
                                <i class="ri-shield-check-line text-base text-[#ca9e54]"></i> {{ __('frontend.booking.rules_policies') }}
                            </h4>
                            <span class="text-[10px] font-bold text-[#ca9e54] uppercase bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-200">
                                {{ $selectedProperty->type ?? 'Properti' }}
                            </span>
                        </div>
                        
                        <div class="space-y-3 max-h-[380px] overflow-y-auto pr-1">
                            @forelse($propertyRules ?? [] as $rule)
                                <div class="flex items-start gap-2.5 pb-2.5 border-b border-slate-200/50 last:border-0 last:pb-0">
                                    <i class="{{ $rule->icon ?: 'ri-shield-line' }} text-base text-[#ca9e54] shrink-0 mt-0.5"></i>
                                    <div class="space-y-0.5">
                                        <strong class="text-slate-900 font-bold block text-xs">{{ $rule->title }}</strong>
                                        <p class="text-[11px] text-slate-500 leading-snug font-light">{{ $rule->description }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="flex items-start gap-2.5 pb-2.5 border-b border-slate-200/50">
                                    <i class="ri-time-line text-base text-[#ca9e54] shrink-0 mt-0.5"></i>
                                    <div class="space-y-0.5">
                                        <strong class="text-slate-900 font-bold block text-xs">Waktu Check-in & Check-out</strong>
                                        <p class="text-[11px] text-slate-500 leading-snug font-light">Check-in mulai 14:00 WITA. Check-out maksimal 12:00 WITA.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        @if(!empty($propSettings->phone) || !empty($propSettings->email))
                            <div class="pt-2 border-t border-slate-200/60 flex items-center justify-between text-xs text-slate-500">
                                <span>Bantuan / Helpdesk Villa:</span>
                                <strong class="text-slate-800">{{ $propSettings->phone ?? $propSettings->email }}</strong>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- RIGHT COLUMN: FORM BOOKING & PAYMENT METHOD (7 Cols) -->
            <div class="lg:col-span-7 bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-100 space-y-6">
                
                <div class="border-b border-slate-100 pb-5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#ca9e54] block">Langkah Reservasi</span>
                    <h2 class="font-serif-title text-2xl sm:text-3xl font-bold text-slate-900">Formulir Pemesanan Villa</h2>
                    <p class="text-xs text-slate-500 font-light mt-1">Isi informasi tamu dan pilih metode pembayaran untuk melanjutkan.</p>
                </div>

                @if(session('success_booking'))
                    <div class="p-6 bg-emerald-50/90 rounded-3xl border border-emerald-200 text-emerald-950 space-y-4 shadow-sm animate-fade-in">
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-md">
                                <i class="ri-checkbox-circle-fill text-2xl"></i>
                            </div>
                            <div class="space-y-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 block">Reservasi Berhasil Dibuat</span>
                                <h3 class="text-base sm:text-lg font-bold text-slate-900">Terima kasih, {{ session('success_booking')['guest_name'] }}!</h3>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Kode booking Anda adalah <strong class="font-mono font-bold text-slate-900 bg-emerald-100/70 px-2 py-0.5 rounded">#{{ session('success_booking')['booking_code'] }}</strong> untuk properti <strong>{{ session('success_booking')['property_name'] }}</strong> dengan total pembayaran <strong>{{ session('success_booking')['total_price'] }}</strong>.
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-2.5 pt-2 border-t border-emerald-200/70">
                            @if(!empty(session('success_booking')['download_url']))
                                <a href="{{ session('success_booking')['download_url'] }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#152c4e] hover:bg-[#ca9e54] text-white text-xs font-bold transition shadow-sm">
                                    <i class="ri-file-download-line text-sm"></i> Unduh E-Voucher / Invoice (PDF)
                                </a>
                            @endif
                            <a href="{{ route('user.bookings') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white hover:bg-slate-100 text-slate-800 text-xs font-bold border border-slate-200 transition">
                                <i class="ri-list-check text-sm"></i> Lihat Pesanan Saya
                            </a>
                        </div>
                    </div>
                @endif

                @if(session('failed_booking'))
                    <div class="p-4 bg-rose-50 rounded-2xl border border-rose-200 text-rose-950 flex items-start gap-3">
                        <i class="ri-error-warning-fill text-rose-600 text-xl shrink-0 mt-0.5"></i>
                        <div class="space-y-0.5 text-xs">
                            <strong class="block font-bold">Pemesanan Tidak Dapat Diproses</strong>
                            <p class="text-rose-800 leading-relaxed">{{ session('failed_booking') }}</p>
                        </div>
                    </div>
                @endif

                <!-- MAIN BOOKING FORM SUBMISSION -->
                <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="booking-submit-form">
                    @csrf
                    <input type="hidden" name="property_id" value="{{ $selectedProperty->id ?? 1 }}">

                    <!-- DATES & CALCULATOR SECTION -->
                    <div class="bg-slate-50 p-5 rounded-3xl border border-slate-200/80 space-y-4 font-satoshi">
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="ri-calendar-event-fill text-[#ca9e54]"></i> {{ __('frontend.booking.schedule_and_duration') }}
                        </h4>

                        <x-ui.date 
                            type="range"
                            checkinName="check_in"
                            checkoutName="check_out"
                            checkinValue="{{ old('check_in', $defaultCheckIn ?? date('Y-m-d')) }}"
                            checkoutValue="{{ old('check_out', $defaultCheckOut ?? date('Y-m-d', strtotime('+2 days'))) }}"
                            :disabledDates="$bookedDates ?? []"
                            minDate="today"
                            :inline="true"
                            showMonths="2"
                        />

                        <!-- LIVE NIGHTS, SUBTOTAL, SERVICES, DISCOUNT & TOTAL CALCULATION BOX -->
                        <div class="p-4 bg-white rounded-2xl border border-slate-200/80 space-y-3 font-satoshi">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-800 font-bold text-[11px]" id="calc-nights-badge">2 {{ __('frontend.booking.nights') }}</span>
                                    <span class="text-slate-500 text-[11px]">x {{ format_rupiah($selectedProperty->price ?? 0) }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] text-slate-400 uppercase font-bold block">{{ __('frontend.booking.subtotal') }} Sewa Villa</span>
                                    <span id="calc-subtotal-price" class="text-sm font-bold text-slate-800">{{ format_rupiah(($selectedProperty->price ?? 0) * 2) }}</span>
                                </div>
                            </div>

                            <!-- Extra Services Subtotal Row (Hidden initially) -->
                            <div id="calc-services-row" class="flex items-center justify-between text-xs text-slate-700 font-medium hidden">
                                <span class="flex items-center gap-1 font-bold">
                                    <i class="ri-add-circle-fill text-[#ca9e54] text-sm"></i> Layanan Tambahan (<span id="calc-services-count">0 item</span>)
                                </span>
                                <strong id="calc-services-price" class="font-bold text-slate-900">+ Rp 0</strong>
                            </div>

                            <!-- Discount Row (Hidden initially) -->
                            <div id="calc-discount-row" class="flex items-center justify-between text-xs text-[#ca9e54] font-medium hidden">
                                <span class="flex items-center gap-1 font-bold">
                                    <i class="ri-coupon-3-fill text-[#ca9e54] text-sm"></i> {{ __('frontend.booking.promo_discount') }} (<span id="calc-discount-code" class="font-mono font-bold uppercase">-</span>)
                                </span>
                                <strong id="calc-discount-price" class="font-bold text-[#ca9e54]">- Rp 0</strong>
                            </div>

                            <div class="flex items-center justify-between pt-1 border-t border-slate-100">
                                <span class="text-xs text-slate-500 font-bold uppercase">{{ __('frontend.booking.total_payment') }}</span>
                                <span id="calc-total-price" class="text-lg font-bold text-[#152c4e]">{{ format_rupiah(($selectedProperty->price ?? 0) * 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- EXTRA SERVICES / ADD-ONS SECTION -->
                    @if(isset($propertyServices) && $propertyServices->count() > 0)
                        <div class="bg-slate-50/90 p-5 sm:p-6 rounded-3xl border border-slate-200/80 space-y-4 font-satoshi">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="ri-service-fill text-[#ca9e54] text-base"></i> Layanan Tambahan (Extra Services / Add-ons)
                                </h4>
                                <span class="text-[10px] bg-slate-200/70 text-slate-700 font-bold px-2.5 py-0.5 rounded-full">Opsional</span>
                            </div>
                            <p class="text-xs text-slate-500 font-light -mt-2">Tingkatkan kenyamanan menginap dengan memilih paket layanan khusus saat reservasi.</p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-1">
                                @foreach($propertyServices as $idx => $svc)
                                    @php
                                        $isPerNight = str_contains(strtolower($svc->price_type ?? ''), 'night');
                                    @endphp
                                    <div class="p-3.5 rounded-2xl bg-white border border-slate-200/80 hover:border-slate-300 transition-all duration-200 flex flex-col justify-between service-card" id="service-card-{{ $svc->id }}">
                                        <div>
                                            <div class="flex items-start justify-between gap-2 mb-1.5">
                                                <div class="flex items-center gap-2">
                                                    <span class="w-8 h-8 rounded-xl bg-amber-50 text-[#ca9e54] flex items-center justify-center shrink-0 border border-amber-200/60">
                                                        <i class="{{ $svc->icon ?: 'ri-service-line' }} text-base"></i>
                                                    </span>
                                                    <div>
                                                        <strong class="text-xs font-bold text-slate-900 block leading-tight">{{ $svc->name }}</strong>
                                                        @if($svc->category)
                                                            <span class="text-[9px] uppercase font-bold text-[#ca9e54] tracking-wider">{{ $svc->category }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <input type="checkbox" 
                                                       id="svc_chk_{{ $svc->id }}" 
                                                       data-id="{{ $svc->id }}" 
                                                       data-price="{{ (float)$svc->price }}" 
                                                       data-per-night="{{ $isPerNight ? 'true' : 'false' }}"
                                                       data-index="{{ $idx }}"
                                                       onchange="toggleServiceItem(this, {{ $idx }}, {{ $svc->id }})" 
                                                       class="w-4 h-4 rounded border-slate-300 text-[#152c4e] focus:ring-[#ca9e54] cursor-pointer mt-1">
                                            </div>

                                            @if($svc->description)
                                                <p class="text-[11px] text-slate-500 font-light line-clamp-2 mt-1 mb-2">{{ $svc->description }}</p>
                                            @endif
                                        </div>

                                        <div class="flex items-center justify-between pt-2 border-t border-slate-100 mt-2">
                                            <div class="text-xs font-bold text-slate-800">
                                                {{ format_rupiah($svc->price) }}
                                                <span class="text-[10px] text-slate-400 font-normal">/ {{ $isPerNight ? 'malam' : 'item' }}</span>
                                            </div>

                                            <!-- Quantity Selector (Hidden unless checked) -->
                                            <div id="svc_qty_wrapper_{{ $svc->id }}" class="flex items-center gap-1.5 hidden">
                                                <button type="button" onclick="changeServiceQty({{ $svc->id }}, -1)" class="w-6 h-6 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs cursor-pointer">-</button>
                                                <input type="number" 
                                                       id="svc_qty_input_{{ $svc->id }}" 
                                                       value="1" 
                                                       min="1" 
                                                       max="20" 
                                                       readonly 
                                                       class="w-8 text-center text-xs font-bold text-slate-900 border border-slate-200 rounded-md py-0.5 bg-slate-50">
                                                <button type="button" onclick="changeServiceQty({{ $svc->id }}, 1)" class="w-6 h-6 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs cursor-pointer">+</button>
                                            </div>
                                        </div>

                                        <!-- Hidden Form Inputs for Submission -->
                                        <input type="hidden" name="services[{{ $idx }}][id]" id="input_svc_id_{{ $svc->id }}" value="" disabled>
                                        <input type="hidden" name="services[{{ $idx }}][qty]" id="input_svc_qty_{{ $svc->id }}" value="1" disabled>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- PROMO CODE & VOUCHER SECTION (LUXURY MINIMALIST PALMA THEME) -->
                    <div class="bg-slate-50/80 p-5 rounded-3xl border border-slate-200/80 space-y-4 font-satoshi">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="ri-coupon-3-line text-[#ca9e54] text-base"></i> {{ __('frontend.booking.promo_section_title') }}
                            </h4>
                            <span class="text-[10px] bg-slate-200/70 text-slate-700 font-bold px-2.5 py-0.5 rounded-full">{{ __('frontend.booking.promo_limit') }}</span>
                        </div>

                        <!-- Hidden input for validated promo code -->
                        <input type="hidden" name="promo_code" id="input-validated-promo-code" value="{{ old('promo_code', $autoPromoCode ?? '') }}">

                        <!-- Input Form Group -->
                        <div class="flex items-center gap-2">
                            <div class="relative flex-1">
                                <i class="ri-ticket-2-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <input type="text" 
                                       id="input-promo-code" 
                                       placeholder="{{ __('frontend.booking.promo_placeholder') }}" 
                                       class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs uppercase font-mono font-bold text-slate-800 focus:outline-none focus:border-[#ca9e54] focus:ring-1 focus:ring-[#ca9e54] transition shadow-xs"
                                       value="{{ old('promo_code', $autoPromoCode ?? '') }}"
                                >
                            </div>
                            <button type="button" 
                                    onclick="applyPromoCode()" 
                                    id="btn-apply-promo"
                                    class="px-5 py-2.5 bg-[#152c4e] hover:bg-[#ca9e54] text-[#e5c382] hover:text-white font-bold text-xs rounded-xl transition-colors flex items-center gap-1.5 shrink-0 shadow-sm cursor-pointer"
                            >
                                <i class="ri-check-line"></i>
                                <span>{{ __('frontend.booking.apply_btn') }}</span>
                            </button>
                        </div>

                        <!-- Active Promo Badge (Initially Hidden unless active) -->
                        <div id="active-promo-badge" class="p-3.5 bg-amber-50/80 rounded-2xl border border-amber-200/80 flex items-center justify-between text-xs hidden">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-[#ca9e54]/10 text-[#ca9e54] flex items-center justify-center shrink-0">
                                    <i class="ri-checkbox-circle-fill text-lg"></i>
                                </div>
                                <div>
                                    <strong id="active-promo-name" class="text-slate-900 font-bold block text-xs">{{ __('frontend.booking.active_promo') }}</strong>
                                    <span id="active-promo-desc" class="text-[#ca9e54] text-[11px] font-medium">{{ __('frontend.booking.save_amount') }} Rp 0</span>
                                </div>
                            </div>
                            <button type="button" 
                                    onclick="removePromoCode()" 
                                    title="Hapus Kode Promo"
                                    aria-label="Hapus Kode Promo"
                                    class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white border border-amber-300 hover:border-rose-400 text-slate-500 hover:text-rose-600 flex items-center justify-center transition-all duration-200 shadow-xs cursor-pointer shrink-0 group"
                            >
                                <i class="ri-close-line text-lg font-bold transition-transform group-hover:scale-110"></i>
                            </button>
                        </div>

                        <!-- Error Alert Message Box (Initially Hidden unless error) -->
                        <div id="promo-error-box" class="p-3.5 bg-rose-50 rounded-2xl border border-rose-200/80 text-rose-900 text-xs font-medium space-y-1 @if(!session('error_promo')) hidden @endif">
                            <div class="flex items-start gap-2">
                                <i class="ri-error-warning-fill text-rose-500 text-base shrink-0 mt-0.5"></i>
                                <div class="space-y-0.5">
                                    <strong class="font-bold text-rose-950 block">Kode Promo Gagal</strong>
                                    <p id="promo-error-message" class="text-rose-800 text-[11px] leading-relaxed">
                                        {{ session('error_promo') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- GUEST INFORMATION SECTION -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="ri-user-3-fill text-[#ca9e54]"></i> {{ __('frontend.booking.guest_info_title') }}
                        </h4>

                        <div class="space-y-3">
                            <x-ui.input 
                                name="guest_name" 
                                label="{{ __('frontend.booking.guest_name') }}" 
                                placeholder="{{ __('frontend.booking.guest_name_ph') }}" 
                                value="{{ old('guest_name', auth()->user()->name ?? '') }}"
                                required
                            />

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-ui.input 
                                    type="email"
                                    name="guest_email" 
                                    label="{{ __('frontend.booking.guest_email') }}" 
                                    placeholder="nama@domain.com" 
                                    value="{{ old('guest_email', auth()->user()->email ?? '') }}"
                                    required
                                />

                                <x-ui.input 
                                    name="guest_phone" 
                                    label="{{ __('frontend.booking.guest_phone') }}" 
                                    placeholder="+62 812 3456 7890" 
                                    value="{{ old('guest_phone', '') }}"
                                    required
                                />
                            </div>

                            <div>
                                <x-ui.textarea 
                                    name="notes" 
                                    label="{{ __('frontend.booking.special_notes') }}" 
                                    placeholder="{{ __('frontend.booking.special_notes_ph') }}"
                                    value="{{ old('notes') }}"
                                    rows="2"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- PAYMENT METHOD SECTION USING COMPONENT x-ui.select2 -->
                    <div class="space-y-4 pt-2">
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="ri-bank-card-fill text-[#ca9e54]"></i> {{ __('frontend.booking.payment_section_title') }}
                        </h4>

                        <div>
                            <x-ui.select2 
                                name="payment_method_id"
                                id="select-payment-method-id"
                                label="{{ __('frontend.booking.select_payment_method') }}" 
                                placeholder="{{ __('frontend.booking.select_payment_ph') }}"
                                :options="$paymentOptions"
                                :value="old('payment_method_id')"
                                required
                            />
                        </div>

                        <!-- DYNAMIC PAYMENT INSTRUCTION & ACCOUNT INFO BOX (MINIMALIST SLATE THEME) -->
                        <div id="payment-details-box" class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3 hidden transition-all duration-300">
                            <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                                <span class="text-xs font-bold text-slate-900" id="pm-box-name">Bank Transfer BCA</span>
                                <span class="px-2.5 py-0.5 rounded-full bg-[#152c4e] text-white text-[10px] font-bold tracking-wider" id="pm-box-type">BANK TRANSFER</span>
                            </div>

                            <!-- MINIMALIST CASH DP NOTICE ALERT BOX -->
                            <div id="pm-box-cash-notice" class="p-3 rounded-xl bg-slate-100/90 border border-slate-200 text-slate-800 text-xs hidden flex items-start gap-2.5">
                                <i class="ri-information-fill text-[#152c4e] text-base shrink-0 mt-0.5"></i>
                                <div class="space-y-1">
                                    <strong class="font-bold text-slate-900 block text-xs">{{ __('frontend.booking.cash_notice_title') }}</strong>
                                    <p class="text-[11px] leading-relaxed text-slate-600">
                                        {{ __('frontend.booking.cash_notice_desc') }}
                                    </p>
                                </div>
                            </div>

                            <!-- ACCOUNT & RECIPIENT DETAILS GRID -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs" id="pm-box-details-grid">
                                <!-- Account Number Block (Hidden for QRIS) -->
                                <div id="pm-box-account-number-wrapper">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase block">{{ __('frontend.booking.account_number_label') }}</span>
                                    <div class="flex items-center gap-2 mt-1">
                                        <strong class="text-slate-900 font-mono text-sm font-bold" id="pm-box-number">8830123999</strong>
                                        <button type="button" onclick="copyAccountNo()" class="px-2.5 py-0.5 rounded-md bg-slate-200/80 hover:bg-[#152c4e] hover:text-white text-slate-700 text-[10px] font-bold transition flex items-center gap-1 cursor-pointer">
                                            <i class="ri-file-copy-line"></i> {{ __('frontend.booking.copy') }}
                                        </button>
                                    </div>
                                </div>

                                <!-- Recipient / Account Holder Block -->
                                <div id="pm-box-account-holder-wrapper">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase block" id="pm-box-holder-label">{{ __('frontend.booking.account_holder_label') }}</span>
                                    <strong class="text-slate-900 text-xs font-bold block mt-1" id="pm-box-holder">PT Palma Luxury Villa</strong>
                                </div>
                            </div>

                            <!-- QRIS Image Container if available -->
                            <div id="pm-box-qris-container" class="pt-3 border-t border-slate-200/70 hidden text-center space-y-2">
                                <span class="text-[10px] font-bold text-slate-500 uppercase block">{{ __('frontend.booking.scan_qris') }}</span>
                                <div class="inline-block">
                                    <img id="pm-box-qris-img" src="" alt="QRIS Code" class="h-80 w-80 object-contain mx-auto rounded-xl">
                                </div>
                            </div>

                            <!-- Custom Instruction/Note if present -->
                            <div id="pm-box-note-container" class="text-[11px] text-slate-500 italic hidden pt-1 border-t border-slate-200/60">
                                <span id="pm-box-note"></span>
                            </div>
                        </div>

                        <!-- PROOF OF PAYMENT UPLOAD USING COMPONENT x-ui.dropzone (SINGLE MODE) -->
                        <div class="pt-2">
                            <x-ui.dropzone 
                                name="bukti_payment"
                                id="input-bukti-payment"
                                label="{{ __('frontend.booking.upload_proof_label') }}"
                                accept="image/jpeg,image/png,image/webp"
                                :maxSize="5"
                                :multiple="false"
                                required
                            />
                        </div>

                    </div>

                    <!-- SUBMIT BUTTON & SECURITY DISCLAIMER CARD -->
                    <div class="pt-4 space-y-3">
                        <!-- PROPERTY RULES AGREEMENT CHECKBOX -->
                        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 text-xs flex items-start gap-2.5">
                            <input type="checkbox" id="agree_rules" name="agree_rules" required class="mt-0.5 rounded border-slate-300 text-[#152c4e] focus:ring-[#ca9e54] cursor-pointer shrink-0">
                            <label for="agree_rules" class="text-slate-600 font-medium cursor-pointer leading-snug">
                                {{ __('frontend.booking.agree_rules_label') }}
                            </label>
                        </div>

                        <x-ui.button 
                            type="submit" 
                            size="lg" 
                            font="bold" 
                            style="primary" 
                            class="w-full bg-[#152c4e] hover:bg-[#ca9e54] text-white rounded-2xl py-4 shadow-xl flex items-center justify-center gap-2 transition duration-300 cursor-pointer group"
                        >
                            <span class="uppercase tracking-wider text-xs font-bold">{{ __('frontend.booking.submit_button') }}</span>
                            <i class="ri-arrow-right-line text-lg group-hover:translate-x-1 transition-transform"></i>
                        </x-ui.button>
                        
                        <p class="text-[11px] text-slate-400 text-center flex items-center justify-center gap-1.5 pt-1 font-medium">
                            <i class="ri-shield-check-fill text-emerald-600 text-sm"></i>
                            <span>{{ __('frontend.booking.security_badge') }}</span>
                        </p>
                    </div>

                </form>
            </div>

        </div>

    </section>

    <!-- IMAGE LIGHTBOX MODAL -->
    <div id="gallery-lightbox" class="fixed inset-0 z-[100] bg-black/90 hidden flex items-center justify-center p-4" onclick="closeGalleryLightbox()">
        <img id="lightbox-img" src="" class="max-h-[85vh] max-w-[90vw] object-contain rounded-2xl border border-white/20 shadow-2xl">
    </div>
@endsection

@push('scripts')
    <script>
        const propertyPrice = {{ $selectedProperty->price ?? 0 }};
        const paymentMethodsData = @json($paymentMethods);
        let activePromoData = @json($selectedProperty && $selectedProperty->active_promo_details ? $selectedProperty->active_promo_details : null);
        const formatRupiah = (amount) => typeof window.formatRupiah === 'function' ? window.formatRupiah(amount) : 'Rp ' + new Intl.NumberFormat('id-ID').format(amount || 0);

        document.addEventListener('DOMContentLoaded', function() {
            calculateBookingTotal();

            document.addEventListener('change', function(e) {
                if (e.target && e.target.name === 'select_property') {
                    const slug = e.target.value;
                    if (slug) {
                        window.location.href = "{{ url('/booking') }}/" + slug;
                    }
                }

                if (e.target && e.target.name === 'payment_method_id') {
                    updatePaymentMethodBox(e.target.value);
                }
            });

            const pmInput = document.querySelector('input[name="payment_method_id"]');
            if (pmInput && pmInput.value) {
                updatePaymentMethodBox(pmInput.value);
            }

            const promoInputEl = document.getElementById('input-promo-code');
            if (promoInputEl && promoInputEl.value.trim() !== '') {
                applyPromoCode();
            }
        });
        function toggleServiceItem(chk, index, serviceId) {
            const inputId = document.getElementById('input_svc_id_' + serviceId);
            const inputQty = document.getElementById('input_svc_qty_' + serviceId);
            const qtyWrapper = document.getElementById('svc_qty_wrapper_' + serviceId);
            const card = document.getElementById('service-card-' + serviceId);

            if (chk.checked) {
                if (inputId) {
                    inputId.value = serviceId;
                    inputId.disabled = false;
                }
                if (inputQty) {
                    inputQty.disabled = false;
                }
                if (qtyWrapper) {
                    qtyWrapper.classList.remove('hidden');
                }
                if (card) {
                    card.classList.add('border-[#ca9e54]', 'bg-amber-50/20');
                }
            } else {
                if (inputId) {
                    inputId.value = '';
                    inputId.disabled = true;
                }
                if (inputQty) {
                    inputQty.disabled = true;
                }
                if (qtyWrapper) {
                    qtyWrapper.classList.add('hidden');
                }
                if (card) {
                    card.classList.remove('border-[#ca9e54]', 'bg-amber-50/20');
                }
            }

            calculateBookingTotal();
        }
        window.toggleServiceItem = toggleServiceItem;

        function changeServiceQty(serviceId, delta) {
            const qtyInput = document.getElementById('svc_qty_input_' + serviceId);
            const formInputQty = document.getElementById('input_svc_qty_' + serviceId);
            if (!qtyInput) return;

            let currentQty = parseInt(qtyInput.value) || 1;
            let newQty = Math.max(1, Math.min(20, currentQty + delta));
            
            qtyInput.value = newQty;
            if (formInputQty) {
                formInputQty.value = newQty;
            }

            calculateBookingTotal();
        }
        window.changeServiceQty = changeServiceQty;

        function calculateBookingTotal() {
            const checkInInput = document.getElementById('input-check-in');
            const checkOutInput = document.getElementById('input-check-out');
            
            if (!checkInInput || !checkOutInput || !checkInInput.value || !checkOutInput.value) return;

            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);

            if (checkOut <= checkIn) {
                const nextDay = new Date(checkIn);
                nextDay.setDate(nextDay.getDate() + 1);
                checkOutInput.value = nextDay.toISOString().split('T')[0];
            }

            const diffTime = Math.abs(new Date(checkOutInput.value) - new Date(checkInInput.value));
            const diffDays = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));

            const subtotal = propertyPrice * diffDays;

            // Calculate Extra Services
            let servicesSubtotal = 0;
            let servicesCount = 0;
            const serviceCheckboxes = document.querySelectorAll('input[id^="svc_chk_"]:checked');
            serviceCheckboxes.forEach(chk => {
                const price = parseFloat(chk.getAttribute('data-price')) || 0;
                const isPerNight = chk.getAttribute('data-per-night') === 'true';
                const sId = chk.getAttribute('data-id');
                const qtyInput = document.getElementById('svc_qty_input_' + sId);
                const qty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;

                const itemTotal = isPerNight ? (price * qty * diffDays) : (price * qty);
                servicesSubtotal += itemTotal;
                servicesCount += qty;
            });

            const totalBeforeDiscount = subtotal + servicesSubtotal;
            let discountAmount = 0;

            if (activePromoData) {
                if (activePromoData.discount_type === 'percentage') {
                    discountAmount = subtotal * (activePromoData.discount_value / 100);
                } else if (activePromoData.discount_amount) {
                    discountAmount = activePromoData.discount_amount * diffDays;
                } else {
                    discountAmount = (activePromoData.discount_value || 0) * diffDays;
                }
                discountAmount = Math.min(totalBeforeDiscount, Math.max(0, discountAmount));
            }

            const finalTotal = Math.max(0, totalBeforeDiscount - discountAmount);

            const nightsBadge = document.getElementById('calc-nights-badge');
            const subtotalPriceEl = document.getElementById('calc-subtotal-price');
            const servicesRowEl = document.getElementById('calc-services-row');
            const servicesCountEl = document.getElementById('calc-services-count');
            const servicesPriceEl = document.getElementById('calc-services-price');
            const discountRowEl = document.getElementById('calc-discount-row');
            const discountCodeEl = document.getElementById('calc-discount-code');
            const discountPriceEl = document.getElementById('calc-discount-price');
            const totalPriceEl = document.getElementById('calc-total-price');

            if (nightsBadge) nightsBadge.innerText = diffDays + ' Malam';
            if (subtotalPriceEl) subtotalPriceEl.innerText = formatRupiah(subtotal);

            // Update Extra Services breakdown row
            if (servicesRowEl) {
                if (servicesSubtotal > 0) {
                    if (servicesCountEl) servicesCountEl.innerText = servicesCount + ' item';
                    if (servicesPriceEl) servicesPriceEl.innerText = '+ ' + formatRupiah(servicesSubtotal);
                    servicesRowEl.classList.remove('hidden');
                } else {
                    servicesRowEl.classList.add('hidden');
                }
            }

            if (discountRowEl) {
                if (discountAmount > 0 && activePromoData) {
                    if (discountCodeEl) discountCodeEl.innerText = activePromoData.code || activePromoData.name || 'Promo Villa';
                    if (discountPriceEl) discountPriceEl.innerText = '- ' + formatRupiah(discountAmount);
                    discountRowEl.classList.remove('hidden');

                    const promoNameEl = document.getElementById('active-promo-name');
                    const promoDescEl = document.getElementById('active-promo-desc');
                    const promoBadgeEl = document.getElementById('active-promo-badge');
                    if (promoNameEl) promoNameEl.innerText = `Promo ${activePromoData.code || activePromoData.name || ''}`;
                    if (promoDescEl) {
                        if (activePromoData.discount_type === 'percentage') {
                            promoDescEl.innerText = `Diskon ${activePromoData.discount_value}% (${formatRupiah(discountAmount)})`;
                        } else {
                            promoDescEl.innerText = `Total Hemat ${formatRupiah(discountAmount)} (${diffDays} malam)`;
                        }
                    }
                    if (promoBadgeEl) promoBadgeEl.classList.remove('hidden');
                } else {
                    discountRowEl.classList.add('hidden');
                }
            }

            if (totalPriceEl) totalPriceEl.innerText = formatRupiah(finalTotal);
        }

        window.calculateBookingTotal = calculateBookingTotal;

        // Apply & Validate Promo Code via AJAX
        async function applyPromoCode() {
            const promoInput = document.getElementById('input-promo-code');
            const code = promoInput ? promoInput.value.trim() : '';
            const errorBox = document.getElementById('promo-error-box');
            const errorMessageEl = document.getElementById('promo-error-message');
            const btnApply = document.getElementById('btn-apply-promo');

            // Hide error box initially
            if (errorBox) errorBox.classList.add('hidden');

            if (!code) {
                if (errorBox && errorMessageEl) {
                    errorMessageEl.innerText = 'Silakan ketikkan kode promo terlebih dahulu.';
                    errorBox.classList.remove('hidden');
                }
                return;
            }

            const checkInInput = document.getElementById('input-check-in');
            const checkOutInput = document.getElementById('input-check-out');
            const propertyId = "{{ $selectedProperty->id ?? 1 }}";

            // SINGLE PROMO ENFORCEMENT: Check if trying to apply double promo
            const currentActiveCode = activePromoData ? activePromoData.code : null;
            if (currentActiveCode && currentActiveCode.toUpperCase() !== code.toUpperCase()) {
                if (errorBox && errorMessageEl) {
                    errorMessageEl.innerText = `Hanya bisa menggunakan 1 kode promo dalam satu pemesanan (tidak bisa digabung / double promo). Hapus promo '${currentActiveCode}' terlebih dahulu untuk menggantinya.`;
                    errorBox.classList.remove('hidden');
                }
                return;
            }

            // Spinner state
            btnApply.disabled = true;
            btnApply.innerHTML = `<i class="ri-loader-4-line animate-spin"></i> <span>Mengecek...</span>`;

            try {
                const response = await fetch("{{ route('booking.check-promo') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        promo_code: code,
                        property_id: propertyId,
                        check_in: checkInInput ? checkInInput.value : '',
                        check_out: checkOutInput ? checkOutInput.value : '',
                        current_active_code: currentActiveCode
                    })
                });

                const resData = await response.json();

                if (response.ok && resData.success) {
                    // Valid Promo Code
                    activePromoData = resData.data;
                    document.getElementById('input-validated-promo-code').value = resData.data.code;

                    // Show active badge
                    document.getElementById('active-promo-name').innerText = `Promo ${resData.data.code} (${resData.data.name})`;
                    document.getElementById('active-promo-desc').innerText = `Hemat ${resData.data.discount_formatted}`;
                    document.getElementById('active-promo-badge').classList.remove('hidden');

                    createToast('success', resData.message || 'Kode promo berhasil dipasang!');

                    calculateBookingTotal();
                } else {
                    // Invalid Promo Code -> Show exact error message from backend
                    if (errorBox && errorMessageEl) {
                        errorMessageEl.innerText = resData.message || 'Kode promo tidak dapat digunakan.';
                        errorBox.classList.remove('hidden');
                    }
                }
            } catch (err) {
                if (errorBox && errorMessageEl) {
                    errorMessageEl.innerText = 'Terjadi kesalahan jaringan/sistem saat memverifikasi kode promo. Silakan coba lagi.';
                    errorBox.classList.remove('hidden');
                }
            } finally {
                btnApply.disabled = false;
                btnApply.innerHTML = `<i class="ri-check-line"></i> <span>Gunakan</span>`;
            }
        }

        function removePromoCode() {
            activePromoData = null;
            document.getElementById('input-validated-promo-code').value = '';
            document.getElementById('input-promo-code').value = '';
            document.getElementById('active-promo-badge').classList.add('hidden');
            document.getElementById('promo-error-box').classList.add('hidden');
            calculateBookingTotal();
        }

        // Update payment method dynamic instruction box from paymentMethodsData
        function updatePaymentMethodBox(paymentMethodId) {
            const box = document.getElementById('payment-details-box');
            if (!paymentMethodId) {
                if (box) box.classList.add('hidden');
                return;
            }

            const pm = paymentMethodsData.find(item => String(item.id) === String(paymentMethodId));
            if (!pm) {
                if (box) box.classList.add('hidden');
                return;
            }

            const type = (pm.type || 'bank_transfer').toLowerCase();
            const isQris = type === 'qris';
            const isCash = type === 'cash' || (pm.name && pm.name.toLowerCase().includes('cash')) || (pm.name && pm.name.toLowerCase().includes('tunai'));

            const nameEl = document.getElementById('pm-box-name');
            const typeEl = document.getElementById('pm-box-type');
            if (nameEl) nameEl.innerText = pm.name || 'Metode Pembayaran';
            if (typeEl) typeEl.innerText = (pm.type || 'PAYMENT').toUpperCase();

            const cashNotice = document.getElementById('pm-box-cash-notice');
            const accNumWrapper = document.getElementById('pm-box-account-number-wrapper');
            const accHolderLabel = document.getElementById('pm-box-holder-label');
            const accHolderVal = document.getElementById('pm-box-holder');
            const accNumVal = document.getElementById('pm-box-number');
            const qrisContainer = document.getElementById('pm-box-qris-container');
            const qrisImg = document.getElementById('pm-box-qris-img');
            const noteContainer = document.getElementById('pm-box-note-container');
            const noteVal = document.getElementById('pm-box-note');

            // 1. CASH / TUNAI HANDLING
            if (isCash) {
                if (cashNotice) cashNotice.classList.remove('hidden');
                
                // Fallback to first bank transfer account if Cash record doesn't have an explicit account number
                const bankFallback = paymentMethodsData.find(item => (item.type || '').toLowerCase() === 'bank_transfer');
                const displayAccNum = pm.account_number || (bankFallback ? bankFallback.account_number : '-');
                const displayAccHolder = pm.account_name || (bankFallback ? bankFallback.account_name : '-');

                if (accNumWrapper) accNumWrapper.classList.remove('hidden');
                if (accNumVal) accNumVal.innerText = displayAccNum || '-';
                if (accHolderLabel) accHolderLabel.innerText = 'Atas Nama (Rekening Transfer DP)';
                if (accHolderVal) accHolderVal.innerText = displayAccHolder || '-';
                if (qrisContainer) qrisContainer.classList.add('hidden');
            } 
            // 2. QRIS HANDLING: HIDE NO. REKENING, ONLY SHOW RECIPIENT NAME & QR CODE!
            else if (isQris) {
                if (cashNotice) cashNotice.classList.add('hidden');
                // Hide account number completely for QRIS
                if (accNumWrapper) accNumWrapper.classList.add('hidden');
                if (accHolderLabel) accHolderLabel.innerText = 'Nama Penerima';
                if (accHolderVal) accHolderVal.innerText = pm.account_name || pm.provider || 'PT Palma Luxury Villa';

                if (pm.image_qris && pm.image_qris.trim() !== '') {
                    if (qrisImg) qrisImg.src = "{{ asset('storage') }}/" + pm.image_qris;
                    if (qrisContainer) qrisContainer.classList.remove('hidden');
                } else {
                    if (qrisContainer) qrisContainer.classList.add('hidden');
                }
            } 
            // 3. BANK TRANSFER & OTHER METHODS
            else {
                if (cashNotice) cashNotice.classList.add('hidden');
                if (accNumWrapper) accNumWrapper.classList.remove('hidden');
                if (accNumVal) accNumVal.innerText = pm.account_number || '-';
                if (accHolderLabel) accHolderLabel.innerText = 'Atas Nama / Pemilik';
                if (accHolderVal) accHolderVal.innerText = pm.account_name || '-';

                if (pm.image_qris && pm.image_qris.trim() !== '') {
                    if (qrisImg) qrisImg.src = "{{ asset('storage') }}/" + pm.image_qris;
                    if (qrisContainer) qrisContainer.classList.remove('hidden');
                } else {
                    if (qrisContainer) qrisContainer.classList.add('hidden');
                }
            }

            // Custom note from admin if present
            if (pm.note && pm.note.trim() !== '') {
                if (noteVal) noteVal.innerText = pm.note;
                if (noteContainer) noteContainer.classList.remove('hidden');
            } else {
                if (noteContainer) noteContainer.classList.add('hidden');
            }

            if (box) box.classList.remove('hidden');
        }

        // Copy Account Number
        function copyAccountNo() {
            const num = document.getElementById('pm-box-number').innerText;
            if (num && num !== '-') {
                navigator.clipboard.writeText(num);
                createToast('success', 'Nomor Rekening berhasil disalin!');
            }
        }

        // Gallery Lightbox Preview
        function previewGalleryImage(src) {
            document.getElementById('lightbox-img').src = src;
            document.getElementById('gallery-lightbox').classList.remove('hidden');
        }

        function closeGalleryLightbox() {
            document.getElementById('gallery-lightbox').classList.add('hidden');
        }
    </script>

    <!-- BOOKING SUCCESS MODAL (PALMA LUXURY THEME WITH SMOOTH ANIMATION) -->
    @if(session('success_booking'))
        @php $sData = session('success_booking'); @endphp
        <div id="booking-success-modal" onclick="closeBookingSuccessModal()" class="fixed inset-0 bg-black/75 backdrop-blur-md z-[110] flex items-center justify-center p-4 font-satoshi opacity-0 pointer-events-none transition-all duration-500 ease-out">
            <div id="booking-success-modal-card" class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl border border-slate-100 opacity-0 scale-90 translate-y-4 transition-all duration-500 ease-out relative" onclick="event.stopPropagation()">
                
                <div class="p-6 bg-[#152c4e] text-white text-center space-y-2 relative overflow-hidden">
                    <div class="w-16 h-16 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-400 flex items-center justify-center mx-auto text-3xl shadow-inner transform transition-transform duration-700 ease-out">
                        <i class="ri-checkbox-circle-fill"></i>
                    </div>
                    <span class="text-[9px] uppercase font-bold tracking-widest text-[#e5c382] block pt-1">RESERVASI BERHASIL</span>
                    <h3 class="font-serif-title text-2xl sm:text-3xl font-bold text-white">Terima Kasih!</h3>
                </div>

                <div class="p-6 space-y-4 text-xs font-medium text-slate-700">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/80 text-center space-y-1">
                        <span class="text-[10px] text-slate-400 uppercase font-bold block">Kode Booking Anda:</span>
                        <strong class="text-xl font-mono font-bold text-[#ca9e54] block">#{{ $sData['booking_code'] ?? '' }}</strong>
                    </div>

                    <div class="space-y-2 text-slate-600">
                        <div class="flex justify-between py-1 border-b border-slate-100">
                            <span>Nama Tamu:</span>
                            <strong class="text-slate-900">{{ $sData['guest_name'] ?? '-' }}</strong>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-100">
                            <span>Villa Properti:</span>
                            <strong class="text-slate-900">{{ $sData['property_name'] ?? '-' }}</strong>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-emerald-50 text-emerald-800 text-[11px] font-semibold border border-emerald-200 flex items-center gap-2">
                        <i class="ri-information-fill text-emerald-600 text-base shrink-0"></i> 
                        <span>Bukti pembayaran telah diterima. Tim kami sedang memverifikasi reservasi Anda.</span>
                    </div>

                    <div class="pt-2 flex flex-col gap-2">
                        <a href="{{ route('user.bookings') }}" class="w-full py-3 rounded-full bg-[#152c4e] hover:bg-[#ca9e54] text-white text-xs font-bold transition text-center uppercase tracking-wider shadow-md">
                            Lihat Riwayat Reservasi Saya
                        </a>
                        <button type="button" onclick="closeBookingSuccessModal()" class="w-full py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('booking-success-modal');
                const card = document.getElementById('booking-success-modal-card');
                if (modal && card) {
                    setTimeout(() => {
                        modal.classList.remove('opacity-0', 'pointer-events-none');
                        card.classList.remove('opacity-0', 'scale-90', 'translate-y-4');
                        card.classList.add('opacity-100', 'scale-100', 'translate-y-0');
                    }, 50);
                }
            });

            function closeBookingSuccessModal() {
                const modal = document.getElementById('booking-success-modal');
                const card = document.getElementById('booking-success-modal-card');
                if (modal && card) {
                    modal.classList.add('opacity-0', 'pointer-events-none');
                    card.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
                    card.classList.add('opacity-0', 'scale-95', 'translate-y-2');
                    setTimeout(() => modal.remove(), 400);
                }
            }
        </script>
    @endif
@endpush
