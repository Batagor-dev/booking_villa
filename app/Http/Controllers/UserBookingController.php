<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;
use App\Http\Requests\UpdateUserAccountRequest;

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
        })->with(['property', 'paymentMethod', 'review'])->latest();

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
    public function updateAccount(UpdateUserAccountRequest $request, ImageService $imageService)
    {
        $user = auth()->user();
        $validated = $request->validated();

        // If changing password, verify current password
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'Kata sandi saat ini tidak cocok.')->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.'])->withInput();
            }
            $user->password = Hash::make($request->new_password);
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $compressed = $imageService->compress($file);
            $fileName = time() . '_' . uniqid() . '.jpg';

            Storage::disk('public')->put('uploads/users/' . $fileName, $compressed);

            if ($user->foto && !str_starts_with($user->foto, 'avatar-') && Storage::disk('public')->exists('uploads/users/' . $user->foto)) {
                Storage::disk('public')->delete('uploads/users/' . $user->foto);
            }

            $user->foto = $fileName;
        }

        if ($request->hasFile('identity_image')) {
            $file = $request->file('identity_image');
            $compressed = $imageService->compress($file);
            $fileName = 'identity_' . time() . '_' . uniqid() . '.jpg';

            Storage::disk('public')->put('uploads/identities/' . $fileName, $compressed);

            if ($user->identity_image && Storage::disk('public')->exists('uploads/identities/' . $user->identity_image)) {
                Storage::disk('public')->delete('uploads/identities/' . $user->identity_image);
            }

            $user->identity_image = $fileName;
        }

        $user->name          = $validated['name'];
        $user->email         = $validated['email'];
        $user->phone         = $validated['phone'] ?? $user->phone;
        $user->gender        = $validated['gender'] ?? $user->gender;
        $user->identity_type = $validated['identity_type'] ?? $user->identity_type;
        $user->address       = $validated['address'] ?? $user->address;
        $user->save();

        return redirect()->back()->with('success', 'Profil dan informasi akun Anda berhasil diperbarui.');
    }
}
