<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class OtpVerificationController
 *
 * Controller ini menangani seluruh alur verifikasi email menggunakan kode OTP 6 digit.
 * Menggantikan mekanisme link verifikasi standar menjadi verifikasi berbasis kode OTP.
 */
class OtpVerificationController extends Controller
{
    /**
     * Menampilkan halaman verifikasi OTP.
     *
     * Jika pengguna sudah melakukan verifikasi email sebelumnya, pengguna akan otomatis 
     * diarahkan ke halaman dashboard. Apabila belum pernah dikirimkan OTP atau OTP telah kadaluarsa,
     * sistem secara otomatis akan membuatkan OTP baru dan mengirimkannya via email.
     *
     * @param Request $request Request HTTP yang masuk.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request)
    {
        $user = $request->user();

        // Jika email sudah terverifikasi, langsung arahkan ke dashboard
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(config('fortify.home', '/dashboard'));
        }

        // Jika belum memiliki OTP aktif atau OTP sudah kadaluarsa, buatkan OTP baru & kirimkan
        if (empty($user->otp_code) || empty($user->otp_expires_at) || now()->greaterThan($user->otp_expires_at)) {
            $user->sendEmailVerificationNotification();
            session()->flash('status', 'Kode OTP 6 digit baru telah dikirimkan ke email Anda.');
        }

        return view('auth.verify-email-otp');
    }

    /**
     * Memproses verifikasi kode OTP yang dimasukkan oleh pengguna.
     *
     * Menerima input 6 digit kode OTP, memvalidasinya terhadap data di tabel users.
     * Jika berhasil, email ditandai sebagai terverifikasi dan pengguna diarahkan ke dashboard.
     * Jika gagal atau kadaluarsa, mengembalikan pesan kesalahan yang sesuai.
     *
     * @param Request $request Request HTTP yang berisi 'otp_code'.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'size:6'],
        ], [
            'otp_code.required' => 'Silakan masukkan 6 digit kode OTP.',
            'otp_code.size' => 'Kode OTP harus berjumlah tepat 6 digit.',
        ]);

        $user = $request->user();

        // Cek apakah email pengguna sudah terverifikasi
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(config('fortify.home', '/dashboard'));
        }

        // Jalankan verifikasi OTP melalui method di Model User
        if ($user->verifyOtpCode($request->input('otp_code'))) {
            return redirect()->intended(config('fortify.home', '/dashboard'))
                ->with('success', 'Email Anda berhasil diverifikasi! Selamat datang di Palma Luxury.');
        }

        return back()->withErrors([
            'otp_code' => 'Kode OTP tidak valid atau telah kadaluarsa. Silakan periksa kembali atau minta kode baru.',
        ])->withInput();
    }

    /**
     * Mengirim ulang (resend) kode OTP ke alamat email pengguna.
     *
     * Membuat kode OTP 6 digit baru, memperbarui masa berlaku 10 menit,
     * dan mengirimkan email notifikasi ke pengguna.
     *
     * @param Request $request Request HTTP yang masuk.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(config('fortify.home', '/dashboard'));
        }

        $user->sendEmailVerificationNotification();

        return back()->with('status', 'Kode OTP 6 digit baru telah berhasil dikirimkan ke email Anda. Silakan cek Inbox atau Folder Spam.');
    }
}
