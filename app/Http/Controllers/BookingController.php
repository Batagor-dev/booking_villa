<?php

namespace App\Http\Controllers;

use App\DataTables\BookingDataTable;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\Properties;
use App\Models\PaymentMethod;
use App\Models\PropertyRule;
use App\Models\PropertyServices;
use App\Models\Promotion;
use App\Services\ImageService;
use App\Services\NotificationService;
use App\Services\PromoService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings for Admin Panel.
     */
    public function index(BookingDataTable $dataTable)
    {
        return $dataTable->render('booking.index');
    }

    /**
     * Display the specified booking details.
     */
    public function show(Booking $booking)
    {
        $booking->load(['property', 'paymentMethod', 'user', 'promotion', 'services.propertyService']);
        return view('booking.show', compact('booking'));
    }

    /**
     * Download or stream PDF Booking Invoice / E-Voucher for Admin.
     */
    public function downloadInvoice(Booking $booking)
    {
        $booking->load(['property', 'paymentMethod', 'user', 'promotion', 'services']);
        $pdf = Pdf::loadView('pdf.booking-invoice', compact('booking'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Invoice-' . $booking->booking_code . '.pdf');
    }

    /**
     * Get availability booked dates for a property (JSON API).
     */
    public function getAvailability(Request $request, $propertyIdentifier)
    {
        $property = Properties::where('slug', $propertyIdentifier)
            ->orWhere('id', $propertyIdentifier)
            ->firstOrFail();

        $existingBookings = Booking::where('property_id', $property->id)
            ->whereIn('status', ['confirmed', 'pending'])
            ->get(['check_in', 'check_out']);

        $bookedDates = [];
        foreach ($existingBookings as $b) {
            if ($b->check_in && $b->check_out) {
                $bookedDates[] = [
                    'from' => $b->check_in->format('Y-m-d'),
                    'to'   => $b->check_out->format('Y-m-d'),
                ];
            }
        }

        return response()->json([
            'success'      => true,
            'property_id'  => $property->id,
            'property_name'=> $property->name,
            'booked_dates' => $bookedDates,
        ]);
    }

    /**
     * Show the dedicated public booking page.
     */
    public function createPublic(Request $request, $slug = null)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('warning', 'Silakan masuk atau buat akun terlebih dahulu untuk melakukan pemesanan villa.');
        }

        $properties = Properties::where('status', true)->with(['settings', 'galleries', 'facilities'])->latest()->get();
        
        $selectedSlug = $slug ?? $request->query('slug') ?? $request->query('property');
        
        $selectedProperty = null;
        if ($selectedSlug) {
            $selectedProperty = $properties->firstWhere('slug', $selectedSlug)
                ?? $properties->firstWhere('id', $selectedSlug);

            if (!$selectedProperty) {
                $selectedProperty = Properties::where('slug', $selectedSlug)
                    ->orWhere('id', $selectedSlug)
                    ->with(['settings', 'galleries', 'facilities'])
                    ->first();
            }
        }
        
        if (!$selectedProperty && $properties->count() > 0) {
            $selectedProperty = $properties->first();
        }

        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        $bookedDates = [];
        if ($selectedProperty) {
            $existingBookings = Booking::where('property_id', $selectedProperty->id)
                ->whereIn('status', ['confirmed', 'pending'])
                ->get(['check_in', 'check_out']);
                
            foreach ($existingBookings as $b) {
                if ($b->check_in && $b->check_out) {
                    $bookedDates[] = [
                        'from' => $b->check_in->format('Y-m-d'),
                        'to'   => $b->check_out->format('Y-m-d'),
                    ];
                }
            }
        }

        // Fetch Extra Services / Add-ons for the selected property (or global)
        $propertyServices = PropertyServices::where('status', true)
            ->where(function ($q) use ($selectedProperty) {
                if ($selectedProperty) {
                    $q->where('property_id', $selectedProperty->id)
                      ->orWhereNull('property_id');
                } else {
                    $q->whereNull('property_id');
                }
            })
            ->orderBy('sort', 'asc')
            ->get();

        $autoPromoCode = $request->query('promo');
        if (empty($autoPromoCode) && $selectedProperty) {
            $activePromo = $selectedProperty->active_promo_details;
            if ($activePromo && !empty($activePromo['code'])) {
                $autoPromoCode = $activePromo['code'];
            }
        }

        $propertyRules = $selectedProperty
            ? PropertyRule::active()->forPropertyType($selectedProperty->type ?? 'Villa')->orderBy('sort_order', 'asc')->get()
            : PropertyRule::active()->orderBy('sort_order', 'asc')->get();

        $defaultCheckIn = $request->query('check_in', date('Y-m-d'));
        $defaultCheckOut = $request->query('check_out', date('Y-m-d', strtotime('+2 days')));

        return view('frontend.booking.create', compact('properties', 'selectedProperty', 'paymentMethods', 'bookedDates', 'autoPromoCode', 'propertyRules', 'propertyServices', 'defaultCheckIn', 'defaultCheckOut'));
    }

    /**
     * Store a newly created booking in storage from frontend.
     */
    public function store(StoreBookingRequest $request, ImageService $imageService, PromoService $promoService)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $property = Properties::findOrFail($validated['property_id']);
            $paymentMethod = PaymentMethod::findOrFail($validated['payment_method_id']);

            // 1. Calculate Nights & Base Price (Subtotal)
            $checkIn = Carbon::parse($validated['check_in']);
            $checkOut = Carbon::parse($validated['check_out']);
            $nights = max(1, $checkIn->diffInDays($checkOut));

            $subtotal = $property->price * $nights;
            $discountAmount = 0.0;
            $totalPrice = $subtotal;
            $promotionId = null;

            // 2. Calculate Extra Services (Add-ons)
            $servicesSubtotal = 0.0;
            $selectedServicesData = [];
            if (!empty($validated['services']) && is_array($validated['services'])) {
                $serviceIds = array_filter(array_column($validated['services'], 'id'));
                if (!empty($serviceIds)) {
                    $validServices = PropertyServices::whereIn('id', $serviceIds)->where('status', true)->get()->keyBy('id');
                    foreach ($validated['services'] as $svcItem) {
                        $sId = $svcItem['id'] ?? null;
                        $qty = max(1, intval($svcItem['qty'] ?? 1));
                        if ($sId && isset($validServices[$sId])) {
                            $dbService = $validServices[$sId];
                            $itemPrice = (float) $dbService->price;
                            $isPerNight = str_contains(strtolower($dbService->price_type ?? ''), 'night');
                            $itemSubtotal = $isPerNight ? ($itemPrice * $qty * $nights) : ($itemPrice * $qty);
                            
                            $servicesSubtotal += $itemSubtotal;
                            $selectedServicesData[] = [
                                'property_service_id' => $dbService->id,
                                'name'                => $dbService->name,
                                'category'            => $dbService->category,
                                'price'               => $itemPrice,
                                'price_type'          => $dbService->price_type ?? 'per_item',
                                'quantity'            => $qty,
                                'subtotal'            => $itemSubtotal,
                            ];
                        }
                    }
                }
            }

            // 3. Validate & Apply Promo Code if provided or Automatic Property Promo
            $totalBeforeDiscount = $subtotal + $servicesSubtotal;
            if (!empty($validated['promo_code'])) {
                $promoResult = $promoService->validatePromoCode(
                    $validated['promo_code'],
                    $property->id,
                    $nights,
                    $subtotal
                );

                if (!$promoResult['valid']) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with('failed_booking', 'Promo tidak valid: ' . $promoResult['message']);
                }

                $promotionId    = $promoResult['promotion_id'];
                $discountAmount = $promoResult['discount_amount'];
                $totalPrice     = max(0, $totalBeforeDiscount - $discountAmount);

                $promoRecord = Promotion::find($promotionId);
                if ($promoRecord) {
                    $promoRecord->incrementUsage();
                }
            } elseif ($activePromo = $property->active_promo_details) {
                $promotionId    = $activePromo['promotion_id'];
                $discountPerNight = $activePromo['discount_amount'];
                $discountAmount = min($subtotal, $discountPerNight * $nights);
                $totalPrice     = max(0, $totalBeforeDiscount - $discountAmount);

                $promoRecord = Promotion::find($promotionId);
                if ($promoRecord) {
                    $promoRecord->incrementUsage();
                }
            } else {
                $totalPrice = $totalBeforeDiscount;
            }

            // 4. Upload Bukti Payment Image
            $receiptPath = null;
            if ($request->hasFile('bukti_payment')) {
                $file = $request->file('bukti_payment');
                $compressed = $imageService->compress($file);
                $receiptPath = 'booking-receipts/' . uniqid('receipt_') . '.jpg';
                Storage::disk('public')->put($receiptPath, $compressed);
            }

            // 5. Generate Unique Booking Code
            $bookingCode = 'BOOK-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // 6. Create Booking Record
            $booking = Booking::create([
                'booking_code'      => $bookingCode,
                'property_id'       => $property->id,
                'promotion_id'      => $promotionId,
                'user_id'           => auth()->check() ? auth()->id() : null,
                'guest_name'        => $validated['guest_name'],
                'guest_email'       => $validated['guest_email'],
                'guest_phone'       => $validated['guest_phone'],
                'check_in'          => $validated['check_in'],
                'check_out'         => $validated['check_out'],
                'total_nights'      => $nights,
                'subtotal'          => $subtotal,
                'services_subtotal' => $servicesSubtotal,
                'discount_amount'   => $discountAmount,
                'total_price'       => $totalPrice,
                'payment_method_id' => $paymentMethod->id,
                'payment_type'      => $paymentMethod->name . ' (' . strtoupper($paymentMethod->type) . ')',
                'bukti_payment'     => $receiptPath,
                'status'            => 'pending',
                'notes'             => $validated['notes'] ?? null,
            ]);

            // 7. Save Selected Booking Services
            foreach ($selectedServicesData as $svcData) {
                $booking->services()->create($svcData);
            }

            // 8. Trigger Admin Notification for New Order
            try {
                NotificationService::notifyNewBooking($booking);
            } catch (\Throwable $notifErr) {
                \Log::warning('Failed creating new booking notification: ' . $notifErr->getMessage());
            }

            DB::commit();

            return redirect()->back()->with('success_booking', [
                'uuid'              => $booking->uuid,
                'booking_code'      => $booking->booking_code,
                'guest_name'        => $booking->guest_name,
                'property_name'     => $property->name,
                'subtotal'          => format_rupiah($booking->subtotal),
                'services_subtotal' => format_rupiah($booking->services_subtotal),
                'discount_amount'   => format_rupiah($booking->discount_amount),
                'total_price'       => format_rupiah($booking->total_price),
                'download_url'      => route('user.bookings.invoice', $booking->uuid),
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('failed_booking', 'Reservasi gagal diproses: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified booking status and details.
     */
    public function edit(Booking $booking)
    {
        $booking->load(['property', 'paymentMethod', 'user']);
        $action = route('bookings.update', $booking->uuid);
        $statuses = [
            'pending'   => 'Pending (Menunggu Verifikasi)',
            'confirmed' => 'Confirmed (Reservasi Disetujui)',
            'cancelled' => 'Cancelled (Reservasi Dibatalkan)',
        ];

        return view('booking.form', compact('booking', 'action', 'statuses'));
    }

    /**
     * Update the specified booking in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $oldStatus = $booking->status;

        $validated = $request->validate([
            'status'      => 'required|in:pending,confirmed,cancelled',
            'guest_name'  => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:50',
            'notes'       => 'nullable|string',
        ]);

        $booking->update($validated);

        if ($oldStatus !== $request->status) {
            if ($request->status === 'cancelled') {
                NotificationService::notifyCancelledBooking($booking);
            } elseif ($request->status === 'confirmed') {
                NotificationService::notifyConfirmedBooking($booking);
            }
        }

        return redirect()->route('bookings.index')->with('success', 'Status & data booking #' . $booking->booking_code . ' berhasil diperbarui.');
    }

    /**
     * Update booking status via AJAX (confirm, cancel, pending).
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $oldStatus = $booking->status;

        $booking->update([
            'status' => $request->status,
        ]);

        if ($oldStatus !== $request->status) {
            if ($request->status === 'cancelled') {
                NotificationService::notifyCancelledBooking($booking);
            } elseif ($request->status === 'confirmed') {
                NotificationService::notifyConfirmedBooking($booking);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Status booking berhasil diperbarui menjadi ' . ucfirst($request->status) . '.',
        ]);
    }

    /**
     * Remove the specified booking from storage.
     */
    public function destroy(Booking $booking)
    {
        if ($booking->bukti_payment && Storage::disk('public')->exists($booking->bukti_payment)) {
            Storage::disk('public')->delete($booking->bukti_payment);
        }

        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dihapus.');
    }
}
