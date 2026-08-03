<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = $this->user()?->id;

        return [
            'name'             => 'required|string|max:255',
            'email'            => ['required', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'phone'            => 'nullable|string|max:50',
            'gender'           => 'nullable|in:L,P',
            'identity_type'    => 'nullable|in:ktp,paspor,sim',
            'identity_image'   => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'address'          => 'nullable|string|max:500',
            'current_password' => 'nullable|string|required_with:new_password',
            'new_password'     => 'nullable|string|min:8|confirmed',
        ];
    }

    /**
     * Pesan kesalahan khusus untuk validasi pembaruan akun pengguna.
     */
    public function messages(): array
    {
        return [
            'name.required'                  => 'Nama lengkap wajib diisi.',
            'email.required'                 => 'Alamat email wajib diisi.',
            'email.unique'                   => 'Email ini sudah digunakan oleh akun lain.',
            'current_password.required_with' => 'Masukkan kata sandi lama Anda untuk mengubah kata sandi.',
            'new_password.min'               => 'Kata sandi baru minimal harus 8 karakter.',
            'new_password.confirmed'         => 'Konfirmasi kata sandi baru tidak cocok.',
        ];
    }
}
