@extends('layouts.frontend.main')

@section('title', 'Form Reservasi Villa - ' . ($selectedProperty->name ?? 'Palma Luxury'))

@php
    $propertyOptions = [];
    foreach($properties as $pItem) {
        $propertyOptions[$pItem->slug] = $pItem->name . ' (' . format_rupiah($pItem->price) . '/malam)';
    }

    $paymentOptions = [];
    foreach($paymentMethods as $pm) {
        $paymentOptions[$pm->id] = $pm->name . ' (' . strtoupper($pm->type) . ')';
    }
@endphp

@section('content')
    <!-- HERO HEADER BOOKING PAGE -->
    <section class="relative pt-32 pb-12 px-4 sm:px-6 md:px-12 bg-[#152c4e] text-white font-satoshi overflow-hidden">
        <div class="absolute inset-0 opacity-15 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=80" alt="Villa Sanctuary" class="w-full h-full object-cover">
        </div>
        <div class="max-w-7xl mx-auto relative z-10">
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs text-white/70 mb-3 font-medium">
                <a href="{{ route('home') }}" class="hover:text-[#ca9e54] transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('villa.index') }}" class="hover:text-[#ca9e54] transition-colors">Villa</a>
                @if($selectedProperty)
                    <span>/</span>
                    <a href="{{ route('villa.show', $selectedProperty->slug) }}" class="hover:text-[#ca9e54] transition-colors">{{ $selectedProperty->name }}</a>
                @endif
                <span>/</span>
                <span class="text-white font-semibold">Form Booking</span>
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <span class="text-[10px] sm:text-xs font-bold tracking-[0.25em] text-[#e5c382] uppercase block mb-1">Pemesanan Langsung Garansi Resmi</span>
                    <h1 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-normal text-white">
                        Halaman Reservasi Villa
                    </h1>
                </div>
                <a href="{{ $selectedProperty ? route('villa.show', $selectedProperty->slug) : route('villa.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition-all border border-white/20 shrink-0 w-fit">
                    <i class="ri-arrow-left-line text-sm"></i> Kembali ke Detail Villa
                </a>
            </div>
        </div>
    </section>

    <!-- MAIN FORM & DETAILS CONTAINER -->
    <section class="py-10 sm:py-14 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <!-- LEFT COLUMN: PROPERTY DETAILS, GALLERY & SETTINGS (5 Cols) -->
            <div class="lg:col-span-5 space-y-6">

                @if($selectedProperty)
                    @php
                        $propSettings = $selectedProperty->settings;
                        $mainImg = isset($selectedProperty->main_image) 
                            ? (\Illuminate\Support\Str::startsWith($selectedProperty->main_image, ['http://', 'https://']) ? $selectedProperty->main_image : asset('storage/'.$selectedProperty->main_image))
                            : 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=800&q=75';
                    @endphp

                    <!-- PROPERTY SUMMARY CARD -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 space-y-4 p-5 sm:p-6">
                        <div class="relative h-56 rounded-2xl overflow-hidden bg-slate-100 group">
                            <img src="{{ $mainImg }}" alt="{{ $selectedProperty->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-3 left-3 flex gap-2">
                                <span class="bg-[#ca9e54] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                                    {{ $selectedProperty->code ?? 'VILLA' }}
                                </span>
                                <span class="bg-white/90 backdrop-blur-md text-slate-800 text-[10px] font-bold px-3 py-1 rounded-full shadow-sm">
                                    {{ $selectedProperty->type ?? 'Sanctuary' }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <h3 class="font-serif-title text-xl font-bold text-slate-900">{{ $selectedProperty->name }}</h3>
                                <div class="flex items-center gap-1 text-xs font-bold text-slate-800 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-200 shrink-0">
                                    <i class="ri-star-fill text-[#ca9e54]"></i>
                                    <span>{{ number_format($selectedProperty->rating ?? 4.9, 1) }}</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 flex items-center gap-1">
                                <i class="ri-map-pin-2-fill text-[#ca9e54]"></i>
                                <span>{{ $selectedProperty->address ?? ($selectedProperty->city . ', ' . $selectedProperty->province) }}</span>
                            </p>
                        </div>

                        <!-- Specs List -->
                        <div class="grid grid-cols-2 gap-3 pt-3 border-t border-slate-100 text-xs font-medium text-slate-700">
                            <div class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <i class="ri-hotel-bed-line text-lg text-[#ca9e54]"></i>
                                <div>
                                    <span class="text-[10px] text-slate-400 block uppercase font-bold">Kamar Tidur</span>
                                    <span class="font-bold text-slate-900">{{ $selectedProperty->bedrooms ?? 3 }} Kamar</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <i class="ri-group-line text-lg text-[#ca9e54]"></i>
                                <div>
                                    <span class="text-[10px] text-slate-400 block uppercase font-bold">Kapasitas</span>
                                    <span class="font-bold text-slate-900">{{ $selectedProperty->capacity ?? 6 }} Tamu</span>
                                </div>
                            </div>
                        </div>

                        <!-- Price display -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-medium text-slate-500">Harga Per Malam</span>
                            <x-ui.price :value="$selectedProperty->price" suffix="/malam" class="text-xl font-bold text-[#152c4e]" containerClass="inline-block text-right" />
                        </div>
                    </div>

                    <!-- PROPERTY SETTINGS & POLICIES (`PropertySettings`) -->
                    <div class="bg-slate-50/80 p-5 sm:p-6 rounded-3xl border border-slate-200/80 space-y-4 text-xs font-medium text-slate-700">
                        <h4 class="font-bold text-slate-900 uppercase tracking-wider flex items-center gap-1.5 text-xs">
                            <i class="ri-[#152c4e] ri-information-line text-base text-[#ca9e54]"></i> Aturan & Kebijakan Menginap
                        </h4>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 bg-white rounded-2xl border border-slate-200/60">
                                <span class="text-[10px] font-bold text-slate-400 uppercase block mb-0.5">Waktu Check-In</span>
                                <strong class="text-slate-900 text-sm font-bold flex items-center gap-1">
                                    <i class="ri-time-line text-[#ca9e54]"></i> {{ $propSettings->check_in_time ?? '14:00 WITA' }}
                                </strong>
                            </div>
                            <div class="p-3 bg-white rounded-2xl border border-slate-200/60">
                                <span class="text-[10px] font-bold text-slate-400 uppercase block mb-0.5">Waktu Check-Out</span>
                                <strong class="text-slate-900 text-sm font-bold flex items-center gap-1">
                                    <i class="ri-time-line text-rose-500"></i> {{ $propSettings->check_out_time ?? '12:00 WITA' }}
                                </strong>
                            </div>
                        </div>

                        @if(!empty($propSettings->cancellation_policy))
                            <div class="p-3 bg-white rounded-2xl border border-slate-200/60 space-y-1">
                                <span class="text-[10px] font-bold text-slate-400 uppercase block">Kebijakan Pembatalan</span>
                                <div class="text-slate-600 leading-relaxed text-[11px]">{!! $propSettings->cancellation_policy !!}</div>
                            </div>
                        @endif

                        @if(!empty($propSettings->phone) || !empty($propSettings->email))
                            <div class="pt-2 border-t border-slate-200/60 flex items-center justify-between text-[11px] text-slate-500">
                                <span>Bantuan / Helpdesk Villa:</span>
                                <strong class="text-slate-800">{{ $propSettings->phone ?? $propSettings->email }}</strong>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- RIGHT COLUMN: FORM BOOKING & PAYMENT METHOD (7 Cols) -->
            <div class="lg:col-span-7 bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-100 space-y-6">
                
                <div class="border-b border-slate-100 pb-5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#ca9e54] block">Langkah Reservasi</span>
                    <h2 class="font-serif-title text-2xl sm:text-3xl font-bold text-slate-900">Formulir Pemesanan Villa</h2>
                    <p class="text-xs text-slate-500 font-light mt-1">Isi informasi tamu dan pilih metode pembayaran untuk melanjutkan.</p>
                </div>

                <!-- MAIN BOOKING FORM SUBMISSION -->
                <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="booking-submit-form">
                    @csrf
                    <input type="hidden" name="property_id" value="{{ $selectedProperty->id ?? 1 }}">

                    <!-- DATES & CALCULATOR SECTION -->
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-4">
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="ri-calendar-event-fill text-[#ca9e54]"></i> Tanggal Menginap
                        </h4>

                        <x-ui.date 
                            type="range"
                            checkinName="check_in"
                            checkoutName="check_out"
                            checkinValue="{{ old('check_in', date('Y-m-d', strtotime('+1 day'))) }}"
                            checkoutValue="{{ old('check_out', date('Y-m-d', strtotime('+3 days'))) }}"
                            :disabledDates="$bookedDates ?? []"
                            :inline="true"
                            showMonths="2"
                        />

                        <!-- LIVE NIGHTS & TOTAL CALCULATION BOX -->
                        <div class="p-3.5 bg-white rounded-xl border border-slate-200/80 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-800 font-bold text-[11px]" id="calc-nights-badge">2 Malam</span>
                                <span class="text-slate-500 text-[11px]">x {{ format_rupiah($selectedProperty->price ?? 0) }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] text-slate-400 uppercase font-bold block">Estimasi Subtotal</span>
                                <x-ui.price :value="($selectedProperty->price ?? 0) * 2" class="text-base font-bold text-[#152c4e]" containerClass="inline" id="calc-total-price" />
                            </div>
                        </div>
                    </div>

                    <!-- GUEST INFORMATION SECTION -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="ri-user-3-fill text-[#ca9e54]"></i> Informasi Data Tamu
                        </h4>

                        <div class="space-y-3">
                            <x-ui.input 
                                name="guest_name" 
                                label="Nama Lengkap Tamu" 
                                placeholder="Masukkan nama sesuai identitas / KTP / Paspor" 
                                value="{{ old('guest_name', auth()->user()->name ?? '') }}"
                                required
                            />

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <x-ui.input 
                                    type="email"
                                    name="guest_email" 
                                    label="Email Konfirmasi" 
                                    placeholder="nama@domain.com" 
                                    value="{{ old('guest_email', auth()->user()->email ?? '') }}"
                                    required
                                />

                                <x-ui.input 
                                    name="guest_phone" 
                                    label="Nomor Telepon / WhatsApp" 
                                    placeholder="+62 812 3456 7890" 
                                    value="{{ old('guest_phone', '') }}"
                                    required
                                />
                            </div>

                            <div>
                                <x-ui.textarea 
                                    name="notes" 
                                    label="Catatan / Permintaan Khusus (Opsional)" 
                                    placeholder="Contoh: Minta tempat tidur tambahan, perkiraan waktu kedatangan jam 15:00..."
                                    value="{{ old('notes') }}"
                                    rows="2"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- PAYMENT METHOD SECTION USING COMPONENT x-ui.select2 -->
                    <div class="space-y-4 pt-2">
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="ri-bank-card-fill text-[#ca9e54]"></i> Metode Pembayaran & Transfer
                        </h4>

                        <div>
                            <x-ui.select2 
                                name="payment_method_id"
                                id="select-payment-method-id"
                                label="Pilih Metode Pembayaran" 
                                placeholder="-- Pilih Metode Pembayaran --"
                                :options="$paymentOptions"
                                :value="old('payment_method_id')"
                                required
                            />
                        </div>

                        <!-- DYNAMIC PAYMENT INSTRUCTION & ACCOUNT INFO BOX -->
                        <div id="payment-details-box" class="p-4 rounded-2xl bg-amber-50/80 border border-amber-200/80 space-y-3 hidden">
                            <div class="flex items-center justify-between border-b border-amber-200/60 pb-2">
                                <span class="text-xs font-bold text-amber-900" id="pm-box-name">Bank Transfer BCA</span>
                                <span class="px-2 py-0.5 rounded-full bg-amber-200/70 text-amber-900 text-[10px] font-bold" id="pm-box-type">BANK TRANSFER</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                <div>
                                    <span class="text-[10px] font-bold text-amber-800 uppercase block">Nomor Rekening / QR Code</span>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <strong class="text-amber-950 font-mono text-sm" id="pm-box-number">8830123999</strong>
                                        <button type="button" onclick="copyAccountNo()" class="px-2 py-0.5 rounded bg-amber-200/80 hover:bg-amber-300 text-amber-900 text-[10px] font-bold transition">
                                            Salin
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold text-amber-800 uppercase block">Atas Nama / Pemilik</span>
                                    <strong class="text-amber-950 text-xs font-bold block mt-0.5" id="pm-box-holder">PT Palma Luxury Villa</strong>
                                </div>
                            </div>

                            <!-- QRIS Image Container if available -->
                            <div id="pm-box-qris-container" class="pt-2 border-t border-amber-200/60 hidden text-center">
                                <span class="text-[10px] font-bold text-amber-800 uppercase block mb-2">Scan QRIS Untuk Pembayaran</span>
                                <img id="pm-box-qris-img" src="" alt="QRIS Code" class="h-44 mx-auto rounded-xl border border-amber-200 bg-white p-2 shadow-sm">
                            </div>
                        </div>

                        <!-- PROOF OF PAYMENT UPLOAD -->
                        <div class="space-y-2 pt-2">
                            <label class="block text-xs font-satoshi-medium text-slate-700">
                                Unggah Bukti Pembayaran / Transfer <span class="text-rose-500">*</span>
                            </label>
                            
                            <div class="relative border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center bg-slate-50/60 hover:bg-slate-100/60 transition cursor-pointer" id="receipt-dropzone">
                                <input type="file" name="bukti_payment" id="input-bukti-payment" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required onchange="handleReceiptPreview(this)">
                                
                                <div id="receipt-prompt" class="space-y-1">
                                    <i class="ri-upload-cloud-2-line text-2xl text-[#ca9e54]"></i>
                                    <p class="text-xs font-bold text-slate-800">Klik atau tarik file gambar bukti pembayaran ke sini</p>
                                    <p class="text-[10px] text-slate-400">Format: JPG, PNG, WebP (Maksimal 5MB)</p>
                                </div>

                                <div id="receipt-preview-box" class="hidden flex items-center justify-center gap-3">
                                    <img id="receipt-preview-img" src="#" class="h-20 w-20 object-cover rounded-xl border border-slate-200 shadow-sm">
                                    <div class="text-left text-xs">
                                        <span class="font-bold text-slate-900 block" id="receipt-file-name">receipt.jpg</span>
                                        <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                                            <i class="ri-checkbox-circle-fill"></i> File Gambar Siap Diunggah
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @error('bukti_payment') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    <!-- SUBMIT BUTTON & DISCLAIMER -->
                    <div class="pt-4 space-y-3">
                        <button type="submit" class="w-full bg-[#152c4e] hover:bg-[#0f1d32] text-white font-bold py-4 rounded-2xl text-xs uppercase tracking-wider transition duration-300 shadow-xl flex items-center justify-center gap-2 cursor-pointer group">
                            <i class="ri-shield-check-fill text-base text-[#e5c382]"></i>
                            <span>Konfirmasi & Kirim Pemesanan</span>
                            <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform"></i>
                        </button>

                        <p class="text-[10px] text-slate-400 text-center flex items-center justify-center gap-1">
                            <i class="ri-lock-line text-emerald-600"></i> Transaksi Aman & Terenkripsi. Konfirmasi reservasi akan dikirimkan langsung ke WhatsApp & Email Anda.
                        </p>
                    </div>

                </form>
            </div>

        </div>

    </section>

    <!-- IMAGE LIGHTBOX MODAL -->
    <div id="gallery-lightbox" class="fixed inset-0 z-[100] bg-black/90 hidden flex items-center justify-center p-4" onclick="closeGalleryLightbox()">
        <img id="lightbox-img" src="" class="max-h-[85vh] max-w-[90vw] object-contain rounded-2xl border border-white/20 shadow-2xl">
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const propertyPrice = {{ $selectedProperty->price ?? 0 }};
        const paymentMethodsData = @json($paymentMethods);

        document.addEventListener('DOMContentLoaded', function() {
            // Calculate price on initial load
            calculateBookingTotal();

            // Handle event change on hidden input created by x-ui.select2
            document.addEventListener('change', function(e) {
                if (e.target && e.target.name === 'select_property') {
                    const slug = e.target.value;
                    if (slug) {
                        window.location.href = "{{ url('/booking') }}/" + slug;
                    }
                }

                if (e.target && e.target.name === 'payment_method_id') {
                    updatePaymentMethodBox(e.target.value);
                }
            });

            // Initial check for payment method box if pre-selected
            const pmInput = document.querySelector('input[name="payment_method_id"]');
            if (pmInput && pmInput.value) {
                updatePaymentMethodBox(pmInput.value);
            }
        });

        // Helper to format currency
        function formatRupiah(amount) {
            if (typeof window.formatRupiah === 'function') {
                return window.formatRupiah(amount);
            }
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount || 0);
        }

        // Calculate nights and total price
        function calculateBookingTotal() {
            const checkInInput = document.getElementById('input-check-in');
            const checkOutInput = document.getElementById('input-check-out');
            
            if (!checkInInput || !checkOutInput || !checkInInput.value || !checkOutInput.value) return;

            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);

            if (checkOut <= checkIn) {
                const nextDay = new Date(checkIn);
                nextDay.setDate(nextDay.getDate() + 1);
                checkOutInput.value = nextDay.toISOString().split('T')[0];
            }

            const diffTime = Math.abs(new Date(checkOutInput.value) - new Date(checkInInput.value));
            const diffDays = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));

            const total = propertyPrice * diffDays;

            const nightsBadge = document.getElementById('calc-nights-badge');
            const totalPriceEl = document.getElementById('calc-total-price');

            if (nightsBadge) nightsBadge.innerText = diffDays + ' Malam';
            if (totalPriceEl) totalPriceEl.innerText = formatRupiah(total);
        }

        window.calculateBookingTotal = calculateBookingTotal;

        // Update payment method dynamic instruction box from paymentMethodsData
        function updatePaymentMethodBox(paymentMethodId) {
            const box = document.getElementById('payment-details-box');
            if (!paymentMethodId) {
                if (box) box.classList.add('hidden');
                return;
            }

            const pm = paymentMethodsData.find(item => String(item.id) === String(paymentMethodId));
            if (!pm) {
                if (box) box.classList.add('hidden');
                return;
            }

            document.getElementById('pm-box-name').innerText = pm.name || 'Metode Pembayaran';
            document.getElementById('pm-box-type').innerText = (pm.type || 'PAYMENT').toUpperCase();
            document.getElementById('pm-box-number').innerText = pm.account_number || '-';
            document.getElementById('pm-box-holder').innerText = pm.account_name || '-';

            const qrisContainer = document.getElementById('pm-box-qris-container');
            const qrisImg = document.getElementById('pm-box-qris-img');

            if (pm.image_qris && pm.image_qris.trim() !== '') {
                qrisImg.src = "{{ asset('storage') }}/" + pm.image_qris;
                qrisContainer.classList.remove('hidden');
            } else {
                qrisContainer.classList.add('hidden');
            }

            if (box) box.classList.remove('hidden');
        }

        // Copy Account Number
        function copyAccountNo() {
            const num = document.getElementById('pm-box-number').innerText;
            if (num && num !== '-') {
                navigator.clipboard.writeText(num);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Nomor Rekening berhasil disalin!',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }

        // Preview Proof of Payment File
        function handleReceiptPreview(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('receipt-preview-img').src = e.target.result;
                    document.getElementById('receipt-file-name').innerText = input.files[0].name;
                    document.getElementById('receipt-prompt').classList.add('hidden');
                    document.getElementById('receipt-preview-box').classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Gallery Lightbox Preview
        function previewGalleryImage(src) {
            document.getElementById('lightbox-img').src = src;
            document.getElementById('gallery-lightbox').classList.remove('hidden');
        }

        function closeGalleryLightbox() {
            document.getElementById('gallery-lightbox').classList.add('hidden');
        }
    </script>

    @if(session('success_booking'))
        @php $sData = session('success_booking'); @endphp
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Reservasi Berhasil!',
                html: `
                    <div class="text-center space-y-2 text-xs font-satoshi">
                        <p class="text-slate-600">Kode Booking Anda:</p>
                        <div class="px-4 py-2 bg-slate-100 rounded-xl font-mono font-bold text-lg text-slate-900 border border-slate-200">
                            #{{ $sData['booking_code'] }}
                        </div>
                        <p class="text-slate-500 pt-2">Terima kasih <strong>{{ $sData['guest_name'] }}</strong>, reservasi Anda untuk villa <strong>{{ $sData['property_name'] }}</strong> sedang diproses oleh tim kami.</p>
                    </div>
                `,
                confirmButtonText: 'Selesai & Lihat Detail',
                confirmButtonColor: '#152c4e',
                customClass: {
                    popup: 'rounded-3xl p-6 font-satoshi'
                }
            });
        </script>
    @endif
@endpush
