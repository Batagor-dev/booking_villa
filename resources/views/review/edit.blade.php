@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Moderasi Ulasan';
    $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName(), $review);
@endphp

@extends('layouts.backend.main')

@section('title', 'Moderasi Ulasan')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
    <div class="space-y-6 font-satoshi">
        <x-ui.card>
            <h5 class="text-lg font-satoshi-bold text-slate-900 mb-6">{{ $sub_title }}</h5>

            <div class="space-y-6">
                <!-- User & Property Banner -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    @php
                        $u = $review->user;
                        $userAvatar = ($u && $u->foto && str_starts_with($u->foto, 'http'))
                            ? $u->foto
                            : (($u && $u->foto && (str_starts_with($u->foto, 'avatar-') || str_contains($u->foto, '.')))
                                ? asset('assets/img/avatar/' . $u->foto)
                                : asset('assets/img/avatar/avatar-1.jpg'));
                    @endphp
                    <div class="flex items-center gap-4">
                        <img src="{{ $userAvatar }}" alt="{{ $review->user->name ?? 'Guest User' }}" class="w-12 h-12 rounded-full object-cover border border-slate-200 shrink-0 shadow-xs">
                        <div>
                            <h4 class="font-satoshi-bold text-sm text-slate-900">{{ $review->user->name ?? 'Guest User' }}</h4>
                            <p class="text-xs text-slate-400 font-mono">{{ $review->user->email ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="text-left md:text-right border-t md:border-t-0 border-slate-200 pt-2 md:pt-0">
                        <span class="text-[10px] uppercase tracking-wider text-slate-400 font-satoshi-bold block">Villa Properti:</span>
                        <strong class="text-xs font-satoshi-bold text-slate-900">{{ $review->property->name ?? '-' }}</strong>
                        @if($review->booking)
                            <div class="text-[11px] font-mono text-slate-500">Kode Booking: #{{ $review->booking->booking_code }}</div>
                        @endif
                    </div>
                </div>

                <!-- Review Comment & Rating Content -->
                <div class="space-y-3 p-4 rounded-2xl border border-slate-100 bg-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="flex text-amber-400 text-base">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $review->rating ? 'ri-star-fill' : 'ri-star-line text-slate-200' }}"></i>
                                @endfor
                            </div>
                            <span class="text-xs font-satoshi-bold text-slate-800">({{ $review->rating }}.0 / 5.0)</span>
                        </div>
                        <span class="text-xs text-slate-400">{{ $review->created_at ? $review->created_at->format('d M Y, H:i') : '' }}</span>
                    </div>

                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-satoshi-medium">
                        "{{ $review->comment }}"
                    </p>
                </div>

                <!-- MODERATION FORM -->
                <form action="{{ route('reviews.update', $review->uuid) }}" method="POST" class="space-y-6 pt-4 border-t border-slate-100">
                    @csrf
                    @method('PUT')

                    <!-- Status Moderation Radio Cards -->
                    <div>
                        <label class="block text-sm font-satoshi-medium text-slate-700 mb-3">Status Moderasi Ulasan</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <x-ui.radio-card 
                                name="status" 
                                value="approved" 
                                :checked="old('status', $review->status) === 'approved'" 
                                label="Dipublikasikan" 
                                description="Tampil pada halaman publik villa" 
                                color="emerald" 
                            />

                            <x-ui.radio-card 
                                name="status" 
                                value="pending" 
                                :checked="old('status', $review->status) === 'pending'" 
                                label="Pending" 
                                description="Menunggu tinjauan tim moderasi" 
                                color="amber" 
                            />

                            <x-ui.radio-card 
                                name="status" 
                                value="rejected" 
                                :checked="old('status', $review->status) === 'rejected'" 
                                label="Ditolak / Sembunyikan" 
                                description="Sembunyikan dari halaman publik" 
                                color="rose" 
                            />
                        </div>
                    </div>

                    <!-- Admin Reply Textarea Component -->
                    <div>
                        <x-ui.textarea 
                            name="admin_reply" 
                            label="Balasan Resmi Admin / Pengelola Villa (Opsional)" 
                            placeholder="Tuliskan apresiasi atau tanggapan resmi dari manajemen villa..." 
                            :value="old('admin_reply', $review->admin_reply)" 
                            rows="4" 
                        />
                        <p class="text-[11px] text-slate-400 mt-1">Balasan admin akan ditampilkan secara resmi tepat di bawah ulasan pengguna.</p>
                    </div>

                    <!-- Submit / Cancel Buttons using Standard Admin Component -->
                    <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                        <x-ui.button type="button" font="medium" size="sm" style="secondary" onclick="window.location.href='{{ route('reviews.index') }}'">
                            Cancel
                        </x-ui.button>
                        <x-ui.button type="submit" font="bold" size="sm">
                            Submit
                        </x-ui.button>
                    </div>
                </form>

            </div>
        </x-ui.card>
    </div>
@endsection
