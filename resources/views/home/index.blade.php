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
        <div class="relative z-10 max-w-5xl mx-auto text-center text-white space-y-4 sm:space-y-6 my-auto pt-8 sm:pt-12">
            <!-- Editorial Subhead Text -->
            <span class="text-[10px] sm:text-xs font-bold tracking-[0.25em] text-[#e5c382] uppercase block mb-1">
                {{ __('frontend.home.hero_sub') }}
            </span>

            <!-- Title -->
            <h1 class="font-serif-title text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-normal leading-tight md:leading-none tracking-tight">
                {{ __('frontend.home.hero_title_1') }} <br class="hidden md:inline"/>
                <span class="italic font-normal gold-gradient-text inline-block pr-2.5">{{ __('frontend.home.hero_title_2') }}</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-xs sm:text-base md:text-lg text-slate-200 font-light max-w-2xl mx-auto leading-relaxed px-2">
                {{ __('frontend.home.hero_desc') }}
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 pt-2 px-4 sm:px-0">
                <a href="#villa" class="w-full sm:w-auto bg-[#ca9e54] hover:bg-[#b88c43] text-white font-semibold px-8 py-3.5 sm:py-4 rounded-full shadow-lg hover:shadow-xl transition duration-300 flex items-center justify-center gap-2 group text-xs uppercase tracking-wider gold-glow">
                    <span>{{ __('frontend.home.book_now') }}</span>
                    <i class="ri-arrow-right-line text-lg group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#destinasi" class="w-full sm:w-auto border border-white/40 hover:border-white bg-white/10 hover:bg-white/20 text-white font-medium px-8 py-3.5 sm:py-4 rounded-full transition duration-300 flex items-center justify-center text-xs uppercase tracking-wider backdrop-blur-md">
                    {{ __('frontend.home.favorite_destinations') }}
                </a>
            </div>
        </div>

    </section>

    <!-- SECTION: DESTINASI REKOMENDASI FAVORIT TURIS -->
    <section id="destinasi" class="pt-12 sm:pt-16 md:pt-20 pb-12 sm:pb-16 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto section-lazy font-satoshi">
        <!-- Section Header -->
        <div class="flex flex-row items-end justify-between mb-6 sm:mb-10 gap-4">
            <div>
                <span class="text-[10px] sm:text-xs font-bold tracking-[0.2em] text-[#ca9e54] uppercase block mb-1">{{ __('frontend.home.destinations_tag') }}</span>
                <h2 class="font-serif-title text-2xl sm:text-3xl md:text-5xl font-normal text-slate-900 mt-0.5 sm:mt-1">
                    {{ __('frontend.home.destinations_title') }}
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
            @foreach($destinations ?? [] as $dest)
                <a href="#villa" class="snap-start shrink-0 w-[260px] sm:w-[280px] md:w-[300px] group relative h-80 sm:h-96 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl flex flex-col justify-end p-5 sm:p-6 border border-slate-100">
                    <img src="{{ asset('storage/' . $dest->image_path) }}" 
                         alt="{{ $dest->name }}" 
                         draggable="false"
                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 pointer-events-none">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent pointer-events-none"></div>
                    
                    <div class="relative z-10 text-white space-y-2 pointer-events-none">
                        <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-white tracking-wide">{{ $dest->name }}</h3>
                        
                        @if(!empty($dest->formatted_tags) && is_countable($dest->formatted_tags) && count($dest->formatted_tags) > 0)
                            <div class="flex flex-wrap gap-1">
                                @foreach($dest->formatted_tags as $t)
                                    <span class="text-[9px] sm:text-[10px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full text-slate-100 font-medium">{{ $t }}</span>
                                @endforeach
                            </div>
                        @endif
                        
                        @if(!empty($dest->attraction))
                            <p class="text-[11px] sm:text-xs text-slate-300 font-light leading-snug pt-1 border-t border-white/10">
                                <strong class="text-[#e5c382] font-semibold">{{ __('frontend.home.attraction_label') }}</strong> {{ $dest->attraction }}
                            </p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- SECTION: VILLA MEWAH TERPILIH -->
    <section id="villa" class="pt-12 sm:pt-16 pb-16 sm:pb-20 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto section-lazy font-satoshi">
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-16 space-y-2 sm:space-y-3">
            <span class="text-[10px] sm:text-xs font-bold tracking-[0.2em] text-[#ca9e54] uppercase block mb-1">{{ __('frontend.home.villas_tag') }}</span>
            <h2 class="font-serif-title text-2xl sm:text-3xl md:text-5xl font-normal text-slate-900 mt-1">
                {{ __('frontend.home.villas_title') }}
            </h2>
            <p class="text-slate-600 font-light text-xs sm:text-base md:text-lg">
                {{ __('frontend.home.villas_desc') }}
            </p>
        </div>

        <!-- Villa Grid (Dynamic Cards - Matched with Villa List Page) -->
        <div class="mb-10 sm:mb-12">
            @include('villa.partials.grid', ['properties' => isset($properties) ? $properties->take(6) : collect([])])
        </div>

        <!-- Section Action Button -->
        <div class="text-center">
            <a href="{{ route('villa.index') }}" class="inline-flex items-center gap-2 bg-[#152c4e] hover:bg-[#0f1e36] text-white font-semibold px-8 py-3.5 sm:py-4 rounded-full shadow-md hover:shadow-lg transition duration-300 text-xs uppercase tracking-wider group">
                <span>{{ __('frontend.home.view_all_villas') }}</span>
                <i class="ri-arrow-right-line text-base group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </section>

    <!-- SECTION: PROMO TERBATAS -->
    <section id="promo" class="py-14 sm:py-20 px-4 sm:px-6 md:px-12 bg-gradient-to-b from-[#f4f6fa] to-[#f8f9fb] section-lazy font-satoshi">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-16 space-y-2 sm:space-y-3">
                <span class="text-[10px] sm:text-xs font-bold tracking-[0.2em] text-[#ca9e54] uppercase block mb-1">{{ __('frontend.home.promo_tag') }}</span>
                <h2 class="font-serif-title text-2xl sm:text-3xl md:text-5xl font-normal text-slate-900 mt-1">
                    {{ __('frontend.home.promo_title') }}
                </h2>
                <p class="text-slate-600 font-light text-xs sm:text-base md:text-lg">
                    {{ __('frontend.home.promo_desc') }}
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
                            <span>{{ __('frontend.home.flash_sale') }}</span>
                        </div>
                        <h3 class="font-serif-title text-2xl sm:text-3xl md:text-4xl font-bold mb-3 sm:mb-4 leading-tight">
                            {{ __('frontend.home.flash_sale_title') }}
                        </h3>
                        <p class="text-white/80 font-light text-xs sm:text-base mb-6 sm:mb-8 max-w-md">
                            {{ __('frontend.home.flash_sale_desc') }}
                        </p>

                        <!-- Countdown Timer -->
                        <div class="flex items-center gap-2 sm:gap-3 mb-6 sm:mb-8" id="countdown-timer">
                            <div class="bg-white/10 backdrop-blur-md rounded-xl sm:rounded-2xl p-2.5 sm:p-3 min-w-[58px] sm:min-w-[70px] text-center border border-white/10">
                                <span class="block text-xl sm:text-2xl font-bold font-mono text-[#e5c382]" id="timer-hours">23</span>
                                <span class="text-[9px] sm:text-[10px] uppercase font-bold text-white/60 tracking-wider">{{ __('frontend.home.timer_hours') }}</span>
                            </div>
                            <span class="text-lg sm:text-xl font-bold text-[#e5c382]">:</span>
                            <div class="bg-white/10 backdrop-blur-md rounded-xl sm:rounded-2xl p-2.5 sm:p-3 min-w-[58px] sm:min-w-[70px] text-center border border-white/10">
                                <span class="block text-xl sm:text-2xl font-bold font-mono text-[#e5c382]" id="timer-minutes">42</span>
                                <span class="text-[9px] sm:text-[10px] uppercase font-bold text-white/60 tracking-wider">{{ __('frontend.home.timer_minutes') }}</span>
                            </div>
                            <span class="text-lg sm:text-xl font-bold text-[#e5c382]">:</span>
                            <div class="bg-white/10 backdrop-blur-md rounded-xl sm:rounded-2xl p-2.5 sm:p-3 min-w-[58px] sm:min-w-[70px] text-center border border-white/10">
                                <span class="block text-xl sm:text-2xl font-bold font-mono text-[#e5c382]" id="timer-seconds">27</span>
                                <span class="text-[9px] sm:text-[10px] uppercase font-bold text-white/60 tracking-wider">{{ __('frontend.home.timer_seconds') }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('promo.index') }}" class="inline-flex items-center justify-center gap-2 bg-[#ca9e54] hover:bg-[#b88c43] text-white font-semibold px-8 py-3.5 rounded-full shadow-lg transition duration-300 w-full sm:w-auto text-xs uppercase tracking-wider">
                            <span>{{ __('frontend.home.claim_promo') }}</span>
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
                            <span>{{ __('frontend.home.vip_member_tag') }}</span>
                        </div>
                        <h3 class="font-serif-title text-2xl sm:text-3xl md:text-4xl font-bold mb-3 sm:mb-4 leading-tight">
                            {{ __('frontend.home.vip_member_title') }}
                        </h3>
                        <p class="text-white/90 font-light text-xs sm:text-base mb-6 max-w-md">
                            {{ __('frontend.home.vip_member_desc') }}
                        </p>

                        <!-- Features list -->
                        <ul class="space-y-2.5 sm:space-y-3 mb-6 sm:mb-8 text-xs sm:text-sm font-medium text-white/95">
                            <li class="flex items-center gap-2.5 sm:gap-3">
                                <i class="ri-checkbox-circle-fill text-base sm:text-lg text-white"></i>
                                <span>{{ __('frontend.home.feat_airport_transfer') }}</span>
                            </li>
                            <li class="flex items-center gap-2.5 sm:gap-3">
                                <i class="ri-checkbox-circle-fill text-base sm:text-lg text-white"></i>
                                <span>{{ __('frontend.home.feat_welcome_dinner') }}</span>
                            </li>
                            <li class="flex items-center gap-2.5 sm:gap-3">
                                <i class="ri-checkbox-circle-fill text-base sm:text-lg text-white"></i>
                                <span>{{ __('frontend.home.feat_concierge') }}</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <a href="{{ route('promo.index') }}" class="inline-flex items-center justify-center gap-2 bg-white text-slate-900 hover:bg-slate-50 font-bold px-8 py-3.5 rounded-full shadow-lg transition duration-300 w-full sm:w-auto text-xs uppercase tracking-wider">
                            <span>{{ __('frontend.home.start_now') }}</span>
                            <i class="ri-arrow-right-line text-base"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: PERBEDAN PALMA ("Why Choose Us") -->
    <section id="tentang" class="py-14 sm:py-24 px-4 sm:px-6 md:px-12 bg-white section-lazy font-satoshi">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-16 space-y-2 sm:space-y-3">
                <span class="text-[10px] sm:text-xs font-bold tracking-[0.2em] text-[#ca9e54] uppercase block mb-1">{{ __('frontend.home.why_tag') }}</span>
                <h2 class="font-serif-title text-2xl sm:text-3xl md:text-5xl font-normal text-slate-900 mt-1">
                    {{ __('frontend.home.why_title') }}
                </h2>
                <p class="text-slate-600 font-light text-xs sm:text-base md:text-lg">
                    {{ __('frontend.home.why_desc') }}
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
                        {{ __('frontend.home.why_val1_title') }}
                    </h3>
                    <p class="text-slate-600 font-light text-xs sm:text-sm leading-relaxed">
                        {{ __('frontend.home.why_val1_desc') }}
                    </p>
                </div>

                <!-- Value 2 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-3 sm:space-y-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-[#ca9e54] text-white flex items-center justify-center shadow-md text-xl sm:text-2xl">
                        <i class="ri-award-line"></i>
                    </div>
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">
                        {{ __('frontend.home.why_val2_title') }}
                    </h3>
                    <p class="text-slate-600 font-light text-xs sm:text-sm leading-relaxed">
                        {{ __('frontend.home.why_val2_desc') }}
                    </p>
                </div>

                <!-- Value 3 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-3 sm:space-y-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-teal-600 text-white flex items-center justify-center shadow-md text-xl sm:text-2xl">
                        <i class="ri-customer-service-2-line"></i>
                    </div>
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">
                        {{ __('frontend.home.why_val3_title') }}
                    </h3>
                    <p class="text-slate-600 font-light text-xs sm:text-sm leading-relaxed">
                        {{ __('frontend.home.why_val3_desc') }}
                    </p>
                </div>

                <!-- Value 4 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-3 sm:space-y-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-[#152c4e] text-white flex items-center justify-center shadow-md text-xl sm:text-2xl">
                        <i class="ri-heart-3-line"></i>
                    </div>
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">
                        {{ __('frontend.home.why_val4_title') }}
                    </h3>
                    <p class="text-slate-600 font-light text-xs sm:text-sm leading-relaxed">
                        {{ __('frontend.home.why_val4_desc') }}
                    </p>
                </div>

                <!-- Value 5 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-3 sm:space-y-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-[#ca9e54] text-white flex items-center justify-center shadow-md text-xl sm:text-2xl">
                        <i class="ri-rocket-line"></i>
                    </div>
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">
                        {{ __('frontend.home.why_val5_title') }}
                    </h3>
                    <p class="text-slate-600 font-light text-xs sm:text-sm leading-relaxed">
                        {{ __('frontend.home.why_val5_desc') }}
                    </p>
                </div>

                <!-- Value 6 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-[#f8f9fb] border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 space-y-3 sm:space-y-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-teal-600 text-white flex items-center justify-center shadow-md text-xl sm:text-2xl">
                        <i class="ri-vip-crown-line"></i>
                    </div>
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">
                        {{ __('frontend.home.why_val6_title') }}
                    </h3>
                    <p class="text-slate-600 font-light text-xs sm:text-sm leading-relaxed">
                        {{ __('frontend.home.why_val6_desc') }}
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: CTA BANNER WITH UNSPLASH BACKGROUND & NAVY BLUE OVERLAY -->
    <section class="py-16 sm:py-24 px-4 sm:px-6 md:px-12 relative font-satoshi text-white overflow-hidden">
        <!-- Unsplash Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1920&q=80" 
                 alt="Luxury Villa Sanctuary" 
                 class="w-full h-full object-cover object-center">
            <!-- Rich Navy Blue Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#0c182b]/90 via-[#152c4e]/85 to-[#0c182b]/90 backdrop-blur-[2px]"></div>
        </div>

        <div class="max-w-5xl mx-auto text-center space-y-4 sm:space-y-6 relative z-10">
            <span class="text-[10px] sm:text-xs font-bold tracking-[0.25em] text-[#e5c382] uppercase block mb-1">{{ __('frontend.home.cta_tag') }}</span>
            <h2 class="font-serif-title text-3xl sm:text-4xl md:text-6xl font-bold text-white leading-tight">
                {{ __('frontend.home.cta_title') }}
            </h2>
            <p class="text-white/90 font-light text-xs sm:text-base md:text-xl max-w-2xl mx-auto leading-relaxed px-2">
                {{ __('frontend.home.cta_desc') }}
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 pt-3 sm:pt-6 px-4 sm:px-0">
                <a href="#villa" class="w-full sm:w-auto bg-[#ca9e54] hover:bg-[#b88c43] text-white font-semibold px-9 py-3.5 sm:py-4 rounded-full shadow-xl transition duration-300 text-xs uppercase tracking-wider gold-glow flex items-center justify-center gap-2">
                    <span>{{ __('frontend.home.cta_explore_btn') }}</span>
                    <i class="ri-arrow-right-line text-base"></i>
                </a>
                <a href="#tentang" class="w-full sm:w-auto border border-white/30 hover:border-white bg-white/10 hover:bg-white/20 text-white font-medium px-9 py-3.5 sm:py-4 rounded-full transition duration-300 text-xs uppercase tracking-wider backdrop-blur-md flex items-center justify-center gap-2">
                    <span>{{ __('frontend.home.cta_concierge_btn') }}</span>
                    <i class="ri-customer-service-2-line text-base"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION: KATA TAMU KAMI (PHOTO MOSAIC & TESTIMONIALS MATCHING REFERENCE DESIGN) -->
    <section class="py-16 sm:py-28 px-4 sm:px-6 md:px-12 bg-white font-satoshi section-lazy border-t border-slate-100 overflow-hidden">
        <div class="max-w-7xl mx-auto space-y-12 sm:space-y-16">

            <!-- CENTER HEADLINE SECTION (MATCHING REFERENCE DESIGN) -->
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-slate-900 leading-tight">
                    {{ __('frontend.home.testi_title') }}
                </h2>
                <p class="text-slate-500 font-normal text-base sm:text-lg md:text-xl max-w-xl mx-auto">
                    {{ __('frontend.home.testi_subtitle') }}
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
                        {{ __('frontend.home.testi_quote_1') }}
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
                        {{ __('frontend.home.testi_quote_2') }}
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
                        {{ __('frontend.home.testi_quote_3') }}
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

        // Initialize flatpickr on search checkin date
        const checkinInput = document.getElementById('search-checkin-date');
        if (checkinInput && typeof flatpickr !== 'undefined') {
            flatpickr(checkinInput, {
                minDate: 'today',
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'j M Y',
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: { shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] },
                    months: {
                        shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
                    }
                }
            });
        }
    });
</script>
@endpush
