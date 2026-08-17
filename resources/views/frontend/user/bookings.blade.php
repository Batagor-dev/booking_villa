@extends('layouts.frontend.main')

@section('title', 'My Bookings & Riwayat Reservasi - Palma Luxury')

@section('content')
    <!-- HERO HEADER -->
    <section class="relative pt-32 pb-12 px-4 sm:px-6 md:px-12 bg-[#152c4e] text-white font-satoshi overflow-hidden">
        <div class="absolute inset-0 opacity-15 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=80" alt="Villa Sanctuary" class="w-full h-full object-cover">
        </div>
        <div class="max-w-7xl mx-auto relative z-10">
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs text-white/70 mb-3 font-medium">
                <a href="{{ route('home') }}" class="hover:text-[#ca9e54] transition-colors">{{ __('frontend.nav.home') }}</a>
                <span>/</span>
                <span class="text-white font-semibold">{{ __('frontend.nav.my_bookings') }}</span>
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <span class="text-[10px] sm:text-xs font-bold tracking-[0.25em] text-[#e5c382] uppercase block mb-1">{{ __('frontend.user.customer_portal') }}</span>
                    <h1 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-normal text-white">
                        {{ __('frontend.user.my_bookings_title') }}
                    </h1>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('villa.index') }}" class="px-5 py-2.5 rounded-full bg-[#ca9e54] hover:bg-[#b88c43] text-white text-xs font-bold transition shadow-md flex items-center gap-1.5">
                        <i class="ri-add-line text-sm"></i> {{ __('frontend.user.book_new_villa') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN DASHBOARD CONTENT -->
    <section class="py-10 sm:py-14 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi">
    
        <!-- FILTER TABS -->
        <div class="flex items-center gap-2 mb-8 border-b border-slate-200 overflow-x-auto no-scrollbar pb-3">
            <a href="{{ route('user.bookings') }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ !$statusFilter ? 'bg-[#152c4e] text-white shadow' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                {{ __('frontend.user.tab_all_bookings') }} ({{ $totalCount }})
            </a>
            <a href="{{ route('user.bookings', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $statusFilter === 'pending' ? 'bg-amber-500 text-white shadow' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                {{ __('frontend.user.tab_pending') }} ({{ $pendingCount }})
            </a>
            <a href="{{ route('user.bookings', ['status' => 'confirmed']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $statusFilter === 'confirmed' ? 'bg-emerald-600 text-white shadow' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                {{ __('frontend.user.tab_confirmed') }} ({{ $confirmedCount }})
            </a>
            <a href="{{ route('user.bookings', ['status' => 'cancelled']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $statusFilter === 'cancelled' ? 'bg-rose-600 text-white shadow' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                {{ __('frontend.user.tab_cancelled') }} ({{ $cancelledCount }})
            </a>
        </div>

        <!-- BOOKING LIST CARDS -->
        @if($bookings->count() > 0)
            <div class="space-y-6">
                @foreach($bookings as $b)
                    @php
                        $prop = $b->property;
                    @endphp

                    <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-100 shadow-xs hover:shadow-sm transition space-y-4">
                        
                        <!-- Header Row -->
                        <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 bg-slate-100 text-slate-900 rounded-lg font-mono font-bold text-xs border border-slate-200">
                                    #{{ $b->booking_code }}
                                </span>
                                <span class="text-xs text-slate-400 font-medium">
                                    Dibuat pada {{ $b->created_at->format('d M Y, H:i') }} WITA
                                </span>
                            </div>

                            <!-- Status Badge -->
                            <div>
                                @if($b->status === 'confirmed')
                                    <span class="px-3.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold flex items-center gap-1.5">
                                        <i class="ri-checkbox-circle-fill text-emerald-500"></i> Reservasi Disetujui
                                    </span>
                                @elseif($b->status === 'cancelled')
                                    <span class="px-3.5 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200 text-xs font-bold flex items-center gap-1.5">
                                        <i class="ri-close-circle-fill text-rose-500"></i> Dibatalkan
                                    </span>
                                @else
                                    <span class="px-3.5 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold flex items-center gap-1.5">
                                        <i class="ri-time-fill text-amber-500"></i> Menunggu Verifikasi Pembayaran
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Content Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-5 items-center">
                            
                            <!-- Property Image & Info (6 Cols) -->
                            <div class="md:col-span-6 flex gap-4 items-center">
                                <div class="w-24 h-24 rounded-2xl overflow-hidden bg-slate-100 shrink-0 border border-slate-100">
                                    <img src="{{ $prop ? $prop->main_image_url : asset('images/no-image.png') }}" alt="{{ $prop->name ?? 'Villa' }}" class="w-full h-full object-cover">
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[10px] font-bold text-[#ca9e54] uppercase tracking-wider block">
                                        {{ $prop->type ?? 'Villa Sanctuary' }}
                                    </span>
                                    <h3 class="font-serif-title text-lg font-bold text-slate-900 line-clamp-1">
                                        {{ $prop->name ?? 'Villa' }}
                                    </h3>
                                    <p class="text-xs text-slate-500 flex items-center gap-1">
                                        <i class="ri-map-pin-line text-slate-400"></i> {{ $prop->city ?? 'Seminyak' }}, {{ $prop->province ?? 'Bali' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Dates & Duration (3 Cols) -->
                            <div class="md:col-span-3 text-xs space-y-1 border-t md:border-t-0 md:border-l border-slate-100 pt-3 md:pt-0 md:pl-5">
                                <div class="flex justify-between md:block">
                                    <span class="text-[10px] text-slate-400 uppercase font-bold block">Check-In:</span>
                                    <strong class="text-slate-900 font-bold">{{ $b->check_in ? $b->check_in->format('d M Y') : '-' }}</strong>
                                </div>
                                <div class="flex justify-between md:block pt-1">
                                    <span class="text-[10px] text-slate-400 uppercase font-bold block">Check-Out:</span>
                                    <strong class="text-slate-900 font-bold">{{ $b->check_out ? $b->check_out->format('d M Y') : '-' }}</strong>
                                </div>
                                <div class="pt-1 text-[#ca9e54] font-bold">
                                    {{ $b->total_nights }} Malam
                                </div>
                            </div>

                            <!-- Payment & Actions (3 Cols) -->
                            <div class="md:col-span-3 text-right space-y-2 border-t md:border-t-0 md:border-l border-slate-100 pt-3 md:pt-0 md:pl-5 flex flex-col justify-between">
                                <div>
                                    <span class="text-[10px] text-slate-400 uppercase font-bold block">Total Biaya:</span>
                                    <x-ui.price :value="$b->total_price" class="text-lg font-bold text-[#152c4e]" />
                                </div>

                                <div class="flex flex-col gap-2 pt-1">
                                    @if($b->status === 'confirmed' && isset($prop->id))
                                        @php
                                            $rev = $b->review;
                                        @endphp
                                        @if(!$rev)
                                            <button type="button" 
                                                    onclick="openReviewModal({{ json_encode([
                                                        'property_id' => $prop->id,
                                                        'booking_id' => $b->id,
                                                        'prop_name' => $prop->name ?? 'Villa',
                                                        'action' => route('reviews.store')
                                                    ]) }})" 
                                                    class="w-full px-4 py-2 rounded-xl bg-[#ca9e54] hover:bg-[#b88c43] text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-xs cursor-pointer">
                                                <i class="ri-star-smile-line"></i> Beri Ulasan Villa
                                            </button>
                                        @else
                                            <a href="{{ route('villa.show', $prop->slug) }}#review-section" 
                                               class="w-full px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center justify-center gap-1.5 border border-slate-200 shadow-2xs">
                                                <i class="ri-checkbox-circle-fill text-emerald-500 text-sm"></i> Ulasan Diberikan
                                            </a>
                                        @endif
                                    @endif
                                    <button type="button" onclick="showInvoiceModal({{ json_encode([
                                        'code' => $b->booking_code,
                                        'prop_name' => $prop->name ?? 'Villa',
                                        'guest_name' => $b->guest_name,
                                        'guest_email' => $b->guest_email,
                                        'guest_phone' => $b->guest_phone,
                                        'check_in' => $b->check_in ? $b->check_in->format('d M Y') : '-',
                                        'check_out' => $b->check_out ? $b->check_out->format('d M Y') : '-',
                                        'total_nights' => $b->total_nights,
                                        'total_price' => format_rupiah($b->total_price),
                                        'payment_method' => $b->paymentMethod->name ?? ($b->payment_type ?? '-'),
                                        'status' => ucfirst($b->status),
                                        'receipt' => $b->bukti_payment ? asset('storage/'.$b->bukti_payment) : null,
                                        'notes' => $b->notes
                                    ]) }})" class="w-full px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition flex items-center justify-center gap-1.5">
                                        <i class="ri-file-text-line"></i> Lihat Bukti & Detail
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <!-- EMPTY STATE -->
            <div class="text-center py-16 px-4 bg-white rounded-3xl border border-slate-100 space-y-4 max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl">
                    <i class="ri-calendar-close-line"></i>
                </div>
                <h3 class="font-serif-title text-xl font-bold text-slate-900">Belum Ada Reservasi</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                    Anda belum memiliki riwayat reservasi villa{{ $statusFilter ? ' dengan status ini' : '' }}. Temukan pelarian mewah Anda sekarang.
                </p>
                <a href="{{ route('villa.index') }}" class="inline-flex items-center gap-2 bg-[#152c4e] hover:bg-[#ca9e54] text-white text-xs font-bold px-6 py-3 rounded-full transition shadow-md uppercase tracking-wider">
                    <i class="ri-search-line"></i> Jelajahi Katalog Villa
                </a>
            </div>
        @endif

    </section>

    <!-- DETAIL INVOICE MODAL -->
    <div id="invoice-modal" onclick="closeInvoiceModal()" class="fixed inset-0 bg-black/80 backdrop-blur-md z-[80] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300 font-satoshi">
        <div class="bg-white rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300 relative" onclick="event.stopPropagation()">
            
            <div class="p-5 bg-[#152c4e] text-white flex items-center justify-between">
                <div>
                    <span class="text-[9px] uppercase font-bold tracking-widest text-[#e5c382] block">INVOICE RESERVASI</span>
                    <h3 class="font-serif-title text-lg font-bold" id="inv-code">#BOOK-0000</h3>
                </div>
                <button type="button" onclick="closeInvoiceModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center cursor-pointer">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto text-xs font-medium text-slate-700">
                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase font-bold block">Villa:</span>
                        <strong class="text-slate-900 text-sm font-bold block" id="inv-prop-name">-</strong>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] text-slate-400 uppercase font-bold block">Status:</span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-200 text-slate-800" id="inv-status">-</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 pt-1">
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase font-bold block">Nama Tamu:</span>
                        <span class="text-slate-900 font-bold block" id="inv-guest-name">-</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase font-bold block">WhatsApp / Telp:</span>
                        <span class="text-slate-900 font-bold block" id="inv-guest-phone">-</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 pt-2 border-t border-slate-100">
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase font-bold block">Check-In:</span>
                        <span class="text-slate-900 font-bold block" id="inv-checkin">-</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase font-bold block">Check-Out:</span>
                        <span class="text-slate-900 font-bold block" id="inv-checkout">-</span>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                    <span>Metode Pembayaran:</span>
                    <strong class="text-slate-900" id="inv-payment-method">-</strong>
                </div>

                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-sm">
                    <span class="font-bold text-slate-900">Total Harga:</span>
                    <strong class="text-xl font-bold text-[#152c4e]" id="inv-total-price">-</strong>
                </div>

                <!-- Receipt Image Container -->
                <div class="pt-3 border-t border-slate-100 space-y-2" id="inv-receipt-container">
                    <span class="text-[10px] text-slate-400 uppercase font-bold block">Bukti Pembayaran Diunggah:</span>
                    <div class="rounded-2xl overflow-hidden border border-slate-200 bg-slate-100">
                        <img id="inv-receipt-img" src="" class="w-full h-44 object-cover">
                    </div>
                </div>
            </div>

            <div class="p-4 bg-slate-50 border-t border-slate-100 text-center">
                <button type="button" onclick="closeInvoiceModal()" class="px-6 py-2 rounded-xl bg-slate-800 text-white text-xs font-bold">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function showInvoiceModal(data) {
            document.getElementById('inv-code').innerText = '#' + data.code;
            document.getElementById('inv-prop-name').innerText = data.prop_name;
            document.getElementById('inv-status').innerText = data.status;
            document.getElementById('inv-guest-name').innerText = data.guest_name;
            document.getElementById('inv-guest-phone').innerText = data.guest_phone;
            document.getElementById('inv-checkin').innerText = data.check_in;
            document.getElementById('inv-checkout').innerText = data.check_out;
            document.getElementById('inv-payment-method').innerText = data.payment_method;
            document.getElementById('inv-total-price').innerText = data.total_price;

            const receiptContainer = document.getElementById('inv-receipt-container');
            const receiptImg = document.getElementById('inv-receipt-img');
            if (data.receipt) {
                receiptImg.src = data.receipt;
                receiptContainer.classList.remove('hidden');
            } else {
                receiptContainer.classList.add('hidden');
            }

            const modal = document.getElementById('invoice-modal');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('opacity-0'), 10);
        }

        function closeInvoiceModal() {
            const modal = document.getElementById('invoice-modal');
            modal.classList.add('opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        // --- BOOKING REVIEW MODAL LOGIC ---
        function openReviewModal(data) {
            if (data.is_edit && !data.is_editable) {
                alert('Ulasan hanya dapat diubah dalam batas waktu 3 jam setelah dikirim.');
                return;
            }

            const modal = document.getElementById('booking-review-modal');
            const modalContent = modal.querySelector('div');
            const form = document.getElementById('rev-modal-form');
            const methodInput = document.getElementById('rev-form-method');
            const propName = document.getElementById('rev-modal-prop-name');
            const propertyIdInput = document.getElementById('rev-form-property-id');
            const bookingIdInput = document.getElementById('rev-form-booking-id');
            const commentInput = document.getElementById('rev-form-comment');
            const submitBtn = document.getElementById('rev-submit-btn');

            propName.textContent = data.prop_name;
            propertyIdInput.value = data.property_id;
            bookingIdInput.value = data.booking_id;
            commentInput.value = data.comment;
            form.action = data.action;

            if (data.is_edit) {
                methodInput.value = 'PUT';
                submitBtn.textContent = 'Perbarui Ulasan';
            } else {
                methodInput.value = 'POST';
                submitBtn.textContent = 'Kirim Ulasan';
            }

            setReviewRating(data.rating || 5);

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function setReviewRating(rating) {
            document.getElementById('rev-form-rating-value').value = rating;
            document.getElementById('rev-rating-text').textContent = rating + ' / 5 Bintang';

            for (let i = 1; i <= 5; i++) {
                const starIcon = document.getElementById('star-icon-' + i);
                if (i <= rating) {
                    starIcon.className = 'ri-star-fill text-[#ca9e54]';
                } else {
                    starIcon.className = 'ri-star-line text-slate-300';
                }
            }
        }

        function closeReviewModal() {
            const modal = document.getElementById('booking-review-modal');
            const modalContent = modal.querySelector('div');
            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // --- VIEW SUBMITTED REVIEW MODAL LOGIC ---
        function openViewReviewModal(data) {
            const modal = document.getElementById('view-review-modal');
            const modalContent = modal.querySelector('div');
            
            document.getElementById('view-rev-prop-name').textContent = data.prop_name;
            document.getElementById('view-rev-date').textContent = data.date;
            document.getElementById('view-rev-comment').textContent = '"' + data.comment + '"';
            document.getElementById('view-rev-prop-link').href = data.prop_url;

            // Render Stars
            const starsContainer = document.getElementById('view-rev-stars');
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= data.rating) {
                    starsHtml += '<i class="ri-star-fill text-[#ca9e54] text-base"></i>';
                } else {
                    starsHtml += '<i class="ri-star-line text-slate-200 text-base"></i>';
                }
            }
            starsHtml += '<span class="text-xs font-bold text-slate-800 ml-1.5">' + data.rating + '.0</span>';
            starsContainer.innerHTML = starsHtml;

            // Admin reply
            const replyBox = document.getElementById('view-rev-reply-box');
            const replyText = document.getElementById('view-rev-reply-text');
            if (data.admin_reply) {
                replyText.textContent = data.admin_reply;
                replyBox.classList.remove('hidden');
            } else {
                replyBox.classList.add('hidden');
            }

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function closeViewReviewModal() {
            const modal = document.getElementById('view-review-modal');
            const modalContent = modal.querySelector('div');
            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>

    <!-- REVIEW SUBMISSION MODAL FOR BOOKING HISTORY -->
    <div id="booking-review-modal" onclick="closeReviewModal()" class="fixed inset-0 bg-black/80 backdrop-blur-md z-[80] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300 font-satoshi">
        <div class="bg-white rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300 relative" onclick="event.stopPropagation()">
            
            <div class="p-5 bg-[#152c4e] text-white flex items-center justify-between">
                <div>
                    <span class="text-[9px] uppercase font-bold tracking-widest text-[#e5c382] block">ULASAN GUEST EXPERIENCE</span>
                    <h3 class="font-serif-title text-lg font-bold" id="rev-modal-prop-name">Nama Villa</h3>
                </div>
                <button type="button" onclick="closeReviewModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center cursor-pointer">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <form id="rev-modal-form" method="POST" class="p-6 space-y-5 text-xs font-medium text-slate-700">
                @csrf
                <input type="hidden" name="_method" id="rev-form-method" value="POST">
                <input type="hidden" name="property_id" id="rev-form-property-id">
                <input type="hidden" name="booking_id" id="rev-form-booking-id">
                <input type="hidden" name="rating" id="rev-form-rating-value" value="5">

                <!-- Star Rating Picker -->
                <div>
                    <label class="block text-xs font-bold text-slate-900 mb-2">Pilih Rating Bintang Anda</label>
                    <div class="flex items-center gap-2 text-2xl text-[#ca9e54]" id="rev-star-container">
                        @for($s = 1; $s <= 5; $s++)
                            <button type="button" onclick="setReviewRating({{ $s }})" class="focus:outline-none cursor-pointer">
                                <i class="ri-star-fill text-[#ca9e54]" id="star-icon-{{ $s }}"></i>
                            </button>
                        @endfor
                        <span class="text-xs font-bold text-slate-800 ml-2" id="rev-rating-text">5 / 5 Bintang</span>
                    </div>
                </div>

                <!-- Comment Input -->
                <div>
                    <label class="block text-xs font-bold text-slate-900 mb-2">Komentar / Pengalaman Menginap</label>
                    <textarea name="comment" id="rev-form-comment" rows="4" required placeholder="Tuliskan pengalaman Anda menginap di villa ini..." class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-xs font-medium text-slate-800 focus:outline-none focus:border-[#152c4e]"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeReviewModal()" class="px-5 py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" id="rev-submit-btn" class="px-6 py-2.5 rounded-full bg-[#ca9e54] hover:bg-[#b88c43] text-white text-xs font-bold transition shadow-md cursor-pointer">
                        Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- VIEW SUBMITTED REVIEW MODAL -->
    <div id="view-review-modal" onclick="closeViewReviewModal()" class="fixed inset-0 bg-black/80 backdrop-blur-md z-[80] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300 font-satoshi">
        <div class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300 relative" onclick="event.stopPropagation()">
            
            <div class="p-5 bg-[#152c4e] text-white flex items-center justify-between">
                <div>
                    <span class="text-[9px] uppercase font-bold tracking-widest text-[#e5c382] block">ULASAN ANDA</span>
                    <h3 class="font-serif-title text-lg font-bold" id="view-rev-prop-name">Nama Villa</h3>
                </div>
                <button type="button" onclick="closeViewReviewModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center cursor-pointer">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <div class="p-6 space-y-4 text-xs font-medium text-slate-700">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-1.5" id="view-rev-stars">
                        <!-- Stars injected dynamically -->
                    </div>
                    <span class="text-[10px] text-slate-400 font-medium" id="view-rev-date">-</span>
                </div>

                <div>
                    <span class="text-[10px] text-slate-400 uppercase font-bold block mb-1">Komentar Ulasan Anda:</span>
                    <p class="text-slate-800 text-xs leading-relaxed italic bg-slate-50 p-4 rounded-2xl border border-slate-100" id="view-rev-comment">
                        "-"
                    </p>
                </div>

                <div id="view-rev-reply-box" class="hidden p-3.5 rounded-2xl bg-amber-50/70 border border-amber-200/80 space-y-1 text-xs">
                    <div class="font-bold text-slate-900 flex items-center gap-1.5 text-[11px]">
                        <i class="ri-reply-fill text-[#ca9e54]"></i> Balasan Pengelola Villa:
                    </div>
                    <p class="text-slate-700 leading-relaxed text-xs pl-5 font-light" id="view-rev-reply-text">-</p>
                </div>

                <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                    <a id="view-rev-prop-link" href="#" class="text-[#152c4e] font-bold hover:underline text-xs flex items-center gap-1">
                        <span>Lihat Di Halaman Villa</span>
                        <i class="ri-arrow-right-line"></i>
                    </a>
                    <button type="button" onclick="closeViewReviewModal()" class="px-5 py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
