<?php

namespace App\Http\Controllers;

use App\DataTables\ReviewDataTable;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of all reviews for Admin Panel.
     */
    public function index(ReviewDataTable $dataTable)
    {
        return $dataTable->render('review.index');
    }

    /**
     * Show the form for editing/moderating the specified review.
     */
    public function edit(Review $review)
    {
        $review->load(['property', 'user', 'booking']);
        return view('review.edit', compact('review'));
    }

    /**
     * Update moderation status and/or admin reply.
     */
    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'status'      => 'required|in:pending,approved,rejected',
            'admin_reply' => 'nullable|string|max:2000',
        ], [
            'status.required' => 'Silakan pilih status moderasi.',
            'status.in'       => 'Status moderasi tidak valid.',
        ]);

        $updateData = [
            'status' => $validated['status'],
        ];

        if ($request->has('admin_reply')) {
            $updateData['admin_reply'] = $validated['admin_reply'];
            if (!empty($validated['admin_reply']) && empty($review->admin_replied_at)) {
                $updateData['admin_replied_at'] = now();
            }
        }

        $review->update($updateData);

        return redirect()->route('reviews.index')->with('success', 'Status moderasi & balasan ulasan berhasil diperbarui.');
    }

    /**
     * Remove (soft delete) the specified review from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Ulasan berhasil dihapus (soft delete).',
            ]);
        }

        return redirect()->route('reviews.index')->with('success', 'Ulasan berhasil dihapus.');
    }
}
