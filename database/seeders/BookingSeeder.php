<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Properties;
use App\Models\PaymentMethod;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $property = Properties::first();
        $paymentMethod = PaymentMethod::first();

        if ($property && $paymentMethod) {
            Booking::create([
                'booking_code'      => 'BOOK-' . date('Ymd') . '-SAMPLE1',
                'property_id'       => $property->id,
                'user_id'           => null,
                'guest_name'        => 'Alexander Wright',
                'guest_email'       => 'alex.wright@example.com',
                'guest_phone'       => '+62 812 9876 5432',
                'check_in'          => Carbon::today()->addDays(5)->format('Y-m-d'),
                'check_out'         => Carbon::today()->addDays(8)->format('Y-m-d'),
                'total_nights'      => 3,
                'total_price'       => $property->price * 3,
                'payment_method_id' => $paymentMethod->id,
                'payment_type'      => $paymentMethod->name,
                'bukti_payment'     => 'booking-receipts/sample_receipt.jpg',
                'status'            => 'confirmed',
                'notes'             => 'Permintaan check-in awal jika memungkinkan.',
            ]);
        }
    }
}
