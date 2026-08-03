@php
    $prop = $property ?? null;
    $propName = $prop->name ?? 'Villa Sanctuary';
    $propAddress = $prop->address ?? 'Seminyak, Bali, Indonesia';
    $propCity = $prop->city ?? 'Seminyak';
    $propProvince = $prop->province ?? 'Bali';
    $propPrice = (float) ($prop->price ?? 4500000);
    $propRating = number_format($prop->rating ?? 4.95, 2);
    $propBedrooms = $prop->bedrooms ?? 2;
    $propCapacity = $prop->capacity ?? 4;
    $propDescription = $prop->description ?? 'Nikmati keindahan dan kenyamanan menginap di villa mewah ini.';
    $propMainImage = isset($prop->main_image) 
        ? (\Illuminate\Support\Str::startsWith($prop->main_image, ['http://', 'https://']) ? $prop->main_image : asset('storage/'.$prop->main_image)) 
        : 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1400&q=85';

    // Construct unified gallery list for Lightbox & Grid
    $galleryList = [];
    if ($propMainImage) {
        $galleryList[] = [
            'url' => $propMainImage,
            'title' => $propName . ' - Utama'
        ];
    }
    if ($prop && $prop->galleries && $prop->galleries->count() > 0) {
        foreach($prop->galleries as $g) {
            $galleryList[] = [
                'url' => asset('storage/' . $g->image_path),
                'title' => $g->caption ?: $propName
            ];
        }
    }
    // Fallback if gallery count is under 5
    if (count($galleryList) < 5) {
        $fallbacks = [
            'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1200&q=80'
        ];
        foreach($fallbacks as $fUrl) {
            if (count($galleryList) >= 5) break;
            $galleryList[] = [
                'url' => $fUrl,
                'title' => $propName . ' - Suasana'
            ];
        }
    }
@endphp

@extends('layouts.frontend.main')

