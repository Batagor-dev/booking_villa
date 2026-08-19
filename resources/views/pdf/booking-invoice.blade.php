<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>E-Voucher & Invoice #{{ $booking->booking_code }} - Palma Luxury Villa</title>
    <style>
        @page {
            margin: 25px 30px;
            size: a4 portrait;
        }
        * {
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        body {
            color: #1e293b;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #152c4e;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .logo-text {
            font-size: 22px;
            font-weight: bold;
            color: #152c4e;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .logo-sub {
            font-size: 9px;
            color: #ca9e54;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h1 {
            font-size: 18px;
            font-weight: bold;
            color: #152c4e;
            margin: 0 0 4px 0;
            text-transform: uppercase;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 20px;
            letter-spacing: 0.5px;
        }
        .badge-confirmed {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .badge-pending {
            background-color: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .badge-cancelled {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .grid-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
        }
        .card-title {
            font-size: 10px;
            font-weight: bold;
            color: #152c4e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 6px;
            margin-bottom: 8px;
        }
        .detail-row {
            margin-bottom: 4px;
        }
        .detail-label {
            color: #64748b;
            font-size: 10px;
            display: inline-block;
            width: 90px;
        }
        .detail-value {
            color: #0f172a;
            font-weight: 600;
            font-size: 10px;
        }
        .schedule-box {
            background-color: #152c4e;
            color: #ffffff;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }
        .schedule-table {
            width: 100%;
            color: #ffffff;
        }
        .schedule-title {
            font-size: 9px;
            color: #ca9e54;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .schedule-date {
            font-size: 13px;
            font-weight: bold;
        }
        .schedule-time {
            font-size: 9px;
            color: #94a3b8;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #152c4e;
            color: #ffffff;
            text-align: left;
            padding: 8px 10px;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .items-table td {
            padding: 9px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
        }
        .items-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .total-table {
            width: 100%;
            margin-top: 5px;
            border-collapse: collapse;
        }
        .total-table td {
            padding: 4px 10px;
            font-size: 10px;
        }
        .grand-total-row td {
            border-top: 2px solid #152c4e;
            font-size: 13px;
            font-weight: bold;
            color: #152c4e;
            padding-top: 8px;
            padding-bottom: 8px;
        }
        .policy-box {
            background-color: #f8fafc;
            border-left: 3px solid #ca9e54;
            padding: 10px 12px;
            border-radius: 0 6px 6px 0;
            margin-top: 15px;
            margin-bottom: 20px;
        }
        .policy-title {
            font-size: 9px;
            font-weight: bold;
            color: #152c4e;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .policy-list {
            margin: 0;
            padding-left: 14px;
            font-size: 9px;
            color: #475569;
            line-height: 1.4;
        }
        .footer {
            margin-top: 25px;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
        }
        .barcode-box {
            border: 1px dashed #cbd5e1;
            padding: 6px 12px;
            display: inline-block;
            background: #ffffff;
            border-radius: 4px;
            font-family: monospace;
            font-size: 12px;
            font-weight: bold;
            color: #152c4e;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>

    <!-- HEADER: LOGO & INVOICE META -->
    <table class="header-table" cellpadding="0" cellspacing="0">
        <tr>
            <td style="vertical-align: middle; width: 55%;">
                <div class="logo-text">PALMA SANCTUARY</div>
                <div class="logo-sub">Luxury Private Villas & Hospitality</div>
                <div style="font-size: 9px; color: #64748b; margin-top: 4px;">
                    Jl. Pantai Batu Mejan, Canggu, Bali 80351, Indonesia<br>
                    Email: reservations@palmavilla.id | Telp: +62 361 884 9200
                </div>
            </td>
            <td class="invoice-title" style="vertical-align: middle; width: 45%;">
                <h1>BOOKING E-VOUCHER</h1>
                <div style="font-size: 10px; color: #64748b; margin-bottom: 6px;">
                    Invoice No: <strong style="color: #0f172a;">#{{ $booking->booking_code }}</strong><br>
                    Tgl Reservasi: {{ $booking->created_at ? $booking->created_at->translatedFormat('d F Y, H:i') : date('d F Y') }} WIB
                </div>
                <div>
                    @if($booking->status === 'confirmed')
                        <span class="badge badge-confirmed">&#10003; CONFIRMED / LUNAS</span>
                    @elseif($booking->status === 'pending')
                        <span class="badge badge-pending">&#9203; PENDING VERIFIKASI</span>
                    @else
                        <span class="badge badge-cancelled">&#10005; CANCELLED / BATAL</span>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <!-- GUEST & VILLA INFORMATION GRID -->
    <table class="grid-table" cellpadding="0" cellspacing="0">
        <tr>
            <!-- GUEST INFO -->
            <td style="width: 48%; vertical-align: top; padding-right: 2%;">
                <div class="card">
                    <div class="card-title">Informasi Tamu / Guest Details</div>
                    <div class="detail-row">
                        <span class="detail-label">Nama Tamu:</span>
                        <span class="detail-value">{{ $booking->guest_name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">{{ $booking->guest_email }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">No. Telepon / WA:</span>
                        <span class="detail-value">{{ $booking->guest_phone ?: '-' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Metode Bayar:</span>
                        <span class="detail-value">{{ $booking->payment_type ?: ($booking->paymentMethod->name ?? 'Bank Transfer') }}</span>
                    </div>
                </div>
            </td>

            <!-- PROPERTY INFO -->
            <td style="width: 48%; vertical-align: top; padding-left: 2%;">
                <div class="card">
                    <div class="card-title">Rincian Properti / Villa Unit</div>
                    <div class="detail-row">
                        <span class="detail-label">Nama Villa:</span>
                        <span class="detail-value" style="color: #152c4e; font-size: 11px;">{{ $booking->property->name ?? 'Villa Unit' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tipe & Kapasitas:</span>
                        <span class="detail-value">{{ $booking->property->type ?? 'Villa' }} (Kapasitas {{ $booking->property->capacity ?? 4 }} Tamu, {{ $booking->property->bedrooms ?? 2 }} Kamar)</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Lokasi:</span>
                        <span class="detail-value">{{ $booking->property->address ?? ($booking->property->city . ', ' . $booking->property->province) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Catatan Tamu:</span>
                        <span class="detail-value">{{ $booking->notes ?: 'Tidak ada catatan khusus' }}</span>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- SCHEDULE DURATION STRIP -->
    <div class="schedule-box">
        <table class="schedule-table" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 38%; vertical-align: middle;">
                    <div class="schedule-title">CHECK-IN</div>
                    <div class="schedule-date">{{ $booking->check_in ? $booking->check_in->translatedFormat('l, d F Y') : '-' }}</div>
                    <div class="schedule-time">Mulai pukul 14:00 WITA</div>
                </td>
                <td style="width: 24%; text-align: center; vertical-align: middle;">
                    <div style="background-color: #ca9e54; color: #152c4e; font-weight: bold; font-size: 11px; padding: 4px 10px; border-radius: 12px; display: inline-block;">
                        {{ $booking->total_nights }} Malam (Nights)
                    </div>
                </td>
                <td style="width: 38%; text-align: right; vertical-align: middle;">
                    <div class="schedule-title">CHECK-OUT</div>
                    <div class="schedule-date">{{ $booking->check_out ? $booking->check_out->translatedFormat('l, d F Y') : '-' }}</div>
                    <div class="schedule-time">Maksimal pukul 12:00 WITA</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- ITEMIZED BILLING BREAKDOWN TABLE -->
    <table class="items-table" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 45%;">Deskripsi Layanan / Item</th>
                <th style="width: 20%; text-align: right;">Harga Satuan</th>
                <th style="width: 15%; text-align: center;">Kuantitas / Durasi</th>
                <th style="width: 20%; text-align: right;">Jumlah (IDR)</th>
            </tr>
        </thead>
        <tbody>
            <!-- Villa Base Rate -->
            <tr>
                <td>
                    <strong style="color: #0f172a;">Sewa Villa: {{ $booking->property->name ?? 'Villa Unit' }}</strong><br>
                    <span style="color: #64748b; font-size: 9px;">Akomodasi privat lengkap & fasilitas premium</span>
                </td>
                <td style="text-align: right;">
                    {{ format_rupiah($booking->property->price ?? ($booking->subtotal / max(1, $booking->total_nights))) }}
                </td>
                <td style="text-align: center;">{{ $booking->total_nights }} Malam</td>
                <td style="text-align: right; font-weight: 600;">
                    {{ format_rupiah($booking->subtotal) }}
                </td>
            </tr>

            <!-- Extra Services / Add-ons -->
            @if($booking->services && $booking->services->count() > 0)
                @foreach($booking->services as $srv)
                    <tr>
                        <td>
                            <strong style="color: #0f172a;">+ {{ $srv->name }}</strong>
                            @if($srv->category)
                                <span style="font-size: 8px; color: #ca9e54; font-weight: bold; text-transform: uppercase;">({{ $srv->category }})</span>
                            @endif
                            <br>
                            <span style="color: #64748b; font-size: 9px;">Layanan Tambahan Properti</span>
                        </td>
                        <td style="text-align: right;">
                            {{ format_rupiah($srv->price) }}
                        </td>
                        <td style="text-align: center;">
                            {{ $srv->quantity }} {{ str_contains($srv->price_type, 'night') ? 'Malam' : 'Item' }}
                        </td>
                        <td style="text-align: right; font-weight: 600;">
                            {{ format_rupiah($srv->subtotal) }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <!-- TOTAL CALCULATION SUMMARY TABLE -->
    <table style="width: 100%;" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width: 50%; vertical-align: top; padding-right: 20px;">
                <div style="text-align: center; padding: 10px; background-color: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px;">
                    <div style="font-size: 9px; color: #64748b; text-transform: uppercase; margin-bottom: 4px;">Kode E-Voucher / Validasi Check-in</div>
                    <div class="barcode-box">{{ $booking->booking_code }}</div>
                    <div style="font-size: 8px; color: #94a3b8; margin-top: 4px;">Tunjukkan kode ini kepada staf front desk saat kedatangan</div>
                </div>
            </td>
            <td style="width: 50%; vertical-align: top;">
                <table class="total-table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="color: #64748b; text-align: left;">Subtotal Sewa Villa:</td>
                        <td style="text-align: right; font-weight: 600;">{{ format_rupiah($booking->subtotal) }}</td>
                    </tr>
                    @if($booking->services_subtotal > 0)
                        <tr>
                            <td style="color: #64748b; text-align: left;">Total Layanan Tambahan (Add-on):</td>
                            <td style="text-align: right; font-weight: 600;">+ {{ format_rupiah($booking->services_subtotal) }}</td>
                        </tr>
                    @endif
                    @if($booking->discount_amount > 0)
                        <tr>
                            <td style="color: #ca9e54; text-align: left; font-weight: 600;">Diskon Kode Promo ({{ $booking->promotion->code ?? 'PROMO' }}):</td>
                            <td style="text-align: right; font-weight: 600; color: #ca9e54;">- {{ format_rupiah($booking->discount_amount) }}</td>
                        </tr>
                    @endif
                    <tr class="grand-total-row">
                        <td style="text-align: left;">TOTAL PEMBAYARAN:</td>
                        <td style="text-align: right; color: #152c4e;">{{ format_rupiah($booking->total_price) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- VILLA RULES & POLICIES -->
    <div class="policy-box">
        <div class="policy-title">&#9888; Ketentuan & Informasi Penting Reservasi</div>
        <ul class="policy-list">
            <li>Tamu wajib menunjukkan kartu identitas asli (KTP / Paspor) yang sah saat proses check-in di front office.</li>
            <li>Waktu check-in dimulai pukul 14:00 WITA dan batas check-out maksimal pukul 12:00 WITA. Late check-out bergantung pada ketersediaan unit.</li>
            <li>Dilarang merokok di dalam seluruh kamar tidur ber-AC dan area tertutup. Area merokok tersedia di balkon/teras terbuka.</li>
            <li>Mohon menjaga ketenangan lingkungan villa terutama setelah pukul 22:00 WITA.</li>
        </ul>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Dokumen ini diterbitkan secara elektronik oleh Sistem Pemesanan Palma Luxury Villa dan sah tanpa tanda tangan basah.<br>
        &copy; {{ date('Y') }} PT Palma Luxury Villa Management. All rights reserved.
    </div>

</body>
</html>
