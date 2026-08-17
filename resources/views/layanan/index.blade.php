@extends('layouts.frontend.main')

@section('content')
    <!-- HERO HEADER LAYANAN -->
    <section class="relative pt-32 pb-20 px-4 sm:px-6 md:px-12 bg-[#152c4e] text-white font-satoshi overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-30 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=75" alt="Layanan Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-[#152c4e]/90 via-[#152c4e]/75 to-[#152c4e]"></div>
        </div>
        <div class="max-w-7xl mx-auto text-center relative z-10 space-y-4">
            <span class="text-[10px] sm:text-xs font-bold tracking-[0.25em] text-[#e5c382] uppercase block">{{ __('frontend.layanan.hero_tag') }}</span>
            <h1 class="font-serif-title text-3xl sm:text-5xl font-normal">{{ __('frontend.layanan.hero_title') }}</h1>
            <p class="text-xs sm:text-base text-white/80 font-light max-w-2xl mx-auto leading-relaxed">
                {{ __('frontend.layanan.hero_desc') }}
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
                <h3 class="font-serif-title text-2xl font-bold text-slate-900">{{ __('frontend.layanan.srv1_title') }}</h3>
                <p class="text-xs text-slate-600 font-light leading-relaxed">
                    {{ __('frontend.layanan.srv1_desc') }}
                </p>
            </div>

            <!-- Service 2 -->
            <div class="p-8 rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition duration-300 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-[#ca9e54] text-white flex items-center justify-center text-2xl">
                    <i class="ri-restaurant-line"></i>
                </div>
                <h3 class="font-serif-title text-2xl font-bold text-slate-900">{{ __('frontend.layanan.srv2_title') }}</h3>
                <p class="text-xs text-slate-600 font-light leading-relaxed">
                    {{ __('frontend.layanan.srv2_desc') }}
                </p>
            </div>

            <!-- Service 3 -->
            <div class="p-8 rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition duration-300 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-teal-600 text-white flex items-center justify-center text-2xl">
                    <i class="ri-heart-pulse-line"></i>
                </div>
                <h3 class="font-serif-title text-2xl font-bold text-slate-900">{{ __('frontend.layanan.srv3_title') }}</h3>
                <p class="text-xs text-slate-600 font-light leading-relaxed">
                    {{ __('frontend.layanan.srv3_desc') }}
                </p>
            </div>

            <!-- Service 4 -->
            <div class="p-8 rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition duration-300 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-amber-600 text-white flex items-center justify-center text-2xl">
                    <i class="ri-compass-line"></i>
                </div>
                <h3 class="font-serif-title text-2xl font-bold text-slate-900">{{ __('frontend.layanan.srv4_title') }}</h3>
                <p class="text-xs text-slate-600 font-light leading-relaxed">
                    {{ __('frontend.layanan.srv4_desc') }}
                </p>
            </div>

            <!-- Service 5 -->
            <div class="p-8 rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition duration-300 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-[#152c4e] text-white flex items-center justify-center text-2xl">
                    <i class="ri-sailboat-line"></i>
                </div>
                <h3 class="font-serif-title text-2xl font-bold text-slate-900">{{ __('frontend.layanan.srv5_title') }}</h3>
                <p class="text-xs text-slate-600 font-light leading-relaxed">
                    {{ __('frontend.layanan.srv5_desc') }}
                </p>
            </div>

            <!-- Service 6 -->
            <div class="p-8 rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition duration-300 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-[#ca9e54] text-white flex items-center justify-center text-2xl">
                    <i class="ri-shield-star-line"></i>
                </div>
                <h3 class="font-serif-title text-2xl font-bold text-slate-900">{{ __('frontend.layanan.srv6_title') }}</h3>
                <p class="text-xs text-slate-600 font-light leading-relaxed">
                    {{ __('frontend.layanan.srv6_desc') }}
                </p>
            </div>

        </div>
    </section>
@endsection
