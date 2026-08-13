@extends('layouts.frontend.main')

@section('title', ($property->name ?? 'Villa Sanctuary') . ' - ' . ($property->city ?? 'Seminyak') . ', ' . ($property->province ?? 'Bali') . ' | Palma Luxury')

@section('content')
    <!-- BREADCRUMB & HEADER -->
    <section class="pt-28 pb-6 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi">
        <div class="flex items-center justify-between gap-4 mb-4 flex-wrap">
            <!-- Breadcrumbs Trail -->
            <div class="flex items-center gap-2 text-xs sm:text-sm text-slate-500 font-medium">
                <a href="{{ route('home') }}" class="hover:text-[#ca9e54] transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('villa.index') }}" class="hover:text-[#ca9e54] transition-colors">Villa</a>
                <span>/</span>
                <span class="text-slate-700 font-semibold truncate">{{ $property->name ?? 'Villa Sanctuary' }}</span>
            </div>

            <!-- Elegant Minimalist Back Button (Pure Text) -->
            <a href="{{ route('villa.index') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 hover:text-[#ca9e54] transition-colors">
                <i class="ri-arrow-left-line text-sm sm:text-base"></i>
                <span>Kembali ke Daftar Villa</span>
            </a>
        </div>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2.5">
                    <span class="inline-flex items-center gap-1 bg-[#ca9e54]/10 text-[#b88c43] border border-[#ca9e54]/30 text-[10px] sm:text-xs font-semibold px-3 py-0.5 rounded-full uppercase tracking-widest">
                        <i class="ri-vip-crown-2-fill text-[#ca9e54]"></i> Superhost
                    </span>
                    @if($headerPromo = $property->active_promo_details)
                        <span class="inline-flex items-center gap-1 bg-[#ca9e54] text-white border border-[#ca9e54] text-[10px] sm:text-xs font-bold px-3 py-0.5 rounded-full uppercase tracking-wider shadow-xs">
                            <i class="ri-coupon-3-fill"></i> {{ $headerPromo['badge_text'] }}
                        </span>
                    @endif
                </div>
                <h1 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-slate-900 leading-tight">
                    {{ $property->name ?? 'Villa Sanctuary' }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 font-medium flex items-center gap-2 mt-2 flex-wrap">
                    <i class="ri-map-pin-2-fill text-[#ca9e54]"></i>
                    <span>{{ $property->address ?? 'Seminyak, Bali, Indonesia' }}</span>
                    <span>•</span>
                    <span class="flex items-center gap-1 font-bold text-slate-900">
                        <i class="ri-star-fill text-[#ca9e54]"></i> {{ number_format($property->rating ?? 4.95, 2) }}
                    </span>
                </p>
            </div>

            <!-- Action Buttons: Bagikan & Simpan -->
            <div class="flex items-center gap-2.5 flex-wrap sm:flex-nowrap">
                <button onclick="shareVilla()" class="px-4 py-2.5 rounded-full border border-slate-200 text-slate-700 hover:border-slate-900 text-xs font-bold flex items-center gap-2 transition-colors cursor-pointer shrink-0">
                    <i class="ri-share-line text-sm"></i> Bagikan
                </button>
                <button id="detail-fav-btn" onclick="toggleFav(this)" class="px-4 py-2.5 rounded-full border border-slate-200 text-slate-700 hover:text-red-500 hover:border-red-200 text-xs font-bold flex items-center gap-2 transition-colors cursor-pointer shrink-0">
                    <i class="ri-heart-line text-sm" id="fav-icon"></i> Simpan
                </button>
            </div>
        </div>
    </section>

    <!-- PHOTO GALLERY GRID SECTION -->
    <section class="px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi mb-12">
        <div class="relative group/gallery">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-2 sm:gap-3 overflow-hidden p-1.5">
                
                <!-- Main Featured Image -->
                <div class="col-span-2 md:col-span-2 md:row-span-2 h-52 sm:h-72 md:h-[460px] relative overflow-hidden rounded-2xl group/img cursor-pointer" onclick="openLightbox(0, 'slide')">
                    <img src="{{ $galleryList[0]['url'] ?? '' }}" alt="{{ $galleryList[0]['title'] ?? 'Utama' }}" class="w-full h-full object-cover group-hover/img:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/10 group-hover/img:bg-black/0 transition-colors"></div>
                </div>

                <!-- Side Gallery Images (Up to 6 side images) -->
                @foreach(array_slice($galleryList, 1, 6) as $index => $item)
                    @php $photoIndex = $index + 1; @endphp
                    @if($loop->last && count($galleryList) > 7)
                        <div class="col-span-1 h-32 sm:h-44 md:h-[224px] relative overflow-hidden rounded-2xl group/img cursor-pointer" onclick="openLightbox(6, 'grid')">
                            <img src="{{ $item['url'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover group-hover/img:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 rounded-2xl bg-slate-950/60 group-hover/img:bg-slate-950/75 backdrop-blur-xs transition-all duration-300 flex flex-col items-center justify-center text-white text-center p-2">
                                <i class="ri-grid-fill text-2xl sm:text-3xl text-[#ca9e54] mb-1 group-hover/img:scale-110 transition-transform"></i>
                                <span class="font-bold text-sm sm:text-base tracking-wide text-white drop-shadow-md">+{{ count($galleryList) - 7 }} Foto</span>
                                <span class="text-[10px] sm:text-xs font-medium text-slate-200 mt-0.5 drop-shadow-sm">Lihat Semua Foto</span>
                            </div>
                        </div>
                    @else
                        <div class="col-span-1 h-32 sm:h-44 md:h-[224px] relative overflow-hidden rounded-2xl group/img cursor-pointer" onclick="openLightbox({{ $photoIndex }}, 'slide')">
                            <img src="{{ $item['url'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover group-hover/img:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-black/10 group-hover/img:bg-black/0 transition-colors"></div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT SECTION -->
    <section class="px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi pb-24">
        <div class="space-y-12">
            
            <!-- Host Profile & Highlights -->
            <div class="flex items-center justify-between pb-8 border-b border-slate-200/80">
                <div class="space-y-1">
                    <h2 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">
                        Dipandu oleh Concierge Tim Palma VIP
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500">
                        {{ $property->capacity ?? 4 }} Tamu • {{ $property->bedrooms ?? 2 }} Kamar Tidur • {{ $property->type ?? 'Villa' }} Sanctuary
                    </p>
                </div>
                <div class="w-14 h-14 rounded-full bg-[#152c4e] text-[#e5c382] flex items-center justify-center font-bold text-xl shadow-md shrink-0 border border-[#ca9e54]/30">
                    <i class="ri-vip-crown-2-line"></i>
                </div>
            </div>

            <!-- Feature Highlights Badges -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5 pb-8 border-b border-slate-200/80">
                <div class="flex items-center gap-3.5 p-4 rounded-2xl bg-slate-50/70 border border-slate-200/60 transition-all hover:bg-slate-50">
                    <div class="w-10 h-10 rounded-xl bg-[#ca9e54]/10 text-[#ca9e54] flex items-center justify-center text-xl shrink-0">
                        <i class="ri-shield-star-line"></i>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900">Keamanan & Kebersihan Bintang 5</h4>
                        <p class="text-[11px] text-slate-500 font-light mt-0.5">Disterilkan sebelum kedatangan dengan butler 24 jam.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 p-4 rounded-2xl bg-slate-50/70 border border-slate-200/60 transition-all hover:bg-slate-50">
                    <div class="w-10 h-10 rounded-xl bg-[#152c4e]/10 text-[#152c4e] flex items-center justify-center text-xl shrink-0">
                        <i class="ri-cup-line"></i>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900">Sarapan Apung & Koki Pribadi</h4>
                        <p class="text-[11px] text-slate-500 font-light mt-0.5">Nikmati Floating Breakfast gratis hari pertama.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 p-4 rounded-2xl bg-slate-50/70 border border-slate-200/60 transition-all hover:bg-slate-50">
                    <div class="w-10 h-10 rounded-xl bg-[#ca9e54]/10 text-[#ca9e54] flex items-center justify-center text-xl shrink-0">
                        <i class="ri-price-tag-3-line"></i>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900">Garansi Harga Terbaik</h4>
                        <p class="text-[11px] text-slate-500 font-light mt-0.5">Pemesanan langsung tanpa biaya komisi.</p>
                    </div>
                </div>
            </div>

            <!-- MINIMALIST PRICE & LANJUT PESAN ROW (ALWAYS SIDE-BY-SIDE ON MOBILE & DESKTOP) -->
            @php $promoDetails = $property->active_promo_details; @endphp
            <div class="flex items-center justify-between gap-3 py-4 border-b border-slate-200/80">
                <!-- Left: Price & Strikethrough Discount Badge -->
                <div class="space-y-1 min-w-0">
                    @if($promoDetails)
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="line-through text-slate-400 text-xs sm:text-sm font-medium font-mono">
                                {{ format_rupiah($promoDetails['original_price']) }}
                            </span>
                            <span class="bg-[#ca9e54] text-white text-[10px] sm:text-xs font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow-xs">
                                {{ $promoDetails['badge_text'] }}
                            </span>
                        </div>
                        <div class="flex items-baseline gap-1.5 flex-wrap">
                            <x-ui.price :value="(float) $promoDetails['final_price']" class="text-xl sm:text-2xl md:text-3xl font-bold text-[#152c4e] font-serif-title tracking-tight" />
                            <span class="text-[11px] sm:text-xs text-slate-500 font-normal">/malam</span>
                        </div>
                        @if(!empty($promoDetails['code']))
                            <p class="text-[10px] sm:text-xs text-slate-600 font-medium flex items-center gap-1.5 pt-0.5">
                                <i class="ri-coupon-3-line text-[#ca9e54] text-sm"></i> Kode Promo: <strong class="font-mono bg-slate-100 text-slate-900 px-2 py-0.5 rounded border border-slate-200 uppercase font-bold text-xs">{{ $promoDetails['code'] }}</strong>
                            </p>
                        @endif
                    @else
                        <div class="flex items-baseline gap-1.5 flex-wrap">
                            <x-ui.price :value="(float) ($property->price ?? 4500000)" class="text-xl sm:text-2xl md:text-3xl font-bold text-[#152c4e] font-serif-title tracking-tight" />
                            <span class="text-[11px] sm:text-xs text-slate-500 font-normal">/malam</span>
                        </div>
                    @endif
                </div>

                <!-- Right: Clean Sharp Action Button (Always inline on mobile) -->
                <div class="shrink-0">
                    @php 
                        $bookingUrl = route('booking.create', [
                            'property' => $property->slug ?? '',
                            'promo' => $promoDetails['code'] ?? ''
                        ]); 
                    @endphp
                    @auth
                        <a href="{{ $bookingUrl }}" class="bg-[#152c4e] hover:bg-[#0f1d32] text-white font-bold px-4 sm:px-6 py-2.5 sm:py-3 rounded-full text-xs uppercase tracking-wider transition-all duration-300 shadow-md hover:shadow-lg inline-flex items-center gap-1.5 cursor-pointer whitespace-nowrap">
                            <span>Lanjut Pesan</span>
                            <i class="ri-arrow-right-line text-sm"></i>
                        </a>
                    @else
                        <button type="button" onclick="openRequireLoginModal('{{ $bookingUrl }}')" class="bg-[#152c4e] hover:bg-[#0f1d32] text-white font-bold px-4 sm:px-6 py-2.5 sm:py-3 rounded-full text-xs uppercase tracking-wider transition-all duration-300 shadow-md hover:shadow-lg inline-flex items-center gap-1.5 cursor-pointer whitespace-nowrap">
                            <span>Lanjut Pesan</span>
                            <i class="ri-arrow-right-line text-sm"></i>
                        </button>
                    @endauth
                </div>
            </div>

            <!-- Villa Description -->
            <div class="space-y-4 pb-8 border-b border-slate-200/80">
                <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">Tentang Villa Ini</h3>
                <div class="text-xs sm:text-sm text-slate-600 font-satoshi-medium leading-relaxed space-y-3">
                    {!! nl2br(e($property->description ?? '')) !!}
                </div>
            </div>

            <!-- Amenities Checklist -->
            <div class="space-y-6 pb-8 border-b border-slate-200/80">
                <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">Fasilitas Properti</h3>
                
                @if($property && $property->facilities && $property->facilities->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 text-xs sm:text-sm font-medium text-slate-800">
                        @foreach($property->facilities as $fac)
                            <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-slate-50/80 border border-slate-100">
                                <i class="{{ $fac->icon ?: 'ri-checkbox-circle-fill' }} text-lg text-[#ca9e54]"></i>
                                <span>{{ $fac->name }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 text-xs sm:text-sm font-medium text-slate-800">
                        <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-slate-50"><i class="ri-contrast-drop-line text-lg text-[#ca9e54]"></i><span>Infinity Pool</span></div>
                        <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-slate-50"><i class="ri-wifi-line text-lg text-[#ca9e54]"></i><span>WiFi High-Speed</span></div>
                        <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-slate-50"><i class="ri-user-star-line text-lg text-[#ca9e54]"></i><span>Butler Service</span></div>
                    </div>
                @endif
            </div>

            <!-- GOOGLE MAPS LOCATION SECTION -->
            <div class="space-y-4 pb-8 border-b border-slate-200/80">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold tracking-widest text-[#ca9e54] uppercase block">LOKASI & PETA VILLA</span>
                        <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">{{ $property->city ?? 'Seminyak' }}, {{ $property->province ?? 'Bali' }}</h3>
                    </div>
                </div>
                <p class="text-xs text-slate-500 flex items-center gap-1.5">
                    <i class="ri-map-pin-line text-slate-400"></i> {{ $property->address ?? 'Seminyak, Bali, Indonesia' }}
                </p>

                <!-- Embedded Interactive Google Maps Container -->
                <div class="w-full h-72 sm:h-96 overflow-hidden border border-slate-200/80 relative rounded-2xl [&_iframe]:w-full [&_iframe]:h-full [&_iframe]:border-0">
                    @if(!empty($property->map_link))
                        {!! $property->map_link !!}
                    @else
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.0261331776955!2d115.1541315!3d-8.6834164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd24752dfaa1585%3A0xe54d306b3a09e0eb!2sSeminyak%2C%20Kuta%2C%20Badung%20Regency%2C%20Bali!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" class="w-full h-full border-0" allowfullscreen="" loading="lazy"></iframe>
                    @endif
                </div>
            </div>

            <!-- Verified Reviews (Authentic Shopee Mobile UI Style) -->
            @php
                $allReviewItems = collect();
                if ($userReview) {
                    $allReviewItems->push($userReview);
                }
                if ($approvedReviews) {
                    foreach ($approvedReviews as $r) {
                        if (!$userReview || $r->id !== $userReview->id) {
                            $allReviewItems->push($r);
                        }
                    }
                }
                $cntAll = $allReviewItems->count();
                $cnt5 = $allReviewItems->where('rating', 5)->count();
                $cnt4 = $allReviewItems->where('rating', 4)->count();
                $cnt3 = $allReviewItems->where('rating', 3)->count();
                $cnt2 = $allReviewItems->where('rating', 2)->count();
                $cnt1 = $allReviewItems->where('rating', 1)->count();
                $cntReply = $allReviewItems->filter(fn($r) => !empty($r->admin_reply))->count();
            @endphp

            <div id="review-section" class="space-y-6 pb-8 border-b border-slate-200/80" x-data="{ reviewModalOpen: false, requireBookingModalOpen: false, selectedRating: {{ $userReview->rating ?? 5 }}, reviewComment: '{{ addslashes($userReview->comment ?? '') }}', activeFilter: 'all' }">
                
                <!-- Shopee Style Header & Rating Summary Bar -->
                <div class="bg-slate-50/90 rounded-3xl p-5 sm:p-6 border border-slate-100 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <span class="text-[10px] font-bold tracking-widest text-[#ca9e54] uppercase block">PENILAIAN VILLA</span>
                            <div class="flex items-baseline gap-2 mt-0.5">
                                <h3 class="font-serif-title text-2xl sm:text-3xl font-bold text-slate-900">{{ $propRating }}</h3>
                                <span class="text-xs text-slate-500 font-medium">dari 5.0</span>
                                <div class="flex text-[#ca9e54] text-sm ml-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="ri-star-fill"></i>
                                    @endfor
                                </div>
                                <span class="text-xs text-slate-400 font-medium ml-1">({{ $totalReviews }} Ulasan)</span>
                            </div>
                        </div>

                    </div>

                    <!-- Shopee Style Interactive Touch-Scroll Rating Filter Pills -->
                    <div class="relative pt-2 border-t border-slate-200/60">
                        <div class="flex items-center gap-2 overflow-x-auto overflow-y-hidden touch-pan-x scroll-smooth no-scrollbar text-xs py-1">
                            <button type="button" @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'bg-[#152c4e] text-white font-bold shadow-xs scale-[1.02]' : 'bg-white text-slate-700 font-medium border border-slate-200 hover:bg-slate-50'" class="px-3.5 py-1.5 rounded-xl transition-all whitespace-nowrap shrink-0 cursor-pointer">
                                Semua ({{ $cntAll }})
                            </button>
                            
                            <button type="button" @click="activeFilter = '5'" :class="activeFilter === '5' ? 'bg-[#152c4e] text-white font-bold shadow-xs scale-[1.02]' : 'bg-white text-slate-700 font-medium border border-slate-200 hover:bg-slate-50'" class="px-3.5 py-1.5 rounded-xl transition-all whitespace-nowrap shrink-0 flex items-center gap-1 cursor-pointer">
                                <span>5 Bintang ({{ $cnt5 }})</span>
                                <i class="ri-star-fill text-[#ca9e54] text-xs"></i>
                            </button>

                            <button type="button" @click="activeFilter = '4'" :class="activeFilter === '4' ? 'bg-[#152c4e] text-white font-bold shadow-xs scale-[1.02]' : 'bg-white text-slate-700 font-medium border border-slate-200 hover:bg-slate-50'" class="px-3.5 py-1.5 rounded-xl transition-all whitespace-nowrap shrink-0 flex items-center gap-1 cursor-pointer">
                                <span>4 Bintang ({{ $cnt4 }})</span>
                                <i class="ri-star-fill text-[#ca9e54] text-xs"></i>
                            </button>

                            <button type="button" @click="activeFilter = '3'" :class="activeFilter === '3' ? 'bg-[#152c4e] text-white font-bold shadow-xs scale-[1.02]' : 'bg-white text-slate-700 font-medium border border-slate-200 hover:bg-slate-50'" class="px-3.5 py-1.5 rounded-xl transition-all whitespace-nowrap shrink-0 flex items-center gap-1 cursor-pointer">
                                <span>3 Bintang ({{ $cnt3 }})</span>
                                <i class="ri-star-fill text-[#ca9e54] text-xs"></i>
                            </button>

                            <button type="button" @click="activeFilter = '2'" :class="activeFilter === '2' ? 'bg-[#152c4e] text-white font-bold shadow-xs scale-[1.02]' : 'bg-white text-slate-700 font-medium border border-slate-200 hover:bg-slate-50'" class="px-3.5 py-1.5 rounded-xl transition-all whitespace-nowrap shrink-0 flex items-center gap-1 cursor-pointer">
                                <span>2 Bintang ({{ $cnt2 }})</span>
                                <i class="ri-star-fill text-[#ca9e54] text-xs"></i>
                            </button>

                            <button type="button" @click="activeFilter = '1'" :class="activeFilter === '1' ? 'bg-[#152c4e] text-white font-bold shadow-xs scale-[1.02]' : 'bg-white text-slate-700 font-medium border border-slate-200 hover:bg-slate-50'" class="px-3.5 py-1.5 rounded-xl transition-all whitespace-nowrap shrink-0 flex items-center gap-1 cursor-pointer">
                                <span>1 Bintang ({{ $cnt1 }})</span>
                                <i class="ri-star-fill text-[#ca9e54] text-xs"></i>
                            </button>

                            <button type="button" @click="activeFilter = 'with_reply'" :class="activeFilter === 'with_reply' ? 'bg-[#152c4e] text-white font-bold shadow-xs scale-[1.02]' : 'bg-white text-slate-700 font-medium border border-slate-200 hover:bg-slate-50'" class="px-3.5 py-1.5 rounded-xl transition-all whitespace-nowrap shrink-0 cursor-pointer">
                                Dengan Balasan ({{ $cntReply }})
                            </button>

                            <!-- Subtle Scroll Cue Indicator for Mobile -->
                            <div class="shrink-0 flex items-center text-[10px] text-slate-400 font-medium gap-0.5 pl-1 pr-2 sm:hidden">
                                <i class="ri-arrow-right-s-line text-sm text-[#ca9e54] animate-pulse"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-3">
                        <i class="ri-checkbox-circle-fill text-emerald-500 text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium flex items-center gap-3">
                        <i class="ri-error-warning-fill text-rose-500 text-lg"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- SHOPEE MOBILE STYLE REVIEWS LIST -->
                <div class="space-y-6 pt-2">
                    
                    <!-- User's Own Review (Highlighted Shopee Mobile Card) -->
                    @if($userReview)
                        @php
                            $u = auth()->user();
                            $userAvatar = ($u && $u->foto && str_starts_with($u->foto, 'http'))
                                ? $u->foto
                                : (($u && $u->foto && (str_starts_with($u->foto, 'avatar-') || str_contains($u->foto, '.')))
                                    ? asset('assets/img/avatar/' . $u->foto)
                                    : asset('assets/img/avatar/avatar-1.jpg'));
                        @endphp
                        <div x-show="activeFilter === 'all' || activeFilter == '{{ $userReview->rating }}' || (activeFilter === 'with_reply' && {{ !empty($userReview->admin_reply) ? 'true' : 'false' }})" class="pb-6 border-b border-slate-100 space-y-3 relative">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $userAvatar }}" alt="{{ $u->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 shrink-0">
                                    <div class="space-y-0.5">
                                        <div class="flex items-center gap-2">
                                            <h5 class="text-xs font-bold text-slate-900">{{ $u->name }}</h5>
                                            <span class="px-2 py-0.5 rounded-md bg-[#152c4e] text-white text-[9px] font-bold uppercase tracking-wider">Ulasan Anda</span>
                                        </div>
                                        <div class="flex text-[#ca9e54] text-xs">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= $userReview->rating ? 'ri-star-fill' : 'ri-star-line text-slate-200' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] text-slate-400 font-medium">{{ $userReview->created_at->format('d M Y H:i') }}</span>
                                    
                                    <!-- 3-Dots Menu Dropdown -->
                                    <div class="relative" x-data="{ actionMenuOpen: false }">
                                        <button type="button" @click="actionMenuOpen = !actionMenuOpen" class="w-7 h-7 rounded-full hover:bg-slate-100 text-slate-500 hover:text-slate-900 flex items-center justify-center transition cursor-pointer" aria-label="Opsi Ulasan">
                                            <i class="ri-more-2-fill text-base"></i>
                                        </button>

                                        <div x-show="actionMenuOpen"
                                             @click.away="actionMenuOpen = false"
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="transform opacity-0 scale-95"
                                             x-transition:enter-end="transform opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="transform opacity-100 scale-100"
                                             x-transition:leave-end="transform opacity-0 scale-95"
                                             class="absolute right-0 mt-1 w-36 bg-white rounded-2xl shadow-xl border border-slate-100 p-1.5 z-30"
                                             style="display: none;">
                                            <form action="{{ route('reviews.destroy', $userReview->uuid) }}" method="POST" onsubmit="return confirm('Hapus ulasan Anda?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 transition cursor-pointer">
                                                    <i class="ri-delete-bin-line text-rose-500 text-sm"></i>
                                                    <span>Hapus Ulasan</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal">
                                {{ $userReview->comment }}
                            </p>

                            @if(!empty($userReview->admin_reply))
                                <!-- Shopee Style Seller Reply Box (Balasan Penjual) -->
                                <div class="p-3.5 rounded-2xl bg-slate-100/80 border border-slate-200/60 space-y-1 text-xs mt-2">
                                    <div class="font-bold text-slate-900 flex items-center gap-1.5 text-[11px]">
                                        <i class="ri-reply-fill text-[#152c4e]"></i> Balasan Pengelola Villa:
                                    </div>
                                    <p class="text-slate-600 leading-relaxed text-xs pl-5 font-light">{{ $userReview->admin_reply }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- All Other Approved Reviews (Shopee Mobile Style List) -->
                    @if($approvedReviews && $approvedReviews->count() > 0)
                        @foreach($approvedReviews as $rev)
                            @if($userReview && $rev->id === $userReview->id)
                                @continue
                            @endif
                            @php
                                $u = $rev->user;
                                $userAvatar = ($u && $u->foto && str_starts_with($u->foto, 'http'))
                                    ? $u->foto
                                    : (($u && $u->foto && (str_starts_with($u->foto, 'avatar-') || str_contains($u->foto, '.')))
                                        ? asset('assets/img/avatar/' . $u->foto)
                                        : asset('assets/img/avatar/avatar-1.jpg'));
                            @endphp
                            <div x-show="activeFilter === 'all' || activeFilter == '{{ $rev->rating }}' || (activeFilter === 'with_reply' && {{ !empty($rev->admin_reply) ? 'true' : 'false' }})" class="pb-6 border-b border-slate-100 space-y-3">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $userAvatar }}" alt="{{ $u->name ?? 'Tamu' }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 shrink-0">
                                        <div class="space-y-0.5">
                                            <h5 class="text-xs font-bold text-slate-900">{{ $u->name ?? 'Tamu Terverifikasi' }}</h5>
                                            <div class="flex text-[#ca9e54] text-xs">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="{{ $i <= $rev->rating ? 'ri-star-fill' : 'ri-star-line text-slate-200' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-medium">{{ $rev->created_at->format('d M Y H:i') }}</span>
                                </div>

                                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal">
                                    {{ $rev->comment }}
                                </p>

                                @if(!empty($rev->admin_reply))
                                    <!-- Shopee Style Seller Reply Box -->
                                    <div class="p-3.5 rounded-2xl bg-slate-100/80 border border-slate-200/60 space-y-1 text-xs mt-2">
                                        <div class="font-bold text-slate-900 flex items-center gap-1.5 text-[11px]">
                                            <i class="ri-reply-fill text-[#152c4e]"></i> Balasan Pengelola Villa:
                                        </div>
                                        <p class="text-slate-600 leading-relaxed text-xs pl-5 font-light">{{ $rev->admin_reply }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif

                    <!-- Empty Filter Results Message -->
                    <div x-show="(activeFilter === 'all' && {{ $cntAll }} === 0) || (activeFilter === '5' && {{ $cnt5 }} === 0) || (activeFilter === '4' && {{ $cnt4 }} === 0) || (activeFilter === '3' && {{ $cnt3 }} === 0) || (activeFilter === '2' && {{ $cnt2 }} === 0) || (activeFilter === '1' && {{ $cnt1 }} === 0) || (activeFilter === 'with_reply' && {{ $cntReply }} === 0)" class="p-8 rounded-3xl bg-slate-50 border border-slate-100 text-center space-y-2">
                        <i class="ri-chat-smile-2-line text-3xl text-slate-400"></i>
                        <h4 class="text-xs font-bold text-slate-700">Tidak Ada Ulasan Kategori Ini</h4>
                        <p class="text-[11px] text-slate-400">Belum ada ulasan yang sesuai dengan kategori filter yang Anda pilih.</p>
                    </div>
                </div>

                <!-- MODAL FOR INLINE REVIEW SUBMISSION (SHOPEE STYLE - NO TITLE, COMMENT ONLY) -->
                @auth
                    @if($userCanReview)
                        <div x-show="reviewModalOpen" 
                             x-transition 
                             class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4"
                             style="display: none;">
                            <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-2xl relative" @click.away="reviewModalOpen = false">
                                <button type="button" @click="reviewModalOpen = false" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600">
                                    <i class="ri-close-line text-2xl"></i>
                                </button>

                                <div>
                                    <span class="text-[10px] font-bold text-[#ca9e54] tracking-widest uppercase">ULASAN VILLA</span>
                                    <h3 class="font-serif-title text-2xl font-bold text-slate-900">{{ $property->name }}</h3>
                                    <p class="text-xs text-slate-500 mt-1">Tuliskan komentar & ulasan pengalaman menginap Anda di villa ini.</p>
                                </div>

                                <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="property_id" value="{{ $property->id }}">

                                    <!-- Rating Stars Selection -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Rating Bintang</label>
                                        <div class="flex items-center gap-2 text-2xl text-[#ca9e54]">
                                            <template x-for="star in 5">
                                                <button type="button" @click="selectedRating = star" class="focus:outline-none cursor-pointer">
                                                    <i :class="star <= selectedRating ? 'ri-star-fill' : 'ri-star-line text-slate-200'"></i>
                                                </button>
                                            </template>
                                            <span class="text-xs font-bold text-slate-700 ml-2" x-text="selectedRating + ' / 5 Bintang'"></span>
                                        </div>
                                        <input type="hidden" name="rating" :value="selectedRating">
                                    </div>

                                    <!-- Comment -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Komentar / Pengalaman Menginap</label>
                                        <textarea name="comment" rows="4" required x-model="reviewComment" placeholder="Tuliskan komentar pengalaman Anda menginap di villa ini..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium text-slate-800 focus:outline-none focus:border-[#152c4e]"></textarea>
                                    </div>

                                    <div class="flex items-center justify-end gap-3 pt-2">
                                        <button type="button" @click="reviewModalOpen = false" class="px-5 py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer">
                                            Batal
                                        </button>
                                        <button type="submit" class="px-6 py-2.5 rounded-full bg-[#ca9e54] hover:bg-[#b88c43] text-white text-xs font-bold transition shadow-md cursor-pointer">
                                            Kirim Ulasan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- MODAL REQUIRE BOOKING (WHEN USER CLICKS TULIS ULASAN BUT HAS NOT BOOKED THIS PROPERTY) -->
                        <div x-show="requireBookingModalOpen" 
                             x-transition 
                             class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4"
                             style="display: none;">
                            <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-6 shadow-2xl relative text-center" @click.away="requireBookingModalOpen = false">
                                <button type="button" @click="requireBookingModalOpen = false" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600">
                                    <i class="ri-close-line text-2xl"></i>
                                </button>

                                <div class="w-16 h-16 rounded-full bg-amber-50 text-[#ca9e54] border border-amber-200/80 flex items-center justify-center mx-auto text-3xl shadow-xs">
                                    <i class="ri-calendar-check-line"></i>
                                </div>

                                <div class="space-y-2">
                                    <span class="text-[10px] font-bold text-[#ca9e54] tracking-widest uppercase block">RESERVASI DIPERLUKAN</span>
                                    <h3 class="font-serif-title text-xl font-bold text-slate-900">Reservasi {{ $property->name }} Terlebih Dahulu</h3>
                                    <p class="text-xs text-slate-600 leading-relaxed font-light">
                                        Silakan lakukan pemesanan & reservasi untuk <strong class="text-slate-900 font-bold">{{ $property->name }}</strong> terlebih dahulu untuk dapat memberikan ulasan dan rating pengalaman Anda.
                                    </p>
                                </div>

                                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
                                    <button type="button" @click="requireBookingModalOpen = false" class="w-full sm:w-auto px-5 py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer">
                                        Tutup
                                    </button>
                                    <a href="{{ route('booking.create', ['property' => $property->slug]) }}" class="w-full sm:w-auto px-6 py-2.5 rounded-full bg-[#152c4e] hover:bg-[#0f1d32] text-white text-xs font-bold transition shadow-md flex items-center justify-center gap-1.5 cursor-pointer whitespace-nowrap">
                                        <span>Pesan {{ $property->name }} Sekarang</span>
                                        <i class="ri-arrow-right-line text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth

            </div>

            <!-- PERATURAN & KETENTUAN PEMESANAN (MINIMALIST LIST - NO CARDS) -->
            <div class="space-y-6 pt-4">
                <div class="border-b border-slate-200/80 pb-4">
                    <span class="text-[10px] font-bold tracking-widest text-[#ca9e54] uppercase block mb-1">INFORMASI & KEBIJAKAN {{ strtoupper($property->type ?? 'PROPERTI') }}</span>
                    <h3 class="font-serif-title text-2xl sm:text-3xl font-bold text-slate-900">Peraturan & Ketentuan Pemesanan</h3>
                    <p class="text-xs text-slate-500 mt-1">Harap pahami peraturan dan ketentuan sebelum melakukan pemesanan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 text-xs text-slate-600 pt-2">
                    @forelse($propertyRules as $rule)
                        <div class="flex items-start gap-3.5 group">
                            <span class="w-7 h-7 rounded-full bg-amber-50/80 border border-amber-200/60 text-[#ca9e54] flex items-center justify-center shrink-0 mt-0.5 group-hover:bg-[#ca9e54] group-hover:text-white transition-colors duration-300">
                                <i class="{{ $rule->icon ?: 'ri-shield-line' }} text-sm"></i>
                            </span>
                            <div class="space-y-0.5">
                                <h4 class="text-slate-900 font-bold text-sm tracking-tight">{{ $rule->title }}</h4>
                                <p class="text-slate-600 text-xs leading-relaxed font-light">{{ $rule->description }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex items-start gap-3.5 group">
                            <span class="w-7 h-7 rounded-full bg-amber-50/80 border border-amber-200/60 text-[#ca9e54] flex items-center justify-center shrink-0 mt-0.5">
                                <i class="ri-time-line text-sm"></i>
                            </span>
                            <div class="space-y-0.5">
                                <h4 class="text-slate-900 font-bold text-sm tracking-tight">Waktu Check-in & Check-out</h4>
                                <p class="text-slate-600 text-xs leading-relaxed font-light">Check-in mulai pukul <strong class="text-slate-900 font-semibold">14:00 WITA</strong>. Check-out maksimal pukul <strong class="text-slate-900 font-semibold">12:00 WITA</strong>.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </section>

        <!-- STEP-BY-STEP POV BOOKING MODAL -->
    <div id="pov-booking-modal" onclick="closePovModal()" class="fixed inset-0 bg-[#0c182b]/80 backdrop-blur-md z-[70] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl w-full max-w-xl overflow-hidden shadow-2xl border border-slate-100 font-satoshi transform scale-95 transition-transform duration-300 relative max-h-[90vh] flex flex-col" id="pov-modal-box" onclick="event.stopPropagation()">
            
            <!-- Modal Header -->
            <div class="p-5 sm:p-6 bg-[#152c4e] text-white flex items-center justify-between shrink-0">
                <div>
                    <span class="text-[9px] uppercase font-bold tracking-widest text-[#e5c382] block">FORM RESERVASI VILLA</span>
                    <h3 class="font-serif-title text-xl font-bold">Konfirmasi Pemesanan & Pembayaran</h3>
                </div>
                <button type="button" onclick="closePovModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer">
                    <i class="ri-close-line text-lg"></i>
                </button>
            </div>

            <!-- Modal Body (Form Submission) -->
            <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 overflow-y-auto space-y-5 flex-1" id="pov-modal-form">
                @csrf
                <input type="hidden" name="property_id" value="{{ $property->id ?? 1 }}">
                <input type="hidden" name="check_in" id="modal-checkin" value="2026-08-15">
                <input type="hidden" name="check_out" id="modal-checkout" value="2026-08-18">

                <!-- Booking Summary Banner -->
                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 flex items-center justify-between text-xs font-satoshi-medium">
                    <div>
                        <span class="text-slate-500 block text-[10px] uppercase font-bold tracking-wider">Properti:</span>
                        <strong class="text-slate-900 font-bold">{{ $property->name }}</strong>
                    </div>
                    <div class="text-right">
                        <span class="text-slate-500 block text-[10px] uppercase font-bold tracking-wider">Durasi:</span>
                        <span class="text-[#ca9e54] font-bold" id="modal-summary-nights">3 Malam</span>
                    </div>
                </div>

                <!-- Guest Information -->
                <div class="space-y-3 pt-1">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">
                            NAMA LENGKAP TAMU <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="guest_name" id="pov-name" value="{{ old('guest_name', auth()->user()->name ?? '') }}" placeholder="e.g. Budi Santoso" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-semibold text-slate-900 focus:outline-none focus:border-[#ca9e54]" required>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">
                                EMAIL KONFIRMASI <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="guest_email" id="pov-email" value="{{ old('guest_email', auth()->user()->email ?? '') }}" placeholder="budi@example.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-semibold text-slate-900 focus:outline-none focus:border-[#ca9e54]" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">
                                NOMOR WHATSAPP <span class="text-rose-500">*</span>
                            </label>
                            <input type="tel" name="guest_phone" id="pov-phone" value="{{ old('guest_phone', '') }}" placeholder="+62 812 3456 7890" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-semibold text-slate-900 focus:outline-none focus:border-[#ca9e54]" required>
                        </div>
                    </div>

                    <!-- Payment Method Select -->
                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">
                            METODE PEMBAYARAN <span class="text-rose-500">*</span>
                        </label>
                        <select name="payment_method_id" id="pov-payment" onchange="updatePaymentInstructions(this)" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-bold text-slate-900 focus:outline-none focus:border-[#ca9e54] cursor-pointer" required>
                            @if(isset($paymentMethods) && $paymentMethods->count() > 0)
                                @foreach($paymentMethods as $pm)
                                    <option value="{{ $pm->id }}" 
                                            data-name="{{ $pm->name }}" 
                                            data-type="{{ strtoupper($pm->type) }}"
                                            data-account-number="{{ $pm->account_number ?? '' }}"
                                            data-account-name="{{ $pm->account_name ?? '' }}"
                                            data-note="{{ $pm->note ?? '' }}"
                                            data-qris="{{ $pm->image_qris ? asset('storage/'.$pm->image_qris) : '' }}">
                                        {{ $pm->name }} ({{ strtoupper($pm->type) }})
                                    </option>
                                @endforeach
                            @else
                                <option value="1" data-name="Bank Transfer BCA" data-type="BANK_TRANSFER" data-account-number="8830123999" data-account-name="PT Villa Management">Bank Transfer BCA</option>
                            @endif
                        </select>
                    </div>

                    <!-- Instruction Box for Selected Payment (MINIMALIST SLATE THEME) -->
                    <div id="payment-instruction-box" class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 space-y-2">
                        <div class="font-bold flex items-center justify-between">
                            <span id="pm-info-name" class="text-slate-900">Transfer Bank</span>
                            <span class="text-[10px] bg-[#152c4e] text-white font-extrabold px-2.5 py-0.5 rounded-full" id="pm-info-type">BANK_TRANSFER</span>
                        </div>

                        <!-- MINIMALIST CASH DP NOTICE ALERT BOX -->
                        <div id="pm-info-cash-notice" class="p-2.5 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 text-[11px] hidden flex items-start gap-2">
                            <i class="ri-information-fill text-[#152c4e] text-sm shrink-0 mt-0.5"></i>
                            <span>Catatan: Pembayaran <strong>Cash / Tunai</strong> wajib melunasi <strong>DP (Down Payment) via transfer bank</strong> terlebih dahulu ke rekening di bawah untuk konfirmasi reservasi.</span>
                        </div>

                        <!-- ACCOUNT NUMBER (HIDDEN FOR QRIS) -->
                        <div id="pm-info-acc-num-wrapper" class="font-mono text-slate-700 pt-1">
                            <span class="text-[10px] font-bold text-slate-500 uppercase block">No. Rekening / VA:</span>
                            <strong id="pm-info-acc-num" class="text-slate-900 text-sm font-bold select-all">8830123999</strong>
                        </div>

                        <!-- RECIPIENT / ACCOUNT HOLDER NAME -->
                        <div id="pm-info-acc-name-wrapper" class="text-[11px] text-slate-600">
                            <span id="pm-info-acc-name-label" class="text-[10px] font-bold text-slate-500 uppercase block mb-0.5">Atas Nama:</span>
                            <span id="pm-info-acc-name" class="font-bold text-slate-900">PT Villa Management</span>
                        </div>

                        <!-- QRIS IMAGE CONTAINER -->
                        <div id="pm-qris-container" class="hidden pt-2 text-center">
                            <span class="text-[10px] font-bold text-slate-500 uppercase block mb-1">Scan QRIS Untuk Pembayaran</span>
                            <img id="pm-qris-img" src="" class="w-36 h-36 mx-auto rounded-lg border border-slate-200 bg-white p-1 shadow-xs">
                        </div>

                        <!-- NOTE CONTAINER -->
                        <div id="pm-info-note-container" class="text-[11px] text-slate-500 italic hidden pt-1 border-t border-slate-200/60">
                            <span id="pm-info-note"></span>
                        </div>
                    </div>

                    <!-- Upload Bukti Payment File Input -->
                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">
                            UNGGAH BUKTI PEMBAYARAN <span class="text-rose-500">*</span>
                        </label>
                        <input type="file" name="bukti_payment" id="bukti_payment" accept="image/*" required onchange="previewBuktiPayment(event)" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs font-semibold text-slate-900 focus:outline-none focus:border-[#ca9e54] file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#152c4e] file:text-white hover:file:bg-[#ca9e54] cursor-pointer">
                        
                        <div id="bukti-preview-box" class="mt-2 hidden">
                            <span class="text-[10px] text-slate-400 font-bold block mb-1">Preview Bukti Upload:</span>
                            <img id="bukti-preview-img" src="" class="h-28 rounded-xl object-cover border border-slate-200 shadow-sm">
                        </div>
                    </div>

                    <!-- Notes Optional -->
                    <x-ui.textarea 
                        name="notes" 
                        label="CATATAN KHUSUS (OPTIONAL)" 
                        placeholder="Catatan khusus atau permintaan check-in..."
                        rows="2"
                    />

                    <!-- PROPERTY RULES AGREEMENT CHECKBOX IN MODAL -->
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80 text-[11px] text-slate-600 flex items-start gap-2 mt-2">
                        <input type="checkbox" id="modal_agree_rules" name="agree_rules" required class="mt-0.5 rounded border-slate-300 text-[#152c4e] focus:ring-[#ca9e54] cursor-pointer shrink-0">
                        <label for="modal_agree_rules" class="cursor-pointer leading-snug">
                            Saya telah membaca dan menyetujui <strong class="text-slate-900 font-bold">Peraturan & Ketentuan {{ $property->type ?? 'Villa' }}</strong>.
                        </label>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#152c4e] hover:bg-[#0f1e36] text-white font-bold py-3.5 rounded-xl text-xs uppercase tracking-wider transition-colors mt-4 cursor-pointer flex items-center justify-center gap-2">
                    <i class="ri-shield-check-fill text-base text-[#e5c382]"></i>
                    <span>Konfirmasi Reservasi & Unggah Bukti</span>
                </button>
            </form>

                <!-- STEP 2: SUCCESS CHECKOUT (POV SIMULATION RESULT - VIP BOARDING PASS CARD) -->
                <div id="pov-step-2" class="space-y-5 hidden text-center py-2">
                    <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-3xl shadow-md">
                        <i class="ri-checkbox-circle-fill"></i>
                    </div>

                    <div class="space-y-1">
                        <span class="text-[9px] uppercase font-bold tracking-widest text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">RESERVASI VVIP TERKONFIRMASI LUNAS</span>
                        <h4 class="font-serif-title text-xl font-bold text-slate-900 pt-1">E-Voucher Tiket Resmi Terbit!</h4>
                    </div>

                    <!-- Luxury Boarding Pass Ticket Preview Card -->
                    <div class="bg-[#152c4e] text-white rounded-3xl p-5 border border-slate-800 text-left space-y-4 shadow-xl relative overflow-hidden">
                        <!-- Background Pattern Accent -->
                        <div class="absolute -right-10 -bottom-10 w-32 h-32 rounded-full bg-[#ca9e54]/10 blur-2xl pointer-events-none"></div>

                        <!-- Ticket Header -->
                        <div class="flex items-center justify-between border-b border-white/10 pb-3">
                            <div>
                                <span class="text-[9px] text-[#e5c382] font-bold uppercase tracking-widest block">PALMA LUXURY TICKET</span>
                                <h5 class="font-serif-title font-bold text-sm text-white">Villa Azure Ocean Sanctuary</h5>
                            </div>
                            <div class="text-right">
                                <span class="text-[9px] text-white/50 block font-mono">KODE VOUCHER</span>
                                <strong class="font-mono text-[#e5c382] text-xs font-bold" id="pov-voucher-code">#PLM-88942</strong>
                            </div>
                        </div>

                        <!-- Ticket Body Details -->
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div>
                                <span class="text-white/50 block text-[9px] font-medium">NAMA TAMU VVIP:</span>
                                <strong class="text-white font-bold" id="res-name">Budi Santoso</strong>
                            </div>
                            <div>
                                <span class="text-white/50 block text-[9px] font-medium">DURASI MENGINAP:</span>
                                <strong class="text-white font-bold">3 Malam (15-18 Ags 2026)</strong>
                            </div>
                            <div>
                                <span class="text-white/50 block text-[9px] font-medium">TIPE PROPERTI:</span>
                                <span class="text-slate-300 font-medium">5-Bedroom Beachfront Suite</span>
                            </div>
                            <div>
                                <span class="text-white/50 block text-[9px] font-medium">STATUS PEMBAYARAN:</span>
                                <span class="bg-emerald-500/20 text-emerald-300 border border-emerald-400/40 text-[9px] font-bold px-2 py-0.5 rounded-full inline-block mt-0.5">LUNAS / VERIFIED</span>
                            </div>
                        </div>

                        <!-- Dashed Divider & QR Code Bar -->
                        <div class="pt-3 border-t border-dashed border-white/20 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="ri-qr-code-line text-3xl text-[#e5c382]"></i>
                                <div class="text-[10px]">
                                    <span class="text-white/80 font-bold block">Tunjukkan QR ke Concierge</span>
                                    <span class="text-white/50 text-[9px]">Layanan Butler 24/7 Siap Menyambut</span>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-[#e5c382] bg-white/10 px-2.5 py-1 rounded-lg">PALMA VIP PASS</span>
                        </div>
                    </div>

                    <div class="space-y-2 pt-1">
                        <button onclick="simulatedDownloadPdf()" class="w-full bg-[#ca9e54] hover:bg-[#b88c43] text-white font-bold py-3.5 rounded-2xl text-xs uppercase tracking-wider transition-colors shadow-md flex items-center justify-center gap-2 cursor-pointer">
                            <i class="ri-file-download-line text-base"></i>
                            <span>Unduh E-Voucher PDF Resmi</span>
                        </button>

                        <button onclick="closePovModal()" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3.5 rounded-2xl text-xs uppercase tracking-wider transition-colors cursor-pointer">
                            Selesai & Kembalikan ke Detail
                        </button>
                    </div>
                </div>

            </div>
        </div>
      <!-- FULLSCREEN INTERACTIVE LIGHTBOX GALLERY MODAL (PURE IMAGES & GRID LIST) -->
    <div id="gallery-lightbox-modal" class="fixed inset-0 z-[100] flex flex-col justify-between p-3 sm:p-6 hidden opacity-0 transition-opacity duration-300 select-none">
        
        <!-- Dark Backdrop Layer (Clicking backdrop closes lightbox) -->
        <div class="absolute inset-0 bg-[#0c182b]/95 backdrop-blur-2xl" onclick="closeLightbox()"></div>
        
        <!-- Lightbox Content Wrapper -->
        <div class="relative z-10 flex flex-col justify-between w-full h-full max-w-7xl mx-auto pointer-events-auto">
            
            <!-- Lightbox Top Control Bar -->
            <div class="flex items-center justify-between text-white pb-3 border-b border-white/10 shrink-0">
                <div class="flex items-center gap-3">
                    <span class="text-[#ca9e54] font-bold text-xs sm:text-sm uppercase tracking-wider font-mono" id="lightbox-counter-text">1 / {{ count($galleryList) }}</span>
                    
                    <!-- View Mode Toggle Buttons -->
                    <div class="flex items-center bg-white/10 p-1 rounded-full text-xs border border-white/10">
                        <button type="button" id="lightbox-btn-slide" onclick="switchLightboxMode('slide')" class="px-3 py-1 rounded-full transition-all cursor-pointer flex items-center gap-1.5 bg-[#ca9e54] text-slate-950 font-bold shadow-sm">
                            <i class="ri-slideshow-3-line text-sm"></i>
                            <span class="hidden sm:inline">Slide</span>
                        </button>
                        <button type="button" id="lightbox-btn-grid" onclick="switchLightboxMode('grid')" class="px-3 py-1 rounded-full transition-all cursor-pointer flex items-center gap-1.5 bg-white/10 text-white hover:bg-white/20">
                            <i class="ri-grid-fill text-sm text-[#ca9e54]"></i>
                            <span>Grid List ({{ count($galleryList) }})</span>
                        </button>
                    </div>
                </div>

                <button type="button" onclick="closeLightbox()" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer text-lg" title="Tutup (ESC)">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <!-- 1. SLIDESHOW VIEW CONTAINER -->
            <div id="lightbox-slide-view" class="flex-1 flex flex-col justify-between overflow-hidden my-auto">
                <!-- Main Display Container (Image + Floating Arrows) -->
                <div class="relative flex-1 flex items-center justify-center my-auto py-2">
                    
                    <!-- Floating Left Arrow Button -->
                    <button type="button" onclick="prevPhoto()" class="absolute left-2 sm:left-12 z-30 w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-slate-900/80 hover:bg-[#ca9e54] text-white hover:text-slate-950 flex items-center justify-center transition-all duration-300 shadow-2xl backdrop-blur-md cursor-pointer border border-white/20 hover:border-transparent active:scale-95">
                        <i class="ri-arrow-left-s-line text-2xl sm:text-3xl"></i>
                    </button>

                    <!-- Active Photo Frame -->
                    <div class="relative max-w-5xl max-h-[70vh] flex items-center justify-center">
                        <img id="lightbox-main-img" src="" alt="Gallery Active Photo" class="max-w-full max-h-[68vh] object-contain rounded-2xl shadow-2xl transition-all duration-300">
                    </div>

                    <!-- Floating Right Arrow Button -->
                    <button type="button" onclick="nextPhoto()" class="absolute right-2 sm:right-12 z-30 w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-slate-900/80 hover:bg-[#ca9e54] text-white hover:text-slate-950 flex items-center justify-center transition-all duration-300 shadow-2xl backdrop-blur-md cursor-pointer border border-white/20 hover:border-transparent active:scale-95">
                        <i class="ri-arrow-right-s-line text-2xl sm:text-3xl"></i>
                    </button>

                </div>

                <!-- Bottom Thumbnail Strip -->
                <div class="border-t border-white/10 pt-3 max-w-5xl mx-auto w-full shrink-0">
                    <div class="flex items-center justify-center gap-2 overflow-x-auto py-1 no-scrollbar" id="lightbox-thumbnails">
                        <!-- JS Rendered Thumbnail Items -->
                    </div>
                </div>
            </div>

            <!-- 2. GRID LIST VIEW CONTAINER (ALL PHOTOS DISPLAYED IN GRID) -->
            <div id="lightbox-grid-view" class="flex-1 overflow-y-auto py-4 max-w-6xl mx-auto w-full hidden">
                <div class="mb-4 flex items-center justify-between px-2">
                    <div>
                        <h3 class="text-white font-bold text-base sm:text-lg flex items-center gap-2 font-serif-title">
                            <i class="ri-gallery-fill text-[#ca9e54]"></i>
                            <span>Semua Foto Properti</span>
                        </h3>
                        <p class="text-xs text-white/60 font-light mt-0.5">Menampilkan seluruh foto ({{ count($galleryList) }} foto). Klik foto mana saja untuk memperbesar.</p>
                    </div>
                    <span class="text-xs text-[#ca9e54] bg-[#ca9e54]/10 border border-[#ca9e54]/30 px-3 py-1 rounded-full font-mono font-bold">
                        Total {{ count($galleryList) }} Foto
                    </span>
                </div>

                <!-- All Photos Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4 p-2" id="lightbox-grid-container">
                    <!-- JS Rendered Grid Items -->
                </div>
            </div>

        </div>

    </div>    </div>

    <!-- INTERACTIVE ALL REVIEWS MODAL -->
    <div id="all-reviews-modal" onclick="closeReviewsModal()" class="fixed inset-0 bg-[#0c182b]/80 backdrop-blur-md z-[80] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl w-full max-w-3xl overflow-hidden shadow-2xl border border-slate-100 font-satoshi transform scale-95 transition-transform duration-300 relative max-h-[90vh] flex flex-col" id="reviews-modal-box" onclick="event.stopPropagation()">
            
            <!-- Modal Header -->
            <div class="p-5 sm:p-6 bg-[#152c4e] text-white flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center text-[#e5c382]">
                        <i class="ri-star-fill text-xl"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-lg">4.95 / 5.0</span>
                            <span class="text-xs text-[#e5c382] font-semibold">• 142 Ulasan Terverifikasi</span>
                        </div>
                        <p class="text-xs text-white/70 font-light">Ulasan otentik dari tamu yang telah menginap di Villa Azure</p>
                    </div>
                </div>
                <button onclick="closeReviewsModal()" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer text-lg">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <!-- Modal Rating Sub-Breakdown -->
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200/70 grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs shrink-0">
                <div class="flex flex-col">
                    <span class="text-slate-500 text-[10px]">Kebersihan</span>
                    <span class="font-bold text-slate-900 flex items-center gap-1">4.9 <i class="ri-star-fill text-[#ca9e54] text-[10px]"></i></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-slate-500 text-[10px]">Pelayanan Butler</span>
                    <span class="font-bold text-slate-900 flex items-center gap-1">5.0 <i class="ri-star-fill text-[#ca9e54] text-[10px]"></i></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-slate-500 text-[10px]">Akses Lokasi</span>
                    <span class="font-bold text-slate-900 flex items-center gap-1">4.9 <i class="ri-star-fill text-[#ca9e54] text-[10px]"></i></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-slate-500 text-[10px]">Fasilitas Luxe</span>
                    <span class="font-bold text-slate-900 flex items-center gap-1">4.8 <i class="ri-star-fill text-[#ca9e54] text-[10px]"></i></span>
                </div>
            </div>

            <!-- Search & Reviews List -->
            <div class="p-6 sm:p-8 overflow-y-auto space-y-6 flex-1">
                
                <!-- Live Search Bar -->
                <div class="relative">
                    <i class="ri-search-line absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                    <input type="text" id="review-search-input" onkeyup="filterGuestReviews()" placeholder="Cari ulasan tamu (misal: kolam, koki, kebersihan, sunset)..." class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs focus:outline-none focus:border-[#152c4e] transition-colors">
                </div>

                <!-- Reviews Feed Container -->
                <div class="space-y-4" id="reviews-feed-container">
                    <!-- Rendered via JS -->
                </div>
            </div>

            <!-- Modal Footer: Submit Review Action -->
            <div class="p-4 sm:p-5 bg-slate-50 border-t border-slate-200/80 flex items-center justify-between text-xs shrink-0">
                <span class="text-slate-500">Pernah menginap di sini? Berikan pengalaman Anda</span>
                <button onclick="alert('Formulir Ulasan Tamu: Kirimkan penilaian bintang dan ulasan Anda untuk Villa Azure!')" class="bg-[#152c4e] hover:bg-[#0f1d32] text-white font-bold px-4 py-2.5 rounded-xl transition-colors cursor-pointer flex items-center gap-1.5 shadow-md">
                    <i class="ri-edit-line"></i> Tulis Ulasan
                </button>
            </div>

        </di    <!-- ULTRA-MINIMALIST FLOATING MOBILE BOOKING BAR (ALWAYS VISIBLE AT TOP Z-INDEX 95) -->
    <div id="mobile-sticky-booking-bar" class="fixed bottom-4 inset-x-3 sm:inset-x-6 z-[95] lg:hidden font-satoshi pointer-events-auto transition-all duration-300">
        <div class="bg-[#152c4e]/95 backdrop-blur-2xl text-white rounded-full p-2.5 pl-5 shadow-[0_12px_35px_rgba(0,0,0,0.3)] border border-white/15 flex items-center justify-between gap-3 max-w-lg mx-auto">
            
            <!-- Left Info: Minimalist Price & Rating -->
            <div class="flex items-center gap-2">
                <x-ui.price :value="(float) ($property->price ?? 4500000)" class="font-serif-title font-bold text-lg sm:text-xl text-white" />
                <span class="text-[10px] text-white/60 font-light">/ malam</span>
                <span class="text-white/30 text-xs">•</span>
                <div class="flex items-center gap-1 text-[11px] text-[#e5c382] font-semibold">
                    <i class="ri-star-fill text-[11px]"></i> {{ number_format($property->rating ?? 4.95, 2) }}
                </div>
            </div>

            <!-- Right CTA Button: Minimalist Gold Button -->
            @auth
                <a href="{{ route('booking.create', ['property' => $property->slug ?? '']) }}" class="bg-[#ca9e54] hover:bg-[#b88c43] text-slate-950 font-bold px-5 py-2.5 rounded-full text-xs transition-transform active:scale-95 cursor-pointer shadow-lg flex items-center gap-1.5 shrink-0">
                    <span>Pesan Sekarang</span>
                    <i class="ri-arrow-right-line text-sm"></i>
                </a>
            @else
                <button onclick="openRequireLoginModal('{{ route('booking.create', ['property' => $property->slug ?? '']) }}')" class="bg-[#ca9e54] hover:bg-[#b88c43] text-slate-950 font-bold px-5 py-2.5 rounded-full text-xs transition-transform active:scale-95 cursor-pointer shadow-lg flex items-center gap-1.5 shrink-0">
                    <span>Pesan Sekarang</span>
                    <i class="ri-arrow-right-line text-sm"></i>
                </button>
            @endauth
        </div>
    </div>

@push('scripts')
<script>
    // Villa Gallery Dataset (Dynamic from PHP)
    const villaGalleryPhotos = {!! json_encode($galleryList) !!};
    const basePricePerNight = {{ (float) ($property->price ?? 4500000) }};

    // Set Default Booking Dates (Tomorrow to 3 days after)
    document.addEventListener('DOMContentLoaded', function() {
        const checkinInput = document.getElementById('book-checkin');
        const checkoutInput = document.getElementById('book-checkout');

        if (checkinInput && checkoutInput) {
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);

            const dayAfter = new Date(today);
            dayAfter.setDate(dayAfter.getDate() + 3);

            const toYmd = d => d.toISOString().split('T')[0];

            if (!checkinInput.value) checkinInput.value = toYmd(tomorrow);
            if (!checkoutInput.value) checkoutInput.value = toYmd(dayAfter);
        }
    });

    let currentPhotoIndex = 0;
    let lightboxViewMode = 'slide';

    function openLightbox(index = 0, mode = 'slide') {
        const modal = document.getElementById('gallery-lightbox-modal');
        if (!modal) return;
        currentPhotoIndex = index % villaGalleryPhotos.length;
        lightboxViewMode = mode;
        
        updateLightboxView();

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
        });
        document.body.classList.add('overflow-hidden');
    }

    function switchLightboxMode(mode, index = null) {
        if (index !== null) {
            currentPhotoIndex = index % villaGalleryPhotos.length;
        }
        lightboxViewMode = mode;
        updateLightboxView();
    }

    function updateLightboxView() {
        const slideView = document.getElementById('lightbox-slide-view');
        const gridView = document.getElementById('lightbox-grid-view');
        const btnSlide = document.getElementById('lightbox-btn-slide');
        const btnGrid = document.getElementById('lightbox-btn-grid');

        if (lightboxViewMode === 'grid') {
            if (slideView) slideView.classList.add('hidden');
            if (gridView) gridView.classList.remove('hidden');
            
            if (btnSlide) {
                btnSlide.className = 'px-3 py-1 rounded-full transition-all cursor-pointer flex items-center gap-1.5 bg-white/10 text-white hover:bg-white/20';
            }
            if (btnGrid) {
                btnGrid.className = 'px-3 py-1 rounded-full transition-all cursor-pointer flex items-center gap-1.5 bg-[#ca9e54] text-slate-950 font-bold shadow-sm';
            }
            renderLightboxGrid();
        } else {
            if (gridView) gridView.classList.add('hidden');
            if (slideView) slideView.classList.remove('hidden');
            
            if (btnGrid) {
                btnGrid.className = 'px-3 py-1 rounded-full transition-all cursor-pointer flex items-center gap-1.5 bg-white/10 text-white hover:bg-white/20';
            }
            if (btnSlide) {
                btnSlide.className = 'px-3 py-1 rounded-full transition-all cursor-pointer flex items-center gap-1.5 bg-[#ca9e54] text-slate-950 font-bold shadow-sm';
            }
            updateLightboxContent();
        }
    }

    function renderLightboxGrid() {
        const gridContainer = document.getElementById('lightbox-grid-container');
        if (!gridContainer) return;
        
        gridContainer.innerHTML = villaGalleryPhotos.map((p, idx) => `
            <div onclick="switchLightboxMode('slide', ${idx})" class="group relative rounded-2xl overflow-hidden cursor-pointer aspect-video bg-slate-900 border-2 transition-all duration-300 ${idx === currentPhotoIndex ? 'border-[#ca9e54] ring-2 ring-[#ca9e54]/50 scale-[1.02]' : 'border-white/10 hover:border-white/50 hover:scale-[1.02]'}">
                <img src="${p.url}" alt="${p.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-70 group-hover:opacity-90 transition-opacity"></div>
                <div class="absolute bottom-2.5 left-3 right-3 flex items-center justify-between text-white">
                    <span class="text-[11px] font-bold tracking-wide flex items-center gap-1 truncate">
                        <i class="ri-image-line text-[#ca9e54]"></i> ${p.title || ('Foto ' + (idx + 1))}
                    </span>
                    ${idx === currentPhotoIndex ? '<span class="text-[9px] bg-[#ca9e54] text-slate-950 font-bold px-2 py-0.5 rounded-full shrink-0">Aktif</span>' : ''}
                </div>
            </div>
        `).join('');
    }

    function closeLightbox() {
        const modal = document.getElementById('gallery-lightbox-modal');
        if (!modal) return;
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    function nextPhoto() {
        currentPhotoIndex = (currentPhotoIndex + 1) % villaGalleryPhotos.length;
        updateLightboxContent();
    }

    function prevPhoto() {
        currentPhotoIndex = (currentPhotoIndex - 1 + villaGalleryPhotos.length) % villaGalleryPhotos.length;
        updateLightboxContent();
    }

    function updateLightboxContent() {
        const photo = villaGalleryPhotos[currentPhotoIndex];
        const mainImg = document.getElementById('lightbox-main-img');
        const counterText = document.getElementById('lightbox-counter-text');
        const thumbContainer = document.getElementById('lightbox-thumbnails');

        if (mainImg && photo) {
            mainImg.style.opacity = '0';
            setTimeout(() => {
                mainImg.src = photo.url;
                mainImg.alt = photo.title;
                mainImg.style.opacity = '1';
            }, 100);
        }

        if (counterText) counterText.innerText = `${currentPhotoIndex + 1} / ${villaGalleryPhotos.length}`;

        if (thumbContainer) {
            thumbContainer.innerHTML = villaGalleryPhotos.map((p, idx) => `
                <button onclick="currentPhotoIndex=${idx}; updateLightboxContent();" class="w-12 h-9 sm:w-16 sm:h-11 rounded-lg overflow-hidden border-2 transition-all duration-200 shrink-0 cursor-pointer ${idx === currentPhotoIndex ? 'border-[#ca9e54] scale-105 opacity-100 shadow-lg' : 'border-transparent opacity-40 hover:opacity-100'}">
                    <img src="${p.url}" alt="${p.title}" class="w-full h-full object-cover">
                </button>
            `).join('');
        }
    }

    document.addEventListener('keydown', (e) => {
        const modal = document.getElementById('gallery-lightbox-modal');
        if (modal && !modal.classList.contains('hidden')) {
            if (e.key === 'ArrowRight' && lightboxViewMode === 'slide') nextPhoto();
            if (e.key === 'ArrowLeft' && lightboxViewMode === 'slide') prevPhoto();
            if (e.key === 'Escape') closeLightbox();
        }
    });

    // Toggle Favorite Heart
    function toggleFav(btn) {
        const icon = document.getElementById('fav-icon');
        if (icon) {
            if (icon.classList.contains('ri-heart-line')) {
                icon.classList.remove('ri-heart-line');
                icon.classList.add('ri-heart-fill', 'text-red-500');
                btn.classList.add('border-red-200');
            } else {
                icon.classList.remove('ri-heart-fill', 'text-red-500');
                icon.classList.add('ri-heart-line');
                btn.classList.remove('border-red-200');
            }
        }
    }

    function shareVilla() {
        if (navigator.share) {
            navigator.share({ title: 'Villa Azure Ocean Sanctuary', url: window.location.href });
        } else {
            navigator.clipboard.writeText(window.location.href);
            alert('Tautan villa berhasil disalin ke clipboard!');
        }
    }

    // POV Booking Modal Handlers
    function updatePaymentInstructions(selectEl) {
        if (!selectEl) return;
        const selected = selectEl.options[selectEl.selectedIndex];
        if (!selected) return;
        const name = selected.getAttribute('data-name') || selected.text;
        const type = (selected.getAttribute('data-type') || 'BANK_TRANSFER').toLowerCase();
        let accNum = selected.getAttribute('data-account-number') || '';
        let accName = selected.getAttribute('data-account-name') || '';
        const note = selected.getAttribute('data-note') || '';
        const qris = selected.getAttribute('data-qris') || '';

        const nameEl = document.getElementById('pm-info-name');
        const typeEl = document.getElementById('pm-info-type');
        const numWrapper = document.getElementById('pm-info-acc-num-wrapper');
        const numEl = document.getElementById('pm-info-acc-num');
        const accNameLabel = document.getElementById('pm-info-acc-name-label');
        const accNameEl = document.getElementById('pm-info-acc-name');
        const cashNotice = document.getElementById('pm-info-cash-notice');
        const qrisBox = document.getElementById('pm-qris-container');
        const qrisImg = document.getElementById('pm-qris-img');
        const noteBox = document.getElementById('pm-info-note-container');
        const noteEl = document.getElementById('pm-info-note');

        if (nameEl) nameEl.innerText = name;
        if (typeEl) typeEl.innerText = type.toUpperCase();

        const isQris = type === 'qris';
        const isCash = type === 'cash' || name.toLowerCase().includes('cash') || name.toLowerCase().includes('tunai');

        if (isCash) {
            if (cashNotice) cashNotice.classList.remove('hidden');
            if (numWrapper) numWrapper.classList.remove('hidden');

            // If Cash has no account_number set on option, fallback to default bank transfer account number from select options
            if (!accNum) {
                for (let i = 0; i < selectEl.options.length; i++) {
                    const opt = selectEl.options[i];
                    const optType = (opt.getAttribute('data-type') || '').toLowerCase();
                    if (optType === 'bank_transfer' && opt.getAttribute('data-account-number')) {
                        accNum = opt.getAttribute('data-account-number');
                        if (!accName) accName = opt.getAttribute('data-account-name');
                        break;
                    }
                }
            }

            if (numEl) numEl.innerText = accNum || '-';
            if (accNameLabel) accNameLabel.innerText = 'Atas Nama (Rekening Transfer DP):';
            if (accNameEl) accNameEl.innerText = accName || 'PT Villa Management';
            if (qrisBox) qrisBox.classList.add('hidden');
        } else if (isQris) {
            if (cashNotice) cashNotice.classList.add('hidden');
            // Hide account number completely for QRIS (only recipient name is displayed)
            if (numWrapper) numWrapper.classList.add('hidden');
            if (accNameLabel) accNameLabel.innerText = 'Nama Penerima:';
            if (accNameEl) accNameEl.innerText = accName || 'PT Villa Management';

            if (qrisBox && qrisImg) {
                if (qris) {
                    qrisImg.src = qris;
                    qrisBox.classList.remove('hidden');
                } else {
                    qrisBox.classList.add('hidden');
                }
            }
        } else {
            if (cashNotice) cashNotice.classList.add('hidden');
            if (numWrapper) numWrapper.classList.remove('hidden');
            if (numEl) numEl.innerText = accNum || '-';
            if (accNameLabel) accNameLabel.innerText = 'Atas Nama:';
            if (accNameEl) accNameEl.innerText = accName || '-';

            if (qrisBox && qrisImg) {
                if (qris) {
                    qrisImg.src = qris;
                    qrisBox.classList.remove('hidden');
                } else {
                    qrisBox.classList.add('hidden');
                }
            }
        }

        if (noteBox && noteEl) {
            if (note && note.trim() !== '') {
                noteEl.innerText = note;
                noteBox.classList.remove('hidden');
            } else {
                noteBox.classList.add('hidden');
            }
        }
    }

    function previewBuktiPayment(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('bukti-preview-img');
                const box = document.getElementById('bukti-preview-box');
                if (img && box) {
                    img.src = e.target.result;
                    box.classList.remove('hidden');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function syncBookingDates() {
        const checkinVal = document.getElementById('book-checkin')?.value;
        const checkoutVal = document.getElementById('book-checkout')?.value;
        
        if (checkinVal && document.getElementById('modal-checkin')) {
            document.getElementById('modal-checkin').value = checkinVal;
        }
        if (checkoutVal && document.getElementById('modal-checkout')) {
            document.getElementById('modal-checkout').value = checkoutVal;
        }

        if (checkinVal && checkoutVal) {
            const d1 = new Date(checkinVal);
            const d2 = new Date(checkoutVal);
            const diffDays = Math.max(1, Math.ceil(Math.abs(d2 - d1) / (1000 * 60 * 60 * 24)));
            const summaryNights = document.getElementById('modal-summary-nights');
            if (summaryNights) {
                summaryNights.innerText = diffDays + ' Malam';
            }
        }
    }

    function openPovModal() {
        syncBookingDates();
        const selectEl = document.getElementById('pov-payment');
        if (selectEl) updatePaymentInstructions(selectEl);

        const modal = document.getElementById('pov-booking-modal');
        const box = document.getElementById('pov-modal-box');
        if (!modal) return;
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            box?.classList.remove('scale-95');
        }, 10);
    }

    function closePovModal() {
        const modal = document.getElementById('pov-booking-modal');
        const box = document.getElementById('pov-modal-box');
        if (!modal) return;
        modal.classList.add('opacity-0');
        box?.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function goToPovStep2() {
        const guestName = document.getElementById('pov-name').value || 'Budi Santoso';
        document.getElementById('res-name').innerText = guestName;
        document.getElementById('pov-step-1').classList.add('hidden');
        document.getElementById('pov-step-2').classList.remove('hidden');
    }

    function simulatedDownloadPdf() {
        alert('Simulasi Unduh: E-Voucher Reservasi Villa Azure PDF telah diunduh!');
    }

    // All Guest Reviews Dataset & Handlers
    const guestReviewsData = [
        { name: "Sarah Jenkins", country: "Australia 🇦🇺", date: "Juli 2026", rating: 5, avatar: "https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=75", comment: "Pengalaman paling berkesan! Pemandangan sunset dari infinity pool sangat menakjubkan, dan layanan koki pribadinya luar biasa lezat." },
        { name: "Michael Ross", country: "Singapura 🇸🇬", date: "Juni 2026", rating: 5, avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=75", comment: "Sangat direkomendasikan untuk staycation keluarga. Anak-anak sangat menyukai kolam renangnya dan fasilitasnya amat lengkap." },
        { name: "Jessica Taylor", country: "Inggris 🇬🇧", date: "Mei 2026", rating: 5, avatar: "https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=100&q=75", comment: "Butler 24 jam sangat responsif dan membantu semua kebutuhan acara ulang tahun kami. Kebersihan kamar 10/10." },
        { name: "Kenji Sato", country: "Jepang 🇯🇵", date: "April 2026", rating: 5, avatar: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=100&q=75", comment: "Lokasinya sangat strategis di Seminyak, tenang dan dekat ke pantai. Layanan penjemputan Alphard sangat nyaman." },
        { name: "Amanda & David", country: "Amerika Serikat 🇺🇸", date: "Maret 2026", rating: 5, avatar: "https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=100&q=75", comment: "Tempat favorit kami di Bali untuk honeymoon! Kasur sangat nyaman dan bathtub marmernya sangat mewah." },
        { name: "Budi Santoso", country: "Indonesia 🇮🇩", date: "Februari 2026", rating: 5, avatar: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=100&q=75", comment: "Villanya sangat luas dan bersih. Makanan koki in-villa bintang lima!" }
    ];

    function openReviewsModal() {
        const modal = document.getElementById('all-reviews-modal');
        const box = document.getElementById('reviews-modal-box');
        if (!modal) return;
        renderReviewsFeed(guestReviewsData);
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            box.classList.remove('scale-95');
        }, 10);
    }

    function closeReviewsModal() {
        const modal = document.getElementById('all-reviews-modal');
        const box = document.getElementById('reviews-modal-box');
        if (!modal) return;
        modal.classList.add('opacity-0');
        box.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function filterGuestReviews() {
        const query = (document.getElementById('review-search-input')?.value || '').toLowerCase();
        const filtered = guestReviewsData.filter(r => 
            r.name.toLowerCase().includes(query) || 
            r.comment.toLowerCase().includes(query) || 
            r.country.toLowerCase().includes(query)
        );
        renderReviewsFeed(filtered);
    }

    function renderReviewsFeed(list) {
        const container = document.getElementById('reviews-feed-container');
        if (!container) return;
        if (list.length === 0) {
            container.innerHTML = `<div class="text-center py-8 text-slate-400 text-xs">Tidak ada ulasan yang cocok dengan pencarian Anda.</div>`;
            return;
        }
        container.innerHTML = list.map(r => `
            <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="${r.avatar}" alt="${r.name}" class="w-10 h-10 rounded-full object-cover shadow-sm">
                        <div>
                            <div class="flex items-center gap-2">
                                <h5 class="text-xs font-bold text-slate-900">${r.name}</h5>
                                <span class="bg-emerald-50 text-emerald-600 text-[9px] font-bold px-2 py-0.5 rounded-full">Tamu Terverifikasi</span>
                            </div>
                            <span class="text-[10px] text-slate-400">${r.country} • ${r.date}</span>
                        </div>
                    </div>
                    <div class="flex text-[#ca9e54] text-xs">
                        <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                    </div>
                </div>
                <p class="text-xs text-slate-600 font-light leading-relaxed">
                    "${r.comment}"
                </p>
            </div>
        `).join('');
    }

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
                        <strong class="text-xl font-mono font-bold text-[#ca9e54] block">#{{ is_array($sData) ? ($sData['booking_code'] ?? '') : ($sData->booking_code ?? '') }}</strong>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-emerald-50 text-emerald-800 text-[11px] font-semibold border border-emerald-200 flex items-center gap-2">
                        <i class="ri-information-fill text-emerald-600 text-base shrink-0"></i> 
                        <span>Bukti pembayaran Anda telah berhasil diunggah. Reservasi Anda sedang diverifikasi oleh admin.</span>
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
</script>
@endpush

<!-- FLOATING MOBILE STICKY BOOKING BAR (Khusus Tampilan Smartphone / Tablet < 1024px) -->
<div class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-xl border-t border-slate-200/80 p-3.5 px-4 sm:px-6 flex items-center justify-between lg:hidden shadow-[0_-8px_30px_rgba(0,0,0,0.12)]">
    <div>
        <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block">Mulai dari</span>
        <div class="flex items-baseline gap-1">
            <x-ui.price :value="(float) ($property->price ?? 4500000)" class="text-xl font-extrabold text-[#152c4e] font-serif-title" />
            <span class="text-xs font-light text-slate-500">/ malam</span>
        </div>
    </div>
    <a href="#booking-form-box" class="bg-[#ca9e54] hover:bg-[#b88c43] text-white font-bold text-xs uppercase tracking-wider px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition-all active:scale-95 flex items-center gap-1.5 gold-glow">
        <span>Pesan Sekarang</span>
        <i class="ri-arrow-right-line text-sm"></i>
    </a>
</div>
@endsection
