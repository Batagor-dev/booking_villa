<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name'     => ['required', 'string', 'max:255'],
            'username' => [
                'required', 
                'string', 
                'max:50', 
                Rule::unique(User::class, 'username'),
            ],
            'email'    => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class, 'email'),
            ],
            'password' => $this->passwordRules(),
        ], [
            'name.required'        => 'Nama lengkap wajib diisi.',
            'username.required'    => 'Username wajib diisi.',
            'username.unique'      => 'Username ini sudah digunakan, silakan pilih username lain.',
            'email.required'       => 'Alamat email wajib diisi.',
            'email.email'          => 'Format alamat email tidak valid.',
            'email.unique'         => 'Alamat email ini sudah terdaftar, silakan gunakan email lain atau langsung masuk.',
            'password.required'    => 'Kata sandi wajib diisi.',
            'password.confirmed'   => 'Konfirmasi kata sandi tidak cocok.',
        ])->validate();

        $user = User::create([
            'name'     => $input['name'],
            'username' => $input['username'],
            'email'    => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $userRole = Role::whereRaw('LOWER(name) = ?', ['user'])->first();
        if ($userRole) {
            $user->assignRole($userRole);
        } else {
            $user->assignRole('User');
        }

        return $user;
    }

}
