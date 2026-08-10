<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Properties;
use App\Models\Review;
use Illuminate\Http\Request;

class UserReviewController extends Controller
{
    /**
     * Store a newly created review directly from property detail page.
     * Only users with confirmed bookings for this property are allowed.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'rating'      => 'required|integer|min:1|max:5',
            'comment'     => 'required|string|min:5|max:2000',
        ], [
            'rating.required'  => 'Silakan berikan rating bintang.',
            'comment.required' => 'Silakan tulis komentar ulasan Anda.',
            'comment.min'      => 'Komentar ulasan minimal 5 karakter.',
        ]);

        $userId = auth()->id();

        // 1. Verify user has a confirmed booking for this property
        $userBooking = Booking::where('property_id', $validated['property_id'])
            ->where('user_id', $userId)
            ->where('status', 'confirmed')
            ->latest()
            ->first();

        if (!$userBooking) {
            return back()->with('error', 'Maaf, hanya pelanggan yang telah memiliki reservasi terkonfirmasi di villa ini yang dapat memberikan ulasan.');
        }

        // 2. Check if user already reviewed this property
        $existingReview = Review::where('property_id', $validated['property_id'])
            ->where('user_id', $userId)
            ->first();

        if ($existingReview) {
            // Update existing review directly
            $existingReview->update([
                'rating'  => $validated['rating'],
                'comment' => $validated['comment'],
                'status'  => 'approved',
            ]);

            return back()->with('success', 'Ulasan Anda untuk villa ini berhasil diperbarui.');
        }

        Review::create([
            'property_id' => $validated['property_id'],
            'user_id'     => $userId,
            'booking_id'  => $userBooking->id,
            'rating'      => $validated['rating'],
            'comment'     => $validated['comment'],
            'status'      => 'approved',
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }

    /**
     * Update the specified review directly.
     */
    public function update(Request $request, Review $review)
    {
        if (!$review->isEditableByCustomer()) {
            return back()->with('error', 'Ulasan hanya dapat diubah dalam batas waktu 3 jam setelah dikirim.');
        }

        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:2000',
        ], [
            'rating.required'  => 'Silakan pilih rating bintang.',
            'comment.required' => 'Silakan isi komentar ulasan Anda.',
            'comment.min'      => 'Komentar ulasan minimal 5 karakter.',
        ]);

        $review->update([
            'rating'  => $validated['rating'],
            'comment' => $validated['comment'],
            'status'  => 'approved',
        ]);

        return back()->with('success', 'Ulasan Anda berhasil diperbarui.');
    }

    /**
     * Soft delete customer review.
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $review->delete();

        return back()->with('success', 'Ulasan Anda telah berhasil dihapus.');
    }
}
