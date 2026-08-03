<?php

namespace App\Http\Requests;

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
            'notes'             => 'nullable|string',
        ];
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