@section('title', $propName . ' - ' . $propCity . ', ' . $propProvince . ' | Palma Luxury')

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
                <span class="text-slate-700 font-semibold truncate">{{ $propName }}</span>
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
                    <span class="inline-flex items-center gap-1 bg-[#152c4e]/5 text-[#152c4e] border border-[#152c4e]/10 text-[10px] sm:text-xs font-semibold px-3 py-0.5 rounded-full uppercase tracking-wider">
                        {{ $prop->type ?? 'Villa Sanctuary' }}
                    </span>
                </div>
                <h1 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-slate-900 leading-tight">
                    {{ $propName }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 font-medium flex items-center gap-2 mt-2 flex-wrap">
                    <i class="ri-map-pin-2-fill text-[#ca9e54]"></i>
                    <span>{{ $propAddress }}</span>
                    <span>•</span>
                    <span class="flex items-center gap-1 font-bold text-slate-900">
                        <i class="ri-star-fill text-[#ca9e54]"></i> {{ $propRating }}
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
        <div class="grid grid-cols-2 md:grid-cols-5 gap-2 sm:gap-3 overflow-hidden relative p-1.5 group/gallery">
            
            <!-- Main Featured Image -->
            <div class="col-span-2 md:col-span-2 md:row-span-2 h-52 sm:h-72 md:h-[460px] relative overflow-hidden rounded-2xl group cursor-pointer" onclick="openLightbox(0)">
                <img src="{{ $galleryList[0]['url'] }}" alt="{{ $galleryList[0]['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors"></div>
            </div>

            <!-- Side 4 Gallery Images -->
            @for($i = 1; $i <= 4; $i++)
                @if(isset($galleryList[$i]))
                    <div class="col-span-1 h-32 sm:h-44 md:h-[224px] relative overflow-hidden rounded-2xl group cursor-pointer" onclick="openLightbox({{ $i }})">
                        <img src="{{ $galleryList[$i]['url'] }}" alt="{{ $galleryList[$i]['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors"></div>
                        @if($i === 4 && count($galleryList) > 5)
                            <div class="absolute inset-0 bg-black/60 backdrop-blur-xs flex flex-col items-center justify-center text-white font-bold text-xs sm:text-sm">
                                <span>+{{ count($galleryList) - 5 }} Foto</span>
                                <span class="text-[10px] font-normal text-slate-300">Lihat Semua</span>
                            </div>
                        @endif
                    </div>
                @endif
            @endfor
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
                        {{ $propCapacity }} Tamu • {{ $propBedrooms }} Kamar Tidur • {{ $prop->type ?? 'Villa' }} Sanctuary
                    </p>
                </div>
                <div class="w-14 h-14 rounded-full bg-[#152c4e] text-white flex items-center justify-center font-bold text-lg shadow-md shrink-0 uppercase">
                    {{ $prop->code ?? 'PLM' }}
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
            <div class="flex items-center justify-between gap-3 py-4 border-b border-slate-200/80">
                <!-- Left: Price & Strikethrough Discount Badge -->
                <div class="space-y-0.5 min-w-0">
                    <div class="flex items-baseline gap-1.5 flex-wrap">
                        <span class="text-xl sm:text-2xl md:text-3xl font-bold text-[#152c4e] font-serif-title tracking-tight">Rp {{ number_format($propPrice, 0, ',', '.') }}</span>
                        <span class="text-[11px] sm:text-xs text-slate-500 font-normal">/malam</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] sm:text-xs text-slate-400 line-through font-mono">Rp {{ number_format($propPrice * 1.3, 0, ',', '.') }}</span>
                        <span class="inline-flex items-center bg-[#ca9e54]/10 text-[#b88c43] border border-[#ca9e54]/30 text-[9px] sm:text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">
                            Hemat 30%
                        </span>
                    </div>
                </div>

                <!-- Right: Clean Sharp Action Button (Always inline on mobile) -->
                <div class="shrink-0">
                    @auth
                        <a href="{{ route('booking.create', $prop->slug ?? '') }}" class="bg-[#152c4e] hover:bg-[#0f1d32] text-white font-bold px-4 sm:px-6 py-2.5 sm:py-3 rounded-full text-xs uppercase tracking-wider transition-all duration-300 shadow-md hover:shadow-lg inline-flex items-center gap-1.5 cursor-pointer whitespace-nowrap">
                            <span>Lanjut Pesan</span>
                            <i class="ri-arrow-right-line text-sm"></i>
                        </a>
                    @else
                        <button type="button" onclick="openRequireLoginModal('{{ route('booking.create', $prop->slug ?? '') }}')" class="bg-[#152c4e] hover:bg-[#0f1d32] text-white font-bold px-4 sm:px-6 py-2.5 sm:py-3 rounded-full text-xs uppercase tracking-wider transition-all duration-300 shadow-md hover:shadow-lg inline-flex items-center gap-1.5 cursor-pointer whitespace-nowrap">
                            <span>Lanjut Pesan</span>
                            <i class="ri-arrow-right-line text-sm"></i>
                        </button>
                    @endauth
                </div>
            </div>

            <!-- Villa Description -->
            <div class="space-y-4 pb-8 border-b border-slate-200/80">
                <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">Tentang Villa Ini</h3>
                <div class="text-xs sm:text-sm text-slate-600 font-light leading-relaxed space-y-3">
                    {!! nl2br(e($propDescription)) !!}
                </div>
            </div>

            <!-- Amenities Checklist -->
            <div class="space-y-6 pb-8 border-b border-slate-200/80">
                <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">Fasilitas Properti</h3>
                
                @if($prop && $prop->facilities->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 text-xs sm:text-sm font-medium text-slate-800">
                        @foreach($prop->facilities as $fac)
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
                        <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">{{ $propCity }}, {{ $propProvince }}</h3>
                    </div>
                </div>
                <p class="text-xs text-slate-500 flex items-center gap-1.5">
                    <i class="ri-map-pin-line text-slate-400"></i> {{ $propAddress }}
                </p>

                <!-- Embedded Interactive Google Maps Container -->
                <div class="w-full h-72 sm:h-96 overflow-hidden border border-slate-200/80 relative rounded-2xl">
                    @if(!empty($prop->map_link))
                        {!! $prop->map_link !!}
                    @else
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.0261331776955!2d115.1541315!3d-8.6834164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd24752dfaa1585%3A0xe54d306b3a09e0eb!2sSeminyak%2C%20Kuta%2C%20Badung%20Regency%2C%20Bali!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" class="w-full h-full border-0" allowfullscreen="" loading="lazy"></iframe>
                    @endif
                </div>
            </div>

            <!-- Verified Reviews -->
            <div class="space-y-6 pb-8 border-b border-slate-200/80">
                <div class="flex items-center justify-between">
                    <h3 class="font-serif-title text-xl sm:text-2xl font-bold text-slate-900">Ulasan Tamu Terverifikasi</h3>
                    <span class="text-xs font-bold text-[#ca9e54] flex items-center gap-1">
                        <i class="ri-star-fill"></i> {{ $propRating }} / 5.0
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-5 rounded-2xl bg-slate-50 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=75" alt="Sarah J." class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <h5 class="text-xs font-bold text-slate-900">Sarah Jenkins</h5>
                                    <span class="text-[10px] text-slate-400">Australia • Juli 2026</span>
                                </div>
                            </div>
                            <div class="flex text-[#ca9e54] text-xs">
                                <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 font-light leading-relaxed">
                            "Pengalaman paling berkesan! Pemandangan sunset dari infinity pool sangat menakjubkan, dan layanan koki pribadinya luar biasa lezat."
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=75" alt="Michael R." class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <h5 class="text-xs font-bold text-slate-900">Michael Ross</h5>
                                    <span class="text-[10px] text-slate-400">Singapura • Juni 2026</span>
                                </div>
                            </div>
                            <div class="flex text-[#ca9e54] text-xs">
                                <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 font-light leading-relaxed">
                            "Sangat direkomendasikan untuk staycation keluarga. Anak-anak sangat menyukai kolam renangnya dan fasilitasnya amat lengkap."
                        </p>
                    </div>
                </div>

                <!-- CTA BUTTON TO OPEN ALL REVIEWS MODAL -->
                <button onclick="openReviewsModal()" class="w-full py-4 bg-slate-50 hover:bg-slate-100 text-[#152c4e] font-bold text-xs rounded-2xl border border-slate-200/80 hover:border-[#152c4e] transition-colors flex items-center justify-center gap-2 cursor-pointer group shadow-sm">
                    <i class="ri-chat-smile-2-line text-base text-[#ca9e54]"></i>
                    <span>Lihat Semua Ulasan & Komentar Tamu</span>
                    <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>

            <!-- PERATURAN & KETENTUAN PEMESANAN (MINIMALIST & PROFESSIONAL CARD-LESS LAYOUT) -->
            <div class="space-y-6 pt-4">
                <div class="border-b border-slate-200/80 pb-4">
                    <span class="text-[10px] font-bold tracking-widest text-[#ca9e54] uppercase block mb-1">INFORMASI & KEBIJAKAN VILLA</span>
                    <h3 class="font-serif-title text-2xl sm:text-3xl font-bold text-slate-900">Peraturan & Ketentuan Pemesanan</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 text-xs text-slate-600">
                    <!-- 1. Check-in & Check-out -->
                    <div class="flex items-start gap-3.5">
                        <i class="ri-time-line text-[#ca9e54] text-lg shrink-0 mt-0.5"></i>
                        <div class="space-y-1">
                            <h4 class="font-bold text-slate-900 text-sm">Waktu Check-in & Check-out</h4>
                            <p class="leading-relaxed">
                                Check-in tersedia mulai pukul <strong class="text-slate-900 font-semibold">14:00 WITA</strong> dan waktu Check-out maksimal pukul <strong class="text-slate-900 font-semibold">12:00 WITA</strong>.
                            </p>
                        </div>
                    </div>

                    <!-- 2. Capacity & Guests -->
                    <div class="flex items-start gap-3.5">
                        <i class="ri-team-line text-[#152c4e] text-lg shrink-0 mt-0.5"></i>
                        <div class="space-y-1">
                            <h4 class="font-bold text-slate-900 text-sm">Kapasitas & Batas Tamu</h4>
                            <p class="leading-relaxed">
                                Kapasitas maksimal <strong class="text-slate-900 font-semibold">{{ $propCapacity }} tamu</strong> menginap. Tambahan tamu di luar kapasitas wajib dikonfirmasi sebelumnya.
                            </p>
                        </div>
                    </div>

                    <!-- 3. Prohibition & Quiet Hours -->
                    <div class="flex items-start gap-3.5">
                        <i class="ri-shield-cross-line text-slate-700 text-lg shrink-0 mt-0.5"></i>
                        <div class="space-y-1">
                            <h4 class="font-bold text-slate-900 text-sm">Larangan & Jam Tenang</h4>
                            <p class="leading-relaxed">
                                Dilarang merokok di dalam kamar tidur. Jam tenang lingkungan berlaku mulai pukul <strong class="text-slate-900 font-semibold">22:00 WITA</strong>.
                            </p>
                        </div>
                    </div>

                    <!-- 4. Cancellation Policy -->
                    <div class="flex items-start gap-3.5">
                        <i class="ri-file-shield-2-line text-emerald-600 text-lg shrink-0 mt-0.5"></i>
                        <div class="space-y-1">
                            <h4 class="font-bold text-slate-900 text-sm">Kebijakan Pembatalan & Refund</h4>
                            <p class="leading-relaxed">
                                Pembatalan gratis hingga <strong class="text-slate-900 font-semibold">7 hari sebelum check-in</strong>. Pembatalan < 7 hari dikenakan biaya 50%.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Special Notes if available -->
                @if($prop && $prop->settings && $prop->settings->cancellation_policy)
                    <div class="pt-4 border-t border-slate-200/60 flex items-center gap-2.5 text-xs text-slate-600">
                        <i class="ri-information-line text-[#ca9e54] text-base shrink-0"></i>
                        <p class="leading-relaxed text-slate-600">
                            <strong class="text-slate-900 font-semibold">Catatan Khusus Properti:</strong>
                            <span class="ml-1">{!! strip_tags($prop->settings->cancellation_policy) !!}</span>
                        </p>
                    </div>
                @endif
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
                <input type="hidden" name="property_id" value="{{ $prop->id ?? 1 }}">
                <input type="hidden" name="check_in" id="modal-checkin" value="2026-08-15">
                <input type="hidden" name="check_out" id="modal-checkout" value="2026-08-18">

                <!-- Booking Summary Banner -->
                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 flex items-center justify-between text-xs font-satoshi-medium">
                    <div>
                        <span class="text-slate-500 block text-[10px] uppercase font-bold tracking-wider">Properti:</span>
                        <strong class="text-slate-900 font-bold">{{ $propName }}</strong>
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
                                            data-account-number="{{ $pm->account_number ?? '-' }}"
                                            data-account-name="{{ $pm->account_name ?? '-' }}"
                                            data-qris="{{ $pm->image_qris ? asset('storage/'.$pm->image_qris) : '' }}">
                                        {{ $pm->name }} ({{ strtoupper($pm->type) }})
                                    </option>
                                @endforeach
                            @else
                                <option value="1" data-name="Bank Transfer BCA" data-account-number="8830123999" data-account-name="PT Villa Management">Bank Transfer BCA</option>
                            @endif
                        </select>
                    </div>

                    <!-- Instruction Box for Selected Payment -->
                    <div id="payment-instruction-box" class="p-3.5 rounded-xl bg-amber-50/80 border border-amber-200/80 text-xs text-amber-900 space-y-1">
                        <div class="font-bold flex items-center justify-between">
                            <span id="pm-info-name">Transfer Bank</span>
                            <span class="text-[10px] bg-amber-200/80 text-amber-900 font-extrabold px-2 py-0.5 rounded" id="pm-info-type">BANK_TRANSFER</span>
                        </div>
                        <div class="font-mono text-slate-800 pt-1">
                            No. Rekening / VA: <strong id="pm-info-acc-num" class="text-slate-900 font-bold select-all">8830123999</strong>
                        </div>
                        <div class="text-[11px] text-slate-600">
                            Atas Nama: <span id="pm-info-acc-name">PT Villa Management</span>
                        </div>
                        <div id="pm-qris-container" class="hidden pt-2 text-center">
                            <img id="pm-qris-img" src="" class="w-32 h-32 mx-auto rounded-lg border border-slate-300">
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
                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">CATATAN KHUSUS (OPTIONAL)</label>
                        <textarea name="notes" rows="2" placeholder="Catatan khusus atau permintaan check-in..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-semibold text-slate-900 focus:outline-none focus:border-[#ca9e54]"></textarea>
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
    </div>

    <!-- FULLSCREEN INTERACTIVE LIGHTBOX GALLERY MODAL (PURE IMAGES ONLY) -->
    <div id="gallery-lightbox-modal" onclick="closeLightbox()" class="fixed inset-0 bg-[#0c182b]/85 backdrop-blur-2xl z-[100] flex flex-col justify-between p-3 sm:p-6 hidden opacity-0 transition-opacity duration-300 select-none">
        
        <!-- Lightbox Top Control Bar -->
        <div class="flex items-center justify-between text-white z-20 pb-2 border-b border-white/10" onclick="event.stopPropagation()">
            <div class="flex items-center gap-2">
                <span class="text-[#ca9e54] font-bold text-xs sm:text-sm uppercase tracking-wider font-mono" id="lightbox-counter-text">1 / 9</span>
            </div>
            <button onclick="closeLightbox()" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer text-lg" title="Tutup (ESC)">
                <i class="ri-close-line"></i>
            </button>
        </div>

        <!-- Main Display Container (Image + Floating Arrows) -->
        <div class="relative flex-1 flex items-center justify-center my-auto py-2">
            
            <!-- Floating Left Arrow Button -->
            <button onclick="event.stopPropagation(); prevPhoto();" class="absolute left-2 sm:left-12 z-30 w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-slate-900/80 hover:bg-[#ca9e54] text-white flex items-center justify-center transition-all duration-300 shadow-2xl backdrop-blur-md cursor-pointer border border-white/20 hover:border-transparent active:scale-95">
                <i class="ri-arrow-left-s-line text-2xl sm:text-3xl"></i>
            </button>

            <!-- Active Photo Frame -->
            <div class="relative max-w-5xl max-h-[70vh] flex items-center justify-center" onclick="event.stopPropagation()">
                <img id="lightbox-main-img" src="" alt="Gallery Active Photo" class="max-w-full max-h-[68vh] object-contain rounded-2xl shadow-2xl transition-all duration-300">
            </div>

            <!-- Floating Right Arrow Button -->
            <button onclick="event.stopPropagation(); nextPhoto();" class="absolute right-2 sm:right-12 z-30 w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-slate-900/80 hover:bg-[#ca9e54] text-white flex items-center justify-center transition-all duration-300 shadow-2xl backdrop-blur-md cursor-pointer border border-white/20 hover:border-transparent active:scale-95">
                <i class="ri-arrow-right-s-line text-2xl sm:text-3xl"></i>
            </button>

        </div>

        <!-- Bottom Thumbnail Strip -->
        <div class="border-t border-white/10 pt-3 max-w-5xl mx-auto w-full z-20" onclick="event.stopPropagation()">
            <div class="flex items-center justify-center gap-2 overflow-x-auto py-1 no-scrollbar" id="lightbox-thumbnails">
                <!-- JS Rendered Thumbnail Items -->
            </div>
        </div>

    </div>

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
                <span class="font-serif-title font-bold text-lg sm:text-xl text-white">Rp {{ number_format($propPrice, 0, ',', '.') }}</span>
                <span class="text-[10px] text-white/60 font-light">/ malam</span>
                <span class="text-white/30 text-xs">•</span>
                <div class="flex items-center gap-1 text-[11px] text-[#e5c382] font-semibold">
                    <i class="ri-star-fill text-[11px]"></i> {{ $propRating }}
                </div>
            </div>

            <!-- Right CTA Button: Minimalist Gold Button -->
            @auth
                <a href="{{ route('booking.create', $prop->slug ?? '') }}" class="bg-[#ca9e54] hover:bg-[#b88c43] text-slate-950 font-bold px-5 py-2.5 rounded-full text-xs transition-transform active:scale-95 cursor-pointer shadow-lg flex items-center gap-1.5 shrink-0">
                    <span>Pesan Sekarang</span>
                    <i class="ri-arrow-right-line text-sm"></i>
                </a>
            @else
                <button onclick="openRequireLoginModal('{{ route('booking.create', $prop->slug ?? '') }}')" class="bg-[#ca9e54] hover:bg-[#b88c43] text-slate-950 font-bold px-5 py-2.5 rounded-full text-xs transition-transform active:scale-95 cursor-pointer shadow-lg flex items-center gap-1.5 shrink-0">
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
    const basePricePerNight = {{ (float) $propPrice }};

    function formatRupiah(num) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(num));
    }

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

        calculateBookingTotal();
    });

    let currentPhotoIndex = 0;

    function openLightbox(index = 0) {
        const modal = document.getElementById('gallery-lightbox-modal');
        if (!modal) return;
        currentPhotoIndex = index % villaGalleryPhotos.length;
        updateLightboxContent();
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
        }, 10);
        document.body.classList.add('overflow-hidden');
    }

    function closeLightbox() {
        const modal = document.getElementById('gallery-lightbox-modal');
        if (!modal) return;
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
            if (e.key === 'ArrowRight') nextPhoto();
            if (e.key === 'ArrowLeft') prevPhoto();
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
        const type = selected.getAttribute('data-type') || 'BANK_TRANSFER';
        const accNum = selected.getAttribute('data-account-number') || '-';
        const accName = selected.getAttribute('data-account-name') || '-';
        const qris = selected.getAttribute('data-qris') || '';

        const nameEl = document.getElementById('pm-info-name');
        const typeEl = document.getElementById('pm-info-type');
        const numEl = document.getElementById('pm-info-acc-num');
        const accNameEl = document.getElementById('pm-info-acc-name');
        
        if (nameEl) nameEl.innerText = name;
        if (typeEl) typeEl.innerText = type;
        if (numEl) numEl.innerText = accNum;
        if (accNameEl) accNameEl.innerText = accName;

        const qrisBox = document.getElementById('pm-qris-container');
        const qrisImg = document.getElementById('pm-qris-img');
        if (qrisBox && qrisImg) {
            if (qris) {
                qrisImg.src = qris;
                qrisBox.classList.remove('hidden');
            } else {
                qrisBox.classList.add('hidden');
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
    }

    @if(session('success_booking'))
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Reservasi Berhasil!',
                    html: `
                        <div class="text-left space-y-2 text-xs text-slate-700 font-satoshi pt-2">
                            <p><strong>Kode Booking:</strong> <span class="font-mono text-amber-600 font-bold">{{ session('success_booking.booking_code') }}</span></p>
                            <p><strong>Nama Tamu:</strong> {{ session('success_booking.guest_name') }}</p>
                            <p><strong>Properti:</strong> {{ session('success_booking.property_name') }}</p>
                            <p><strong>Total Pembayaran:</strong> Rp {{ session('success_booking.total_price') }}</p>
                            <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-800 text-[11px] font-semibold border border-emerald-200 mt-2">
                                ✓ Bukti pembayaran Anda telah berhasil diunggah. Reservasi Anda sedang diverifikasi oleh admin.
                            </div>
                        </div>
                    `,
                    confirmButtonColor: '#152c4e',
                    confirmButtonText: 'Tutup'
                });
            } else {
                alert('Reservasi Berhasil!\nKode Booking: {{ session("success_booking.booking_code") }}\nTotal: Rp {{ session("success_booking.total_price") }}');
            }
        });
    @endif
</script>
@endpush

<!-- FLOATING MOBILE STICKY BOOKING BAR (Khusus Tampilan Smartphone / Tablet < 1024px) -->
<div class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-xl border-t border-slate-200/80 p-3.5 px-4 sm:px-6 flex items-center justify-between lg:hidden shadow-[0_-8px_30px_rgba(0,0,0,0.12)]">
    <div>
        <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block">Mulai dari</span>
        <div class="flex items-baseline gap-1">
            <span class="text-xl font-extrabold text-[#152c4e] font-serif-title">Rp {{ number_format($propPrice, 0, ',', '.') }}</span>
            <span class="text-xs font-light text-slate-500">/ malam</span>
        </div>
    </div>
    <a href="#booking-form-box" class="bg-[#ca9e54] hover:bg-[#b88c43] text-white font-bold text-xs uppercase tracking-wider px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition-all active:scale-95 flex items-center gap-1.5 gold-glow">
        <span>Pesan Sekarang</span>
        <i class="ri-arrow-right-line text-sm"></i>
    </a>
</div>
@endsection
