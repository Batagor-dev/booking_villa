@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Bookings';

    if (isset($booking)) {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName(), $booking);
    } else {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName());
    }
    $breadcrumb_parent = $breadcrumbsData->where('title', '!=', $breadcrumb->title)->last();
@endphp

@extends('layouts.backend.main')

@section('title', 'Booking Form')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
    <form method="POST" action="{{ $action }}" class="space-y-6">
        @method('PUT')
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Column: Primary Content (Guest Info & Notes) -->
            <div class="lg:col-span-8 space-y-6">
                <x-ui.card>
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                        <div>
                            <span class="text-xs font-mono font-bold text-slate-400 uppercase tracking-wider block">KODE BOOKING</span>
                            <h5 class="text-xl font-satoshi-bold text-slate-900 mb-0">#{{ $booking->booking_code }}</h5>
                        </div>
                        <div>
                            @if($booking->status === 'confirmed')
                                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-satoshi-bold border border-emerald-200">Confirmed</span>
                            @elseif($booking->status === 'cancelled')
                                <span class="px-3 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-satoshi-bold border border-rose-200">Cancelled</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-satoshi-bold border border-amber-200">Pending</span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Guest Name -->
                        <x-ui.input 
                            name="guest_name" 
                            label="Nama Lengkap Tamu" 
                            placeholder="Full Name" 
                            value="{{ old('guest_name', $booking->guest_name) }}"
                            required
                        />

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Guest Email -->
                            <x-ui.input 
                                type="email"
                                name="guest_email" 
                                label="Email Tamu" 
                                placeholder="guest@example.com" 
                                value="{{ old('guest_email', $booking->guest_email) }}"
                                required
                            />

                            <!-- Guest Phone -->
                            <x-ui.input 
                                name="guest_phone" 
                                label="Nomor Telepon / WhatsApp" 
                                placeholder="+62 812 3456 7890" 
                                value="{{ old('guest_phone', $booking->guest_phone) }}"
                                required
                            />
                        </div>

                        <!-- Admin Notes -->
                        <div>
                            <x-ui.textarea 
                                name="notes" 
                                label="Catatan Khusus / Admin Notes" 
                                placeholder="Tambahkan catatan khusus atau instruksi verifikasi..."
                                value="{{ old('notes', $booking->notes) }}"
                                rows="4"
                            />
                        </div>
                    </div>
                </x-ui.card>
            </div>

            <!-- Right Column: Settings & Media -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Status Selection -->
                <x-ui.card>
                    <h5 class="text-lg font-satoshi-bold text-slate-900 mb-4">Status & Payment</h5>
                    
                    <div class="space-y-6">
                        <x-ui.select2 
                            name="status" 
                            label="Status Reservasi" 
                            placeholder="-- Choose Status --" 
                            :options="$statuses"
                            :value="old('status', $booking->status)"
                            required
                        />
                    </div>
                </x-ui.card>

                <!-- Reservation Summary -->
                <x-ui.card>
                    <h5 class="text-lg font-satoshi-bold text-slate-900 mb-4">Reservation Summary</h5>
                    
                    <div class="space-y-3 text-xs font-satoshi-medium text-slate-700">
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Properti:</span>
                            <strong class="text-slate-900 text-sm font-satoshi-bold">{{ $booking->property->name ?? 'Deleted' }}</strong>
                        </div>

                        <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100">
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Check-In:</span>
                                <span class="text-slate-900 font-bold">{{ $booking->check_in ? $booking->check_in->format('d M Y') : '-' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Check-Out:</span>
                                <span class="text-slate-900 font-bold">{{ $booking->check_out ? $booking->check_out->format('d M Y') : '-' }}</span>
                            </div>
                        </div>

                        <div class="pt-2 border-t border-slate-100 flex justify-between items-center">
                            <span class="text-slate-500 font-bold">Durasi:</span>
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800 text-[11px] font-bold border border-slate-200">
                                {{ $booking->total_nights }} Malam
                            </span>
                        </div>

                        <div class="pt-2 border-t border-slate-100 flex justify-between items-center">
                            <span class="text-slate-500 font-bold">Total Harga:</span>
                            <span class="text-base font-satoshi-bold text-slate-900">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </x-ui.card>

                <!-- Bukti Pembayaran -->
                <x-ui.card>
                    <h5 class="text-lg font-satoshi-bold text-slate-900 mb-4 flex items-center justify-between">
                        <span>Bukti Pembayaran</span>
                        <span class="text-xs text-slate-500 font-normal">{{ $booking->paymentMethod->name ?? ($booking->payment_type ?? '-') }}</span>
                    </h5>

                    @if($booking->bukti_payment)
                        <div class="space-y-3">
                            <div class="rounded-2xl overflow-hidden border border-slate-200 bg-slate-100">
                                <img src="{{ asset('storage/' . $booking->bukti_payment) }}" class="w-full h-48 object-cover transition-transform hover:scale-105">
                            </div>
                            <a href="{{ asset('storage/' . $booking->bukti_payment) }}" target="_blank" class="block w-full text-center py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-satoshi-bold transition">
                                <i class="ri-external-link-line mr-1"></i> Lihat Gambar Ukuran Asli
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8 text-slate-400 text-xs font-satoshi-medium border border-dashed border-slate-200 rounded-2xl">
                            Belum ada bukti pembayaran yang diunggah.
                        </div>
                    @endif
                </x-ui.card>
            </div>
        </div>

        <!-- Form Actions (Outside Card, Matching Article Form) -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <x-ui.button type="button" font="medium" size="sm" style="secondary" onclick="window.location.href='{{ $breadcrumb_parent?->url ?? route('bookings.index') }}'">
                Cancel
            </x-ui.button>
            <x-ui.button type="submit" font="bold" size="sm">
                Submit
            </x-ui.button>
        </div>
    </form>
@endsection

@push('scripts')
    {{-- SweetAlert otomatis --}}
    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Success', text: "{{ session('success') }}" });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}" });
        </script>
    @endif
@endpush
