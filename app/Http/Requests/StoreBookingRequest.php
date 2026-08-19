<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'property_id'       => 'required|exists:properties,id',
            'check_in'          => 'required|date|after_or_equal:today',
            'check_out'         => 'required|date|after:check_in',
            'guest_name'        => 'required|string|max:255',
            'guest_email'       => 'required|email|max:255',
            'guest_phone'       => 'required|string|max:50',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'bukti_payment'     => 'required|image|file|max:5120', // Max 5MB image
            'promo_code'        => 'nullable|string|max:50',
            'services'          => 'nullable|array',
            'services.*.id'     => 'nullable|exists:property_services,id',
            'services.*.qty'    => 'nullable|integer|min:1',
            'notes'             => 'nullable|string',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled('property_id') && $this->filled('check_in') && $this->filled('check_out')) {
                $checkIn = Carbon::parse($this->check_in);
                $checkOut = Carbon::parse($this->check_out);

                if ($checkOut->greaterThan($checkIn)) {
                    $hasConflict = Booking::where('property_id', $this->property_id)
                        ->whereIn('status', ['confirmed', 'pending'])
                        ->where(function ($query) use ($checkIn, $checkOut) {
                            $query->where('check_in', '<', $checkOut->format('Y-m-d'))
                                  ->where('check_out', '>', $checkIn->format('Y-m-d'));
                        })
                        ->exists();

                    if ($hasConflict) {
                        $validator->errors()->add(
                            'check_in',
                            'Jadwal pada tanggal ' . $checkIn->translatedFormat('d M Y') . ' s/d ' . $checkOut->translatedFormat('d M Y') . ' sudah terisi (booked) untuk properti ini. Silakan pilih tanggal lain.'
                        );
                    }
                }
            }
        });
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'property_id.required'       => 'Properti harus dipilih.',
            'check_in.required'          => 'Tanggal check-in wajib diisi.',
            'check_in.after_or_equal'    => 'Tanggal check-in tidak boleh lewat dari hari ini.',
            'check_out.required'         => 'Tanggal check-out wajib diisi.',
            'check_out.after'            => 'Tanggal check-out harus setelah tanggal check-in.',
            'guest_name.required'        => 'Nama lengkap tamu wajib diisi.',
            'guest_email.required'       => 'Email tamu wajib diisi.',
            'guest_phone.required'       => 'Nomor telepon/WhatsApp wajib diisi.',
            'payment_method_id.required' => 'Metode pembayaran wajib dipilih.',
            'bukti_payment.required'     => 'Bukti pembayaran wajib diunggah.',
            'bukti_payment.image'        => 'Bukti pembayaran harus berupa file gambar (JPG, PNG, WebP).',
        ];
    }
}
