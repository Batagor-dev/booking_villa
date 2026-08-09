<?php

namespace App\Services;

use App\Models\Promotion;
use App\Models\Properties;
use Carbon\Carbon;
use Exception;

class PromoService
{
    /**
     * Validate a promo code for a specific property and booking parameters.
     * Enforces SINGLE PROMO policy (no double promo / code stacking).
     *
     * @param string $code Input promo code
     * @param int $propertyId ID of the property being booked
     * @param int $nights Total nights stay
     * @param float $subtotal Total price before discount
     * @param string|null $currentActiveCode Currently applied active promo code (if any)
     * @return array Result containing valid status, discount_amount, final_total, promotion object, and descriptive message.
     */
    public function validatePromoCode(
        string $code,
        int $propertyId,
        int $nights = 1,
        float $subtotal = 0.0,
        ?string $currentActiveCode = null
    ): array {
        $cleanCode = strtoupper(trim($code));

        if (empty($cleanCode)) {
            return [
                'valid'   => false,
                'message' => 'Silakan masukkan kode promo.',
            ];
        }

        // 1. Enforce Single Promo Rule (No Double Promo / Stacking)
        if (!empty($currentActiveCode) && strtoupper(trim($currentActiveCode)) !== $cleanCode) {
            return [
                'valid'   => false,
                'message' => 'Hanya bisa menggunakan 1 kode promo dalam satu pemesanan (tidak bisa digabung / double promo). Hapus promo aktif terlebih dahulu jika ingin menggantinya.',
            ];
        }

        // 2. Fetch Promo Record
        $promo = Promotion::where('code', $cleanCode)->first();

        if (!$promo) {
            return [
                'valid'   => false,
                'message' => "Kode promo '{$cleanCode}' tidak ditemukan.",
            ];
        }

        // 3. Check Active Status
        if (!$promo->status) {
            return [
                'valid'   => false,
                'message' => "Kode promo '{$cleanCode}' sedang tidak aktif.",
            ];
        }

        // 4. Check Date Validity (Start & End Date)
        $now = now();
        if ($promo->start_date && $now->lt($promo->start_date)) {
            return [
                'valid'   => false,
                'message' => "Kode promo '{$cleanCode}' belum berlaku. Promo mulai aktif pada " . $promo->start_date->format('d M Y H:i') . '.',
            ];
        }

        if ($promo->end_date && $now->gt($promo->end_date)) {
            return [
                'valid'   => false,
                'message' => "Kode promo '{$cleanCode}' telah kadaluarsa pada " . $promo->end_date->format('d M Y H:i') . '.',
            ];
        }

        // 5. Check Usage Limit (max_uses)
        if (!is_null($promo->max_uses) && $promo->used_count >= $promo->max_uses) {
            return [
                'valid'   => false,
                'message' => "Kode promo '{$cleanCode}' telah mencapai batas maksimal kuota penggunaan.",
            ];
        }

        // 6. Check Property Scope Applicability (Property-specific vs Global)
        if (!$promo->isApplicableToProperty($propertyId)) {
            $property = Properties::find($propertyId);
            $propertyName = $property ? $property->name : 'villa ini';

            return [
                'valid'   => false,
                'message' => "Kode promo '{$cleanCode}' khusus berlaku untuk villa/properti tertentu dan tidak dapat digunakan pada {$propertyName}.",
            ];
        }

        // 7. Check Minimum Nights Requirement
        if (!is_null($promo->min_nights) && $nights < $promo->min_nights) {
            return [
                'valid'   => false,
                'message' => "Kode promo '{$cleanCode}' membutuhkan minimal durasi menginap {$promo->min_nights} malam. (Durasi Anda: {$nights} malam).",
            ];
        }

        // 8. Check Minimum Transaction Amount
        if (!is_null($promo->min_transaction) && $subtotal < $promo->min_transaction) {
            $formattedMin = 'Rp ' . number_format($promo->min_transaction, 0, ',', '.');
            $formattedSub = 'Rp ' . number_format($subtotal, 0, ',', '.');

            return [
                'valid'   => false,
                'message' => "Kode promo '{$cleanCode}' membutuhkan minimal subtotal transaksi sebesar {$formattedMin}. (Subtotal Anda: {$formattedSub}).",
            ];
        }

        // 9. Calculate Discount Amount
        $discountAmount = 0.0;
        if ($promo->discount_type === 'percentage') {
            $discountAmount = ($subtotal * ($promo->discount_value / 100));
        } else {
            $discountAmount = (float) $promo->discount_value;
        }

        // Cap discount so it never exceeds subtotal
        $discountAmount = min($subtotal, max(0, $discountAmount));
        $finalTotal = max(0, $subtotal - $discountAmount);

        return [
            'valid'           => true,
            'promotion_id'    => $promo->id,
            'code'            => $promo->code,
            'name'            => $promo->name,
            'discount_type'   => $promo->discount_type,
            'discount_value'  => (float) $promo->discount_value,
            'discount_amount' => $discountAmount,
            'subtotal'        => $subtotal,
            'final_total'     => $finalTotal,
            'message'         => "Kode promo '{$promo->code}' berhasil dipasang! Anda hemat " . 'Rp ' . number_format($discountAmount, 0, ',', '.') . '.',
        ];
    }
}
