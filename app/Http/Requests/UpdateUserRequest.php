<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateUserRequest extends FormRequest
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
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username')->ignore($this->user->id),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email')->ignore($this->user->id),
            ],
            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,gif',
                'max:2048',
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ];
    }

    /**
     * Pesan kesalahan khusus untuk validasi pembaruan user.
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username ini sudah digunakan, silakan pilih username lain.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.unique'      => 'Alamat email ini sudah terdaftar, silakan gunakan email lain.',
            'name.required'     => 'Nama lengkap wajib diisi.',
            'password.min'      => 'Kata sandi minimal berisi 8 karakter.',
            'password.confirmed'=> 'Konfirmasi kata sandi tidak cocok.',
        ];
    }
}
