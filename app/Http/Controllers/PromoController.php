<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Services\PromoService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    protected PromoService $promoService;

    public function __construct(PromoService $promoService)
    {
        $this->promoService = $promoService;
    }

    /**
     * Display the public promotions page.
     */
    public function index()
    {
        $promotions = \App\Models\Promotion::active()
            ->latest()
            ->get();

        return view('promo.index', compact('promotions'));
    }

    /**
     * AJAX Endpoint to validate and apply promo code.
     */
    public function checkPromo(Request $request): JsonResponse
    {
        $request->validate([
            'promo_code'          => 'required|string|max:50',
            'property_id'         => 'required|exists:properties,id',
            'check_in'            => 'required|date',
            'check_out'           => 'required|date|after:check_in',
            'current_active_code' => 'nullable|string',
        ], [
            'promo_code.required' => 'Masukkan kode promo terlebih dahulu.',
            'property_id.required' => 'Properti wajib dipilih.',
            'check_in.required'   => 'Pilih tanggal check-in.',
            'check_out.required'  => 'Pilih tanggal check-out.',
        ]);

        $property = Properties::findOrFail($request->property_id);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $nights = max(1, $checkIn->diffInDays($checkOut));
        $subtotal = $property->price * $nights;

        $result = $this->promoService->validatePromoCode(
            $request->promo_code,
            $property->id,
            $nights,
            $subtotal,
            $request->current_active_code
        );

        if (!$result['valid']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => $result['message'],
            'data'    => [
                'promotion_id'    => $result['promotion_id'],
                'code'            => $result['code'],
                'name'            => $result['name'],
                'discount_type'   => $result['discount_type'],
                'discount_value'  => $result['discount_value'],
                'discount_amount' => $result['discount_amount'],
                'discount_formatted' => 'Rp ' . number_format($result['discount_amount'], 0, ',', '.'),
                'subtotal'        => $result['subtotal'],
                'subtotal_formatted' => 'Rp ' . number_format($result['subtotal'], 0, ',', '.'),
                'final_total'     => $result['final_total'],
                'final_total_formatted' => 'Rp ' . number_format($result['final_total'], 0, ',', '.'),
            ]
        ]);
    }
}
