<?php

namespace App\Services;

use App\Models\AdminNotification;
use App\Models\Booking;

class NotificationService
{
    /**
     * Notify admin when a new booking / order is submitted.
     */
    public static function notifyNewBooking(Booking $booking): ?AdminNotification
    {
        $booking->loadMissing(['property', 'paymentMethod', 'user']);

        $propertyName = $booking->property->name ?? 'Villa / Properti';
        $guestName = $booking->guest_name ?? 'Tamu';
        $code = $booking->booking_code ?? ('#' . $booking->id);

        $checkInFormatted = $booking->check_in ? $booking->check_in->format('d M Y') : '-';
        $checkOutFormatted = $booking->check_out ? $booking->check_out->format('d M Y') : '-';

        return AdminNotification::create([
            'booking_id' => $booking->id,
            'type'       => 'order_created',
            'title'      => 'Pesanan Baru Masuk',
            'message'    => "Reservasi {$code} oleh {$guestName} untuk {$propertyName}",
            'data'       => [
                'booking_id'      => $booking->id,
                'booking_uuid'    => $booking->uuid,
                'booking_code'    => $code,
                'guest_name'      => $guestName,
                'guest_email'     => $booking->guest_email,
                'guest_phone'     => $booking->guest_phone,
                'property_name'   => $propertyName,
                'property_slug'   => $booking->property->slug ?? null,
                'check_in'        => $checkInFormatted,
                'check_out'       => $checkOutFormatted,
                'total_nights'    => $booking->total_nights ?? 1,
                'subtotal'        => $booking->subtotal,
                'discount_amount' => $booking->discount_amount,
                'total_price'     => $booking->total_price,
                'payment_type'    => $booking->payment_type ?? ($booking->paymentMethod->name ?? 'Transfer'),
                'status'          => $booking->status,
                'url'             => route('bookings.show', $booking->uuid),
            ],
        ]);
    }

    /**
     * Notify admin when a booking / order is cancelled.
     */
    public static function notifyCancelledBooking(Booking $booking, ?string $reason = null): ?AdminNotification
    {
        $booking->loadMissing(['property', 'paymentMethod', 'user']);

        $propertyName = $booking->property->name ?? 'Villa / Properti';
        $guestName = $booking->guest_name ?? 'Tamu';
        $code = $booking->booking_code ?? ('#' . $booking->id);

        $checkInFormatted = $booking->check_in ? $booking->check_in->format('d M Y') : '-';
        $checkOutFormatted = $booking->check_out ? $booking->check_out->format('d M Y') : '-';

        $msg = "Pesanan {$code} ({$guestName}) untuk {$propertyName} telah dibatalkan";
        if ($reason) {
            $msg .= ". Alasan: " . $reason;
        }

        return AdminNotification::create([
            'booking_id' => $booking->id,
            'type'       => 'order_cancelled',
            'title'      => 'Pesanan Dibatalkan',
            'message'    => $msg,
            'data'       => [
                'booking_id'      => $booking->id,
                'booking_uuid'    => $booking->uuid,
                'booking_code'    => $code,
                'guest_name'      => $guestName,
                'guest_email'     => $booking->guest_email,
                'guest_phone'     => $booking->guest_phone,
                'property_name'   => $propertyName,
                'property_slug'   => $booking->property->slug ?? null,
                'check_in'        => $checkInFormatted,
                'check_out'       => $checkOutFormatted,
                'total_nights'    => $booking->total_nights ?? 1,
                'total_price'     => $booking->total_price,
                'payment_type'    => $booking->payment_type ?? ($booking->paymentMethod->name ?? 'Transfer'),
                'status'          => 'cancelled',
                'cancel_reason'   => $reason,
                'url'             => route('bookings.show', $booking->uuid),
            ],
        ]);
    }

    /**
     * Notify admin when a booking is confirmed.
     */
    public static function notifyConfirmedBooking(Booking $booking): ?AdminNotification
    {
        $booking->loadMissing(['property']);

        $propertyName = $booking->property->name ?? 'Villa / Properti';
        $guestName = $booking->guest_name ?? 'Tamu';
        $code = $booking->booking_code ?? ('#' . $booking->id);

        return AdminNotification::create([
            'booking_id' => $booking->id,
            'type'       => 'order_confirmed',
            'title'      => 'Pesanan Dikonfirmasi',
            'message'    => "Pesanan {$code} ({$guestName}) untuk {$propertyName} telah dikonfirmasi",
            'data'       => [
                'booking_id'    => $booking->id,
                'booking_uuid'  => $booking->uuid,
                'booking_code'  => $code,
                'guest_name'    => $guestName,
                'property_name' => $propertyName,
                'total_price'   => $booking->total_price,
                'status'        => 'confirmed',
                'url'           => route('bookings.show', $booking->uuid),
            ],
        ]);
    }
}
