<?php

namespace App\Http\Controllers;

use App\DataTables\BookingDataTable;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Properties;
use App\Models\PaymentMethod;
use App\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $booking->load(['property', 'paymentMethod', 'user']);
        return view('booking.show', compact('booking'));
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
        
        $selectedSlug = $slug ?? $request->query('property');
        
        $selectedProperty = null;
        if ($selectedSlug) {
            $selectedProperty = $properties->firstWhere('slug', $selectedSlug);
            if (!$selectedProperty) {
                $selectedProperty = Properties::where('slug', $selectedSlug)->with(['settings', 'galleries', 'facilities'])->first();
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

        return view('frontend.booking.create', compact('properties', 'selectedProperty', 'paymentMethods', 'bookedDates'));
    }

    /**
     * Store a newly created booking in storage from frontend.
     */
    public function store(StoreBookingRequest $request, ImageService $imageService)
    {
        $validated = $request->validated();

        $property = Properties::findOrFail($validated['property_id']);
        $paymentMethod = PaymentMethod::findOrFail($validated['payment_method_id']);

        // 1. Calculate Nights & Price
        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);
        $nights = max(1, $checkIn->diffInDays($checkOut));

        $totalPrice = $property->price * $nights;

        // 2. Upload Bukti Payment Image
        $receiptPath = null;
        if ($request->hasFile('bukti_payment')) {
            $file = $request->file('bukti_payment');
            $compressed = $imageService->compress($file);
            $receiptPath = 'booking-receipts/' . uniqid('receipt_') . '.jpg';
            Storage::disk('public')->put($receiptPath, $compressed);
        }

        // 3. Generate Unique Booking Code
        $bookingCode = 'BOOK-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // 4. Create Booking
        $booking = Booking::create([
            'booking_code'      => $bookingCode,
            'property_id'       => $property->id,
            'user_id'           => auth()->check() ? auth()->id() : null,
            'guest_name'        => $validated['guest_name'],
            'guest_email'       => $validated['guest_email'],
            'guest_phone'       => $validated['guest_phone'],
            'check_in'          => $validated['check_in'],
            'check_out'         => $validated['check_out'],
            'total_nights'      => $nights,
            'total_price'       => $totalPrice,
            'payment_method_id' => $paymentMethod->id,
            'payment_type'      => $paymentMethod->name . ' (' . strtoupper($paymentMethod->type) . ')',
            'bukti_payment'     => $receiptPath,
            'status'            => 'pending',
            'notes'             => $validated['notes'] ?? null,
        ]);

        return redirect()->back()->with('success_booking', [
            'booking_code' => $booking->booking_code,
            'guest_name'   => $booking->guest_name,
            'property_name'=> $property->name,
            'total_price'  => number_format($booking->total_price, 0, ',', '.'),
        ]);
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
        $validated = $request->validate([
            'status'      => 'required|in:pending,confirmed,cancelled',
            'guest_name'  => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:50',
            'notes'       => 'nullable|string',
        ]);

        $booking->update($validated);

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

        $booking->update([
            'status' => $request->status,
        ]);

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
