@extends('layouts.backend.main')

@section('sub_title', 'Notifikasi Pesanan')

@section('breadcrumb')
    <x-layout.admin.breadcrumb :items="[
        ['title' => 'Dashboard', 'url' => route('dashboard')],
        ['title' => 'Notifikasi Pesanan', 'url' => '#'],
    ]" />
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Stats & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
        <div>
            <h1 class="text-xl font-satoshi-bold text-slate-900">Pusat Notifikasi & Riwayat Aktivitas Pesanan</h1>
            <p class="text-xs font-satoshi-medium text-slate-500 mt-1">
                Pantau reservasi baru yang masuk dan pesanan yang dibatalkan secara real-time.
            </p>
        </div>

        <div class="flex items-center gap-3">
            @if($unreadCount > 0)
                <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-[#ca9e54] hover:bg-[#b58b43] text-white rounded-xl text-xs font-satoshi-bold transition-all shadow-xs flex items-center gap-2 cursor-pointer"
                    >
                        <i class="ri-check-double-line text-base"></i>
                        <span>Tandai Semua Dibaca</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-200 pb-3 overflow-x-auto no-scrollbar">
        <a 
            href="{{ route('admin.notifications.index') }}" 
            class="px-4 py-2 rounded-xl text-xs font-satoshi-bold transition-all whitespace-nowrap {{ !$type && !$status ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}"
        >
            Semua ({{ $totalCount }})
        </a>
        <a 
            href="{{ route('admin.notifications.index', ['status' => 'unread']) }}" 
            class="px-4 py-2 rounded-xl text-xs font-satoshi-bold transition-all whitespace-nowrap {{ $status === 'unread' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}"
        >
            Belum Dibaca ({{ $unreadCount }})
        </a>
        <a 
            href="{{ route('admin.notifications.index', ['type' => 'order_created']) }}" 
            class="px-4 py-2 rounded-xl text-xs font-satoshi-bold transition-all whitespace-nowrap {{ $type === 'order_created' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}"
        >
            <i class="ri-calendar-check-line mr-1 text-[#ca9e54]"></i> Order Masuk ({{ $orderCreatedCount }})
        </a>
        <a 
            href="{{ route('admin.notifications.index', ['type' => 'order_cancelled']) }}" 
            class="px-4 py-2 rounded-xl text-xs font-satoshi-bold transition-all whitespace-nowrap {{ $type === 'order_cancelled' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}"
        >
            <i class="ri-close-circle-line mr-1 text-[#ca9e54]"></i> Order Dibatalkan ({{ $orderCancelledCount }})
        </a>
    </div>

    <!-- Notification Cards List -->
    @if($notifications->count() > 0)
        <div class="space-y-4">
            @foreach($notifications as $item)
                @php
                    $data = $item->data ?? [];
                    $isCancelled = $item->type === 'order_cancelled';
                    $isConfirmed = $item->type === 'order_confirmed';
                    $isCreated = $item->type === 'order_created';
                    $isUnread = $item->isUnread();
                    
                    $bookingUuid = $data['booking_uuid'] ?? ($item->booking->uuid ?? null);
                @endphp

                <div class="bg-white rounded-2xl border transition-all duration-200 p-5 sm:p-6 {{ $isUnread ? 'border-[#ca9e54]/50 bg-amber-50/15 shadow-xs ring-1 ring-[#ca9e54]/30' : 'border-slate-200/80 shadow-xs' }}">
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                        
                        <!-- Main Info & Snapshot -->
                        <div class="flex items-start gap-4 flex-1">
                            <!-- Type Icon (Uniform Color Style) -->
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-[#ca9e54] border border-amber-200/60 shadow-xs">
                                @if($isCancelled)
                                    <i class="ri-close-circle-fill text-2xl"></i>
                                @elseif($isConfirmed)
                                    <i class="ri-checkbox-circle-fill text-2xl"></i>
                                @else
                                    <i class="ri-calendar-check-fill text-2xl"></i>
                                @endif
                            </div>

                            <div class="space-y-3 flex-1">
                                <div>
                                    <div class="flex flex-wrap items-center gap-2 mb-1">
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-satoshi-bold uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $item->title }}
                                        </span>

                                        @if($isUnread)
                                            <span class="px-2 py-0.5 rounded-full bg-rose-500 text-white text-[10px] font-satoshi-bold animate-pulse">
                                                Baru
                                            </span>
                                        @endif

                                        <span class="text-xs text-slate-400 font-satoshi-medium">
                                            • {{ $item->created_at->format('d M Y, H:i') }} ({{ $item->created_at->diffForHumans() }})
                                        </span>
                                    </div>

                                    <h3 class="text-base font-satoshi-bold text-slate-900">
                                        {{ $item->message }}
                                    </h3>
                                </div>

                                <!-- Snapshot Data Grid -->
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/70 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
                                    <!-- Booking Code -->
                                    <div>
                                        <span class="text-slate-400 font-satoshi-medium block mb-0.5">Kode Booking</span>
                                        <span class="font-mono font-bold text-slate-900 bg-white px-2 py-0.5 rounded border border-slate-200 inline-block">
                                            {{ $data['booking_code'] ?? ($item->booking->booking_code ?? '-') }}
                                        </span>
                                    </div>

                                    <!-- Guest -->
                                    <div>
                                        <span class="text-slate-400 font-satoshi-medium block mb-0.5">Nama Tamu</span>
                                        <span class="font-satoshi-bold text-slate-800">
                                            {{ $data['guest_name'] ?? ($item->booking->guest_name ?? '-') }}
                                        </span>
                                        @if(!empty($data['guest_phone']))
                                            <span class="text-slate-400 block text-[11px]">{{ $data['guest_phone'] }}</span>
                                        @endif
                                    </div>

                                    <!-- Property & Dates -->
                                    <div>
                                        <span class="text-slate-400 font-satoshi-medium block mb-0.5">Villa / Periode</span>
                                        <span class="font-satoshi-bold text-slate-800 truncate block">
                                            {{ $data['property_name'] ?? ($item->booking->property->name ?? '-') }}
                                        </span>
                                        @if(!empty($data['check_in']) && !empty($data['check_out']))
                                            <span class="text-slate-500 block text-[11px]">
                                                {{ $data['check_in'] }} - {{ $data['check_out'] }} ({{ $data['total_nights'] ?? 1 }} Malam)
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Total Amount -->
                                    <div>
                                        <span class="text-slate-400 font-satoshi-medium block mb-0.5">Total Biaya</span>
                                        <span class="font-satoshi-bold text-emerald-700 text-sm">
                                            {{ isset($data['total_price']) ? 'Rp ' . number_format($data['total_price'], 0, ',', '.') : '-' }}
                                        </span>
                                        @if(!empty($data['payment_type']))
                                            <span class="text-slate-400 block text-[11px] truncate">{{ $data['payment_type'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex md:flex-col items-center md:items-end justify-end gap-2 shrink-0 pt-2 md:pt-0">
                            @if($bookingUuid)
                                <a 
                                    href="{{ route('admin.notifications.read', $item->uuid) }}" 
                                    class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-satoshi-bold transition-all shadow-xs flex items-center gap-1.5 whitespace-nowrap"
                                >
                                    <span>Lihat Reservasi</span>
                                    <i class="ri-arrow-right-up-line text-sm"></i>
                                </a>
                            @endif

                            <form action="{{ route('admin.notifications.destroy', $item->uuid) }}" method="POST" class="inline-block m-0">
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="button" 
                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-colors cursor-pointer delete-btn"
                                    title="Hapus Notifikasi"
                                >
                                    <i class="ri-delete-bin-line text-base"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            <div class="pt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/80 shadow-xs">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-slate-100 text-slate-400 mb-4">
                <i class="ri-notification-off-line text-3xl"></i>
            </div>
            <h3 class="text-base font-satoshi-bold text-slate-800">Tidak ada notifikasi yang ditemukan</h3>
            <p class="text-xs font-satoshi-medium text-slate-400 max-w-sm mx-auto mt-1">
                Semua notifikasi pesanan masuk atau pembatalan dari pelanggan akan tercatat otomatis di sini.
            </p>
        </div>
    @endif
</div>
@endsection
