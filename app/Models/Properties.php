<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasSlug;

class Properties extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $table = 'properties';

    protected $guarded = ['id'];

    protected $slugFrom = 'name';

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }

    public function settings()
    {
        return $this->hasOne(PropertySettings::class, 'property_id');
    }

    public function galleries()
    {
        return $this->hasMany(PropertyGallery::class, 'property_id')->orderBy('sort');
    }

    public function facilities()
    {
        return $this->belongsToMany(Facilities::class, 'property_facilities', 'property_id', 'facility_id')->withTimestamps();
    }

    public function services()
    {
        return $this->hasMany(PropertyServices::class, 'property_id');
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_properties', 'property_id', 'promotion_id')->withTimestamps();
    }

    /**
     * Get active promotion specifically targeting this property or automatic promo.
     * Prevents general voucher codes (target_type = 'all') from decorating every villa card.
     */
    public function getActivePromotion()
    {
        $now = now();

        // 1. Specific property promotion with CODE (prioritized so promo code is passed to booking)
        $specificCodePromo = $this->promotions()
            ->where('status', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->whereNotNull('code')
            ->where('code', '!=', '')
            ->first();

        if ($specificCodePromo) {
            return $specificCodePromo;
        }

        // 2. Specific property promotion (automatic / without code)
        $specificPromo = $this->promotions()
            ->where('status', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->first();

        if ($specificPromo) {
            return $specificPromo;
        }

        // 2. Destination promo
        if ($this->destination_id) {
            $destPromo = Promotion::active()
                ->where('target_type', 'destinations')
                ->whereHas('destinations', function($q) {
                    $q->where('destinations.id', $this->destination_id);
                })->first();

            if ($destPromo) return $destPromo;
        }

        // 3. Category/Type promo
        if ($this->type) {
            $catPromo = Promotion::active()
                ->where('target_type', 'categories')
                ->whereHas('propertyTypes', function($q) {
                    $q->where('property_type', $this->type);
                })->first();

            if ($catPromo) return $catPromo;
        }

        // 4. Automatic promotion for all (not code-based global vouchers)
        return Promotion::active()
            ->where('target_type', 'all')
            ->where('promotion_type', 'automatic')
            ->first();
    }

    /**
     * Get formatted active promo details for display in views.
     */
    public function getActivePromoDetailsAttribute(): ?array
    {
        $promo = $this->getActivePromotion();
        if (!$promo) return null;

        $basePrice = (float) $this->price;
        $discountAmount = 0.0;

        if ($promo->discount_type === 'percentage') {
            $discountAmount = $basePrice * ($promo->discount_value / 100);
        } else {
            $discountAmount = (float) $promo->discount_value;
        }

        $discountAmount = min($basePrice, max(0, $discountAmount));
        $finalPrice = max(0, $basePrice - $discountAmount);

        $badgeText = $promo->discount_type === 'percentage'
            ? 'Diskon ' . number_format($promo->discount_value, 0) . '%'
            : 'Hemat Rp ' . number_format($promo->discount_value, 0, ',', '.');

        return [
            'promotion_id'    => $promo->id,
            'code'            => $promo->code,
            'name'            => $promo->name,
            'promotion_type'  => $promo->promotion_type,
            'discount_type'   => $promo->discount_type,
            'discount_value'  => (float) $promo->discount_value,
            'discount_amount' => $discountAmount,
            'original_price'  => $basePrice,
            'final_price'     => $finalPrice,
            'badge_text'      => $badgeText,
        ];
    }
}
