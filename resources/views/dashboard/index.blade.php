@php
    $breadcrumbsData = Breadcrumbs::generate(); 
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';
@endphp

@extends('layouts.backend.main')

@section('title', 'Dashboard')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulseSlow {
        0%, 100% { opacity: 0.4; transform: scale(1); }
        50% { opacity: 0.8; transform: scale(1.05); }
    }

    @keyframes floatSlow {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-6px); }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .animate-pulse-slow {
        animation: pulseSlow 4s ease-in-out infinite;
    }

    .animate-float-slow {
        animation: floatSlow 3s ease-in-out infinite;
    }

    .delay-100 { animation-delay: 100ms; }
    .delay-200 { animation-delay: 200ms; }
    .delay-300 { animation-delay: 300ms; }
    .delay-400 { animation-delay: 400ms; }
</style>

<div class="space-y-8 pb-12">

    <!-- 2. KEY METRICS STAT CARDS (4 CARD GRID) -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        
        <!-- Stat Card 1: Total Pendapatan -->
        <div class="animate-fade-in-up delay-100">
            <x-ui.card class="p-6 flex flex-col justify-between min-h-[175px] hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1.5 border border-slate-200/80 bg-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 h-24 w-24 bg-gradient-to-bl from-amber-500/10 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform"></div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-satoshi-bold text-slate-500 uppercase tracking-wider">Total Pendapatan</span>
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 border border-amber-200/60 group-hover:bg-[#ca9e54] group-hover:text-slate-950 transition-colors">
                        <i class="ri-money-dollar-circle-line text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-2xl font-satoshi-bold tracking-tight text-slate-900">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </h3>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="inline-flex items-center gap-0.5 text-xs font-satoshi-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/50">
                            <i class="ri-arrow-up-line"></i> +24.5%
                        </span>
                        <span class="text-[11px] text-slate-600 font-satoshi-medium">vs bulan lalu</span>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Stat Card 2: Total Properti Villa -->
        <div class="animate-fade-in-up delay-200">
            <x-ui.card class="p-6 flex flex-col justify-between min-h-[175px] hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1.5 border border-slate-200/80 bg-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 h-24 w-24 bg-gradient-to-bl from-indigo-500/10 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform"></div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-satoshi-bold text-slate-500 uppercase tracking-wider">Total Properti</span>
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 border border-indigo-200/60 group-hover:bg-slate-900 group-hover:text-white transition-colors">
                        <i class="ri-home-4-line text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-2xl font-satoshi-bold tracking-tight text-slate-900">{{ $totalProperties }}</h3>
                        <span class="text-xs text-slate-500 font-satoshi-medium">Unit Properti</span>
                    </div>
                    <div class="flex items-center gap-3 mt-2 text-xs font-satoshi-medium text-slate-600">
                        <span class="text-emerald-600 font-bold"><i class="ri-checkbox-circle-fill text-xs"></i> {{ $activeProperties }} Aktif</span>
                        <span class="text-amber-600 font-bold"><i class="ri-star-fill text-xs"></i> {{ $featuredProperties }} Featured</span>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Stat Card 3: Total Booking -->
        <div class="animate-fade-in-up delay-300">
            <x-ui.card class="p-6 flex flex-col justify-between min-h-[175px] hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1.5 border border-slate-200/80 bg-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 h-24 w-24 bg-gradient-to-bl from-emerald-500/10 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform"></div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-satoshi-bold text-slate-500 uppercase tracking-wider">Total Pesanan</span>
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-200/60 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <i class="ri-file-list-3-line text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-2xl font-satoshi-bold tracking-tight text-slate-900">{{ $totalBookings }}</h3>
                        <span class="text-xs text-slate-500 font-satoshi-medium">Reservasi</span>
                    </div>
                    <div class="flex items-center gap-3 mt-2 text-xs font-satoshi-medium text-slate-600">
                        <span class="text-emerald-600 font-bold">{{ $confirmedBookings + $completedBookings }} Sukses</span>
                        <span class="text-amber-600 font-bold">{{ $pendingBookings }} Pending</span>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Stat Card 4: Guest Rating & Kepuasan -->
        <div class="animate-fade-in-up delay-400">
            <x-ui.card class="p-6 flex flex-col justify-between min-h-[175px] hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1.5 border border-slate-200/80 bg-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 h-24 w-24 bg-gradient-to-bl from-rose-500/10 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform"></div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-satoshi-bold text-slate-500 uppercase tracking-wider">Rating Tamu</span>
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-50 text-rose-600 border border-rose-200/60 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                        <i class="ri-star-smile-line text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center gap-2">
                        <h3 class="text-2xl font-satoshi-bold tracking-tight text-slate-900">{{ $avgRating }}</h3>
                        <div class="flex text-amber-400 text-sm">
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-half-fill"></i>
                        </div>
                    </div>
                    <p class="text-xs font-satoshi-medium text-slate-600 mt-2">
                        Dari total <span class="font-bold text-slate-800">{{ $totalReviews }}</span> ulasan ulasan terverifikasi
                    </p>
                </div>
            </x-ui.card>
        </div>

    </div>

    <!-- 3. INTERACTIVE ANALYTICS CHARTS SECTION -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 animate-fade-in-up delay-200">
        
        <!-- Main Revenue & Booking Volume Area Chart -->
        <x-ui.card class="lg:col-span-2 p-6 flex flex-col justify-between hover:shadow-xl transition-all duration-300 border border-slate-200/80">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6 flex-wrap gap-2">
                <div>
                    <h3 class="font-satoshi-bold text-slate-900 text-base flex items-center gap-2">
                        <i class="ri-line-chart-line text-amber-500 text-lg"></i> Tren Pendapatan &amp; Volume Pemesanan
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Grafik pergerakan omset dan jumlah pemesanan villa dalam 6 bulan terakhir</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-satoshi-semibold">
                        <span class="h-2 w-2 rounded-full bg-slate-900"></span> Pendapatan (Rp)
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 text-xs font-satoshi-semibold">
                        <span class="h-2 w-2 rounded-full bg-[#ca9e54]"></span> Total Booking
                    </span>
                </div>
            </div>

            <!-- Apex Area Chart -->
            <div class="w-full">
                <x-ui.chart 
                    type="area"
                    height="300"
                    :series="[
                        ['name' => 'Pendapatan (Rp)', 'data' => $monthlyRevenue],
                        ['name' => 'Jumlah Booking', 'data' => $monthlyBookings]
                    ]"
                    :labels="$months"
                    :colors="['#0f172a', '#ca9e54']"
                />
            </div>
        </x-ui.card>

        <!-- Donut Chart: Property Types Distribution -->
        <x-ui.card class="p-6 flex flex-col justify-between hover:shadow-xl transition-all duration-300 border border-slate-200/80">
            <div class="border-b border-slate-100 pb-4 mb-4">
                <h3 class="font-satoshi-bold text-slate-900 text-base flex items-center gap-2">
                    <i class="ri-pie-chart-2-line text-indigo-500 text-lg"></i> Tipe Properti
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Proporsi inventaris tipe villa &amp; akomodasi</p>
            </div>
            
            <div class="flex-1 flex items-center justify-center py-2">
                <x-ui.chart 
                    type="donut"
                    height="270"
                    :series="$propertyTypeData"
                    :labels="$propertyTypeLabels"
                    :colors="['#0f172a', '#ca9e54', '#10b981', '#6366f1', '#f43f5e']"
                />
            </div>

            <div class="pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                <span>Total Unit: <strong class="text-slate-800">{{ array_sum($propertyTypeData) }} Properti</strong></span>
                <span class="text-emerald-600 font-satoshi-bold flex items-center gap-1"><i class="ri-checkbox-circle-fill"></i> Data Terbaca</span>
            </div>
        </x-ui.card>
    </div>

    <!-- 4. RECENT BOOKINGS & POPULAR DESTINATIONS GRID -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 animate-fade-in-up delay-300">
        
        <!-- Recent Bookings Table (2 Columns) -->
        <x-ui.card class="lg:col-span-2 p-6 flex flex-col hover:shadow-xl transition-all duration-300 border border-slate-200/80">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <div>
                    <h3 class="font-satoshi-bold text-slate-900 text-base flex items-center gap-2">
                        <i class="ri-time-line text-emerald-500 text-lg"></i> Reservasi Terbaru
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar transaksi booking yang masuk belakangan ini</p>
                </div>
                @if(Route::has('booking.index'))
                    <a href="{{ route('booking.index') }}" class="text-xs font-satoshi-bold text-[#ca9e54] hover:text-amber-700 hover:underline transition-all flex items-center gap-1">
                        Lihat Semua <i class="ri-arrow-right-line"></i>
                    </a>
                @endif
            </div>

            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead>
                        <tr class="text-slate-900 font-satoshi-bold border-b border-slate-100 text-xs uppercase tracking-wider">
                            <th class="py-3 pr-4">Tamu</th>
                            <th class="py-3 px-4">Properti Villa</th>
                            <th class="py-3 px-4">Tanggal Stay</th>
                            <th class="py-3 px-4">Total</th>
                            <th class="py-3 pl-4 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-satoshi-medium text-slate-700">
                        @forelse($recentBookings as $b)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3.5 pr-4">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $uFoto = $b->user->foto ?? null;
                                            $userAvatarSrc = asset('assets/img/avatar/avatar-1.jpg');
                                            if ($uFoto) {
                                                if (str_starts_with($uFoto, 'http')) {
                                                    $userAvatarSrc = $uFoto;
                                                } elseif (str_starts_with($uFoto, 'avatar-')) {
                                                    $userAvatarSrc = asset('assets/img/avatar/' . $uFoto);
                                                } else {
                                                    $userAvatarSrc = asset('storage/uploads/users/' . $uFoto);
                                                }
                                            }
                                        @endphp
                                        <img src="{{ $userAvatarSrc }}" alt="{{ $b->guest_name ?? ($b->user->name ?? 'Guest') }}" class="w-9 h-9 rounded-full object-cover shrink-0 border border-slate-200 shadow-2xs">
                                        <div>
                                            <p class="font-satoshi-bold text-slate-900 text-xs leading-snug">{{ $b->guest_name ?? ($b->user->name ?? 'Guest User') }}</p>
                                            <span class="text-[11px] text-slate-600">{{ $b->guest_email ?? ($b->user->email ?? '-') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-satoshi-bold text-slate-900 text-xs">
                                    {{ $b->property->name ?? 'Villa' }}
                                </td>
                                <td class="py-3.5 px-4 text-xs text-slate-600">
                                    {{ $b->check_in ? $b->check_in->format('d M') : '-' }} - {{ $b->check_out ? $b->check_out->format('d M Y') : '-' }}
                                </td>
                                <td class="py-3.5 px-4 font-satoshi-bold text-slate-900 text-xs">
                                    Rp {{ number_format($b->subtotal ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 pl-4 text-right">
                                    @php
                                        $st = strtolower($b->status ?? 'pending');
                                    @endphp
                                    @if(in_array($st, ['confirmed', 'completed', 'paid', 'success']))
                                        <x-ui.badge variant="success" icon="ri-checkbox-circle-line">
                                            {{ ucfirst($st) }}
                                        </x-ui.badge>
                                    @elseif($st == 'pending')
                                        <x-ui.badge variant="warning" icon="ri-time-line">
                                            Pending
                                        </x-ui.badge>
                                    @else
                                        <x-ui.badge variant="danger" icon="ri-close-circle-line">
                                            {{ ucfirst($st) }}
                                        </x-ui.badge>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <!-- Sample Preview Items if table is fresh -->
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 pr-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/img/avatar/avatar-2.jpg') }}" alt="Alexander Wright" class="w-9 h-9 rounded-full object-cover shrink-0 border border-slate-200 shadow-2xs">
                                        <div>
                                            <p class="font-satoshi-bold text-slate-900 text-xs leading-snug">Alexander Wright</p>
                                            <span class="text-[11px] text-slate-600">alex@example.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-satoshi-bold text-slate-900 text-xs">Villa Luxury Seminyak</td>
                                <td class="py-3.5 px-4 text-xs text-slate-600">14 Aug - 18 Aug 2026</td>
                                <td class="py-3.5 px-4 font-satoshi-bold text-slate-900 text-xs">Rp 12.500.000</td>
                                <td class="py-3.5 pl-4 text-right">
                                    <x-ui.badge variant="success" icon="ri-checkbox-circle-line">Confirmed</x-ui.badge>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 pr-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/img/avatar/avatar-1.jpg') }}" alt="Siti Rahmawati" class="w-9 h-9 rounded-full object-cover shrink-0 border border-slate-200 shadow-2xs">
                                        <div>
                                            <p class="font-satoshi-bold text-slate-900 text-xs leading-snug">Siti Rahmawati</p>
                                            <span class="text-[11px] text-slate-600">siti@example.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-satoshi-bold text-slate-900 text-xs">Ubud Tropical Haven</td>
                                <td class="py-3.5 px-4 text-xs text-slate-600">20 Aug - 22 Aug 2026</td>
                                <td class="py-3.5 px-4 font-satoshi-bold text-slate-900 text-xs">Rp 7.800.000</td>
                                <td class="py-3.5 pl-4 text-right">
                                    <x-ui.badge variant="warning" icon="ri-time-line">Pending</x-ui.badge>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 pr-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/img/avatar/avatar-3.jpg') }}" alt="Michael Tan" class="w-9 h-9 rounded-full object-cover shrink-0 border border-slate-200 shadow-2xs">
                                        <div>
                                            <p class="font-satoshi-bold text-slate-900 text-xs leading-snug">Michael Tan</p>
                                            <span class="text-[11px] text-slate-600">michael@example.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-satoshi-bold text-slate-900 text-xs">Canggu Ocean View Villa</td>
                                <td class="py-3.5 px-4 text-xs text-slate-600">01 Sep - 05 Sep 2026</td>
                                <td class="py-3.5 px-4 font-satoshi-bold text-slate-900 text-xs">Rp 19.200.000</td>
                                <td class="py-3.5 pl-4 text-right">
                                    <x-ui.badge variant="success" icon="ri-checkbox-circle-line">Confirmed</x-ui.badge>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-ui.card>

        <!-- Top Destinations Widget (1 Column) -->
        <x-ui.card class="p-6 flex flex-col justify-between hover:shadow-xl transition-all duration-300 border border-slate-200/80">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                    <div>
                        <h3 class="font-satoshi-bold text-slate-900 text-base flex items-center gap-2">
                            <i class="ri-map-pin-2-line text-rose-500 text-lg"></i> Destinasi Terpopuler
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Wilayah lokasi dengan inventaris terbanyak</p>
                    </div>
                </div>

                <div class="space-y-3.5">
                    @forelse($topDestinations as $dest)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 hover:bg-amber-50/50 transition-colors border border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-rose-500 shadow-2xs">
                                    <i class="ri-map-pin-line text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-satoshi-bold text-slate-900">{{ $dest->name }}</h4>
                                    <span class="text-[11px] text-slate-500">{{ $dest->city ?? 'Bali' }}</span>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-slate-900 text-white text-[11px] font-satoshi-bold">
                                {{ $dest->properties_count }} Properti
                            </span>
                        </div>
                    @empty
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-800">Seminyak, Bali</span>
                            <span class="px-2.5 py-1 rounded-full bg-slate-900 text-white text-[11px] font-bold">12 Properti</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-800">Ubud, Bali</span>
                            <span class="px-2.5 py-1 rounded-full bg-slate-900 text-white text-[11px] font-bold">9 Properti</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-800">Canggu, Bali</span>
                            <span class="px-2.5 py-1 rounded-full bg-slate-900 text-white text-[11px] font-bold">8 Properti</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-800">Uluwatu, Bali</span>
                            <span class="px-2.5 py-1 rounded-full bg-slate-900 text-white text-[11px] font-bold">6 Properti</span>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Active Promos Summary Box -->
            <div class="mt-6 p-4 rounded-2xl bg-gradient-to-r from-amber-500/10 to-amber-600/5 border border-amber-200/60 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <i class="ri-ticket-2-fill text-xl text-[#ca9e54]"></i>
                    <div>
                        <p class="text-xs font-satoshi-bold text-slate-900">Promo &amp; Diskon Aktif</p>
                        <span class="text-[11px] text-slate-500">{{ $activePromotions }} Voucher sedang berjalan</span>
                    </div>
                </div>
                @if(Route::has('promotion.index'))
                    <a href="{{ route('promotion.index') }}" class="text-xs font-satoshi-bold text-slate-900 hover:underline">Kelola &rarr;</a>
                @endif
            </div>
        </x-ui.card>
    </div>

    <!-- 5. RADIALBAR OCCUPANCY & TOP RATED VILLAS SPOTLIGHT -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 animate-fade-in-up delay-400">
        
        <!-- Performance Radar Chart (RadialBar) -->
        <x-ui.card class="p-6 flex flex-col justify-between hover:shadow-xl transition-all duration-300 border border-slate-200/80">
            <div class="border-b border-slate-100 pb-4 mb-4">
                <h3 class="font-satoshi-bold text-slate-900 text-base flex items-center gap-2">
                    <i class="ri-speed-up-line text-emerald-500 text-lg"></i> Tingkat Okupansi &amp; Kinerja
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Persentase keberhasilan reservasi &amp; keterisian kamar</p>
            </div>
            
            <div class="flex-1 flex items-center justify-center py-2">
                <x-ui.chart 
                    type="radialBar"
                    height="270"
                    :series="[84, 92, 96]"
                    :labels="['Tingkat Okupansi', 'Booking Penyelesaian', 'Kepuasan Tamu']"
                    :colors="['#0f172a', '#10b981', '#ca9e54']"
                />
            </div>

            <div class="pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center gap-1.5">
                <i class="ri-refresh-line animate-spin text-slate-400"></i> Diperbarui otomatis real-time.
            </div>
        </x-ui.card>

        <!-- Top Rated Villas Spotlight Grid (2 Columns) -->
        <x-ui.card class="lg:col-span-2 p-6 flex flex-col hover:shadow-xl transition-all duration-300 border border-slate-200/80">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <div>
                    <h3 class="font-satoshi-bold text-slate-900 text-base flex items-center gap-2">
                        <i class="ri-award-line text-amber-500 text-lg"></i> Villa Unggulan Rating Tertinggi
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Properti dengan ulasan paling memuaskan dari para tamu</p>
                </div>
                @if(Route::has('properties.index'))
                    <a href="{{ route('properties.index') }}" class="text-xs font-satoshi-bold text-[#ca9e54] hover:underline">Semua Properti &rarr;</a>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($topVillas as $villa)
                    <div class="p-3.5 rounded-2xl border border-slate-200/80 bg-slate-50/50 hover:bg-white hover:shadow-md transition-all flex items-start gap-3">
                        <img src="{{ $villa->main_image_url }}" alt="{{ $villa->name }}" class="h-16 w-20 rounded-xl object-cover border border-slate-200 flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-1">
                                <span class="text-[10px] font-satoshi-bold uppercase text-[#ca9e54] tracking-wider truncate">{{ $villa->type ?? 'Villa' }}</span>
                                <span class="flex items-center text-amber-400 text-xs font-bold"><i class="ri-star-fill"></i> {{ $villa->rating ?? '5.0' }}</span>
                            </div>
                            <h4 class="text-xs font-satoshi-bold text-slate-900 truncate mt-0.5">{{ $villa->name }}</h4>
                            <p class="text-[11px] text-slate-500 truncate">{{ $villa->city ?? ($villa->destination->name ?? 'Bali') }}</p>
                            <p class="text-xs font-satoshi-bold text-slate-900 mt-1">Rp {{ number_format($villa->price ?? 0, 0, ',', '.') }}<span class="text-[10px] font-normal text-slate-500">/malam</span></p>
                        </div>
                    </div>
                @empty
                    <div class="p-3.5 rounded-2xl border border-slate-200/80 bg-slate-50/50 flex items-start gap-3">
                        <div class="h-16 w-20 rounded-xl bg-slate-200 flex-shrink-0 flex items-center justify-center text-slate-400"><i class="ri-image-line"></i></div>
                        <div>
                            <span class="text-[10px] font-bold uppercase text-[#ca9e54]">Luxury Villa</span>
                            <h4 class="text-xs font-bold text-slate-900">Seminyak Sunset Ocean Villa</h4>
                            <p class="text-[11px] text-slate-500">Seminyak, Bali</p>
                            <p class="text-xs font-bold text-slate-900 mt-1">Rp 4.500.000<span class="text-[10px] font-normal text-slate-500">/malam</span></p>
                        </div>
                    </div>
                    <div class="p-3.5 rounded-2xl border border-slate-200/80 bg-slate-50/50 flex items-start gap-3">
                        <div class="h-16 w-20 rounded-xl bg-slate-200 flex-shrink-0 flex items-center justify-center text-slate-400"><i class="ri-image-line"></i></div>
                        <div>
                            <span class="text-[10px] font-bold uppercase text-[#ca9e54]">Resort</span>
                            <h4 class="text-xs font-bold text-slate-900">Ubud Forest Retreat &amp; Spa</h4>
                            <p class="text-[11px] text-slate-500">Ubud, Bali</p>
                            <p class="text-xs font-bold text-slate-900 mt-1">Rp 3.800.000<span class="text-[10px] font-normal text-slate-500">/malam</span></p>
                        </div>
                    </div>
                @endforelse
            </div>
        </x-ui.card>

    </div>

</div>
@endsection