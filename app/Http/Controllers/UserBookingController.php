<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserBookingController extends Controller
{
    /**
     * Display the list of bookings for the logged-in user (My Bookings & History).
     */
    public function bookings(Request $request)
    {
        $user = auth()->user();

        $query = Booking::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere('guest_email', $user->email);
        })->with(['property', 'paymentMethod'])->latest();

        $statusFilter = $request->query('status');
        if ($statusFilter && in_array($statusFilter, ['pending', 'confirmed', 'cancelled'])) {
            $query->where('status', $statusFilter);
        }

        $bookings = $query->get();

        // Calculate counts for tab badges
        $allUserBookings = Booking::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere('guest_email', $user->email);
        })->get();

        $totalCount     = $allUserBookings->count();
        $pendingCount   = $allUserBookings->where('status', 'pending')->count();
        $confirmedCount = $allUserBookings->where('status', 'confirmed')->count();
        $cancelledCount = $allUserBookings->where('status', 'cancelled')->count();

        return view('frontend.user.bookings', compact(
            'bookings',
            'totalCount',
            'pendingCount',
            'confirmedCount',
            'cancelledCount',
            'statusFilter'
        ));
    }

    /**
     * Display user profile & account management form.
     */
    public function account()
    {
        $user = auth()->user();
        return view('frontend.user.account', compact('user'));
    }

    /**
     * Update user profile information or password.
     */
    public function updateAccount(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone'            => 'nullable|string|max:50',
            'address'          => 'nullable|string|max:500',
            'current_password' => 'nullable|string|required_with:new_password',
            'new_password'     => 'nullable|string|min:8|confirmed',
        ], [
            'name.required'             => 'Nama lengkap wajib diisi.',
            'email.required'            => 'Alamat email wajib diisi.',
            'email.unique'              => 'Email ini sudah digunakan oleh akun lain.',
            'current_password.required_with' => 'Masukkan kata sandi lama Anda untuk mengubah kata sandi.',
            'new_password.min'          => 'Kata sandi baru minimal harus 8 karakter.',
            'new_password.confirmed'    => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        // If changing password, verify current password
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.'])->withInput();
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->name    = $validated['name'];
        $user->email   = $validated['email'];
        $user->phone   = $validated['phone'] ?? $user->phone;
        $user->address = $validated['address'] ?? $user->address;
        $user->save();

        return redirect()->back()->with('success_account', 'Profil dan informasi akun Anda berhasil diperbarui.');
    }
}
