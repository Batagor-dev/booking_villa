<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|max:50|unique:users,username',
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * Pesan kesalahan khusus untuk validasi pembuatan user.
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username ini sudah digunakan, silakan pilih username lain.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.unique'      => 'Alamat email ini sudah terdaftar, silakan gunakan email lain.',
            'name.required'     => 'Nama lengkap wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min'      => 'Kata sandi minimal berisi 8 karakter.',
            'password.confirmed'=> 'Konfirmasi kata sandi tidak cocok.',
        ];
    }
}
