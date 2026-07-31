<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * SendOtpVerificationNotification
 *
 * Notifikasi ini bertanggung jawab untuk mengirimkan email verifikasi berisi 6 digit kode OTP 
 * kepada pengguna saat mendaftar akun baru atau meminta kirim ulang kode OTP.
 */
class SendOtpVerificationNotification extends Notification
{
    use Queueable;

    /**
     * Kode OTP 6 digit yang akan dikirimkan.
     *
     * @var string
     */
    public string $otp;

    /**
     * Membuat instance notifikasi baru.
     *
     * @param string $otp Kode OTP 6 digit.
     */
    public function __construct(string $otp)
    {
        $this->otp = $otp;
    }

    /**
     * Menentukan kanal notifikasi yang digunakan (email).
     *
     * @param mixed $notifiable Penerima notifikasi.
     * @return array<int, string>
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Membangun pesan email notifikasi OTP dengan tampilan mewah khas Palma.
     *
     * @param mixed $notifiable Penerima notifikasi (Model User).
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kode OTP Verifikasi Akun Palma Anda')
            ->greeting('Halo, ' . e($notifiable->name) . '!')
            ->line('Terima kasih telah bergabung bersama Palma Luxury Villas & Resorts.')
            ->line('Gunakan 6 digit kode OTP di bawah ini untuk memverifikasi alamat email Anda:')
            ->line(' ')
            ->line('**KODE OTP VERIFIKASI:**')
            ->line('## **' . $this->otp . '**')
            ->line(' ')
            ->line('Kode OTP ini berlaku selama **10 menit**. Mohon jaga kerahasiaan kode ini dan jangan berikan kepada siapa pun.')
            ->line('Jika Anda tidak merasa melakukan pendaftaran akun, silakan abaikan email ini.')
            ->salutation('Salam hangat,  ' . PHP_EOL . '**Tim Palma Luxury Sanctuary**');
    }

    /**
     * Representasi array dari notifikasi jika disimpan ke database.
     *
     * @param mixed $notifiable
     * @return array<string, mixed>
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            'otp' => $this->otp,
        ];
    }
}
