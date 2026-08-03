<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Traits\HasUuid;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasRoles, Notifiable, HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'google_id',
        'foto',
        'email',
        'gender',
        'phone',
        'address',
        'identity_type',
        'identity_image',
        'password',
        'banned_at',
        'otp_code',
        'otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'banned_at' => 'datetime',
            'otp_expires_at' => 'datetime',
        ];
    }

    /**
     * Menghasilkan kode OTP 6 digit acak yang aman dan menetapkan masa berlaku selama 10 menit.
     *
     * @return string Kode OTP 6 digit yang baru dihasilkan.
     */
    public function generateOtpCode(): string
    {
        $otp = sprintf('%06d', random_int(0, 999999));
        
        $this->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        return $otp;
    }

    /**
     * Memverifikasi apakah kode OTP yang dimasukkan oleh pengguna cocok dan belum kadaluarsa.
     *
     * @param string $code Kode OTP 6 digit yang dimasukkan pengguna.
     * @return bool True jika verifikasi berhasil, False jika tidak valid/kadaluarsa.
     */
    public function verifyOtpCode(string $code): bool
    {
        if (empty($this->otp_code) || empty($this->otp_expires_at)) {
            return false;
        }

        if (now()->greaterThan($this->otp_expires_at)) {
            return false;
        }

        if (trim($this->otp_code) !== trim($code)) {
            return false;
        }

        // Tandai email sebagai terverifikasi dan bersihkan kode OTP dari database
        $this->forceFill([
            'email_verified_at' => now(),
            'otp_code' => null,
            'otp_expires_at' => null,
        ])->save();

        return true;
    }

    /**
     * Mengirimkan notifikasi verifikasi email berisi kode OTP ke alamat email pengguna.
     * Override dari method bawaan Laravel Authenticatable.
     *
     * @return void
     */
    public function sendEmailVerificationNotification(): void
    {
        $otp = $this->generateOtpCode();
        $this->notify(new \App\Notifications\SendOtpVerificationNotification($otp));
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id');
    }
}
