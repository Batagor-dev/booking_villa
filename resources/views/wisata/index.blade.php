@extends('layouts.frontend.main')

@section('title', __('frontend.wisata.hero_title') . ' - Palma Luxury')

@section('content')
    <!-- HERO HEADER WISATA BALI -->
    <section class="relative pt-32 pb-20 px-4 sm:px-6 md:px-12 bg-gradient-to-r from-[#152c4e] via-[#1e3a66] to-[#0f1e36] text-white font-satoshi overflow-hidden">
        <div class="absolute inset-0 opacity-25 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1600&q=80" alt="Bali Tourist Spot" class="w-full h-full object-cover">
        </div>
        <div class="max-w-7xl mx-auto text-center relative z-10 space-y-4">
            <span class="text-[10px] sm:text-xs font-bold tracking-[0.25em] text-[#e5c382] uppercase block">
                {{ __('frontend.wisata.hero_tag') }}
            </span>
            <h1 class="font-serif-title text-3xl sm:text-5xl md:text-6xl font-normal leading-tight">
                {{ __('frontend.wisata.hero_title') }}
            </h1>
            <p class="text-xs sm:text-base text-slate-200 font-light max-w-2xl mx-auto leading-relaxed">
                {{ __('frontend.wisata.hero_desc') }}
            </p>
        </div>
    </section>

    <!-- SECTION: KAWASAN WISATA BALI -->
    <section class="py-14 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi">
        
        <!-- Regional Filter Tabs -->
        <div class="flex items-center justify-center gap-2 flex-wrap mb-12">
            <a href="{{ route('wisata.index') }}" 
               class="px-5 py-2.5 rounded-full text-xs font-bold transition shadow-md {{ empty($selectedRegion) ? 'bg-[#152c4e] text-white' : 'bg-white border border-slate-200 hover:border-[#ca9e54] text-slate-700 hover:bg-slate-50' }}">
                {{ __('frontend.wisata.all_regions') }}
            </a>
            @foreach($allDestinations ?? [] as $region)
                <a href="{{ route('wisata.index', ['region' => $region->slug]) }}" 
                   class="px-5 py-2.5 rounded-full text-xs font-semibold transition {{ $selectedRegion === $region->slug ? 'bg-[#152c4e] text-white font-bold shadow-md' : 'bg-white border border-slate-200 hover:border-[#ca9e54] text-slate-700 hover:bg-slate-50' }}">
                    {{ $region->name }}
                </a>
            @endforeach
        </div>

        <!-- Dynamic Tourist Spot Cards List -->
        @if(isset($destinations) && $destinations->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                @foreach($destinations as $dest)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                        <div class="relative h-64 overflow-hidden">
                            <img src="{{ asset('storage/' . $dest->image_path) }}" alt="{{ $dest->name }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                            @if(!empty($dest->formatted_tags) && count($dest->formatted_tags) > 0)
                                <div class="absolute top-4 left-4 flex flex-wrap gap-1.5">
                                    @foreach($dest->formatted_tags as $tag)
                                        <span class="bg-[#ca9e54] text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="font-serif-title text-2xl font-bold text-slate-900">{{ $dest->name }}</h3>
                                    <span class="text-xs font-bold text-[#ca9e54] flex items-center gap-1"><i class="ri-star-fill"></i> 4.9</span>
                                </div>
                                <p class="text-xs text-slate-500 mb-3 flex items-center gap-1">
                                    <i class="ri-map-pin-line text-slate-400"></i> {{ $dest->name }}, Bali
                                </p>
                                
                                @if(!empty($dest->attraction))
                                    <p class="text-xs text-slate-600 font-light leading-relaxed">
                                        {{ $dest->attraction }}
                                    </p>
                                @endif
                                
                                @if(!empty($dest->formatted_tags) && count($dest->formatted_tags) > 0)
                                    <div class="mt-4 pt-3 border-t border-slate-100">
                                        <span class="text-[11px] font-bold text-[#152c4e] block mb-1.5">{{ __('frontend.wisata.main_attractions') }}</span>
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach($dest->formatted_tags as $tag)
                                                <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-medium">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @php
                                $nearbyVilla = $dest->properties->first();
                            @endphp
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-xs font-semibold text-slate-500">{{ __('frontend.wisata.nearby_villa_recommend') }}</span>
                                @if($nearbyVilla)
                                    <a href="{{ route('villa.show', $nearbyVilla->slug) }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] flex items-center gap-1">
                                        {{ $nearbyVilla->name }} <i class="ri-arrow-right-line"></i>
                                    </a>
                                @else
                                    <a href="{{ route('villa.index', ['location' => $dest->name]) }}" class="text-xs font-bold text-[#152c4e] hover:text-[#ca9e54] flex items-center gap-1">
                                        {{ __('frontend.wisata.view_villas') }} <i class="ri-arrow-right-line"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-100 mb-16 shadow-xs p-8">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="ri-map-pin-line"></i>
                </div>
                <h3 class="font-serif-title text-xl font-bold text-slate-900 mb-2">{{ __('frontend.wisata.no_destinations') }}</h3>
                <a href="{{ route('wisata.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#152c4e] text-white text-xs font-bold transition mt-2">
                    {{ __('frontend.wisata.all_regions') }}
                </a>
            </div>
        @endif

        <!-- Travel Tips Banner -->
        <div class="bg-[#152c4e] text-white rounded-3xl p-8 sm:p-12 shadow-xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="space-y-4 max-w-xl">
                <span class="text-[10px] font-bold text-[#e5c382] uppercase tracking-widest block">{{ __('frontend.wisata.travel_tips_tag') }}</span>
                <h3 class="font-serif-title text-3xl font-bold">{{ __('frontend.wisata.travel_tips_title') }}</h3>
                <p class="text-white/80 font-light text-xs sm:text-sm leading-relaxed">
                    {{ __('frontend.wisata.travel_tips_desc') }}
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('layanan.index') }}" class="bg-[#ca9e54] hover:bg-[#b88c43] text-white font-bold px-8 py-4 rounded-full shadow-lg transition duration-300 text-xs uppercase tracking-wider block text-center">
                    {{ __('frontend.wisata.consult_btn') }}
                </a>
            </div>
        </div>

    </section>
@endsection
