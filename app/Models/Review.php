<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasUuid;

class Review extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $table = 'reviews';

    protected $guarded = ['id', 'uuid'];

    protected $casts = [
        'rating' => 'integer',
        'admin_replied_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function property()
    {
        return $this->belongsTo(Properties::class, 'property_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Check if the customer is allowed to edit this review (within 3 hours).
     */
    public function isEditableByCustomer(?int $userId = null): bool
    {
        $userId = $userId ?? auth()->id();
        
        if ($this->user_id !== $userId) {
            return false;
        }

        // Editable strictly within 3 hours of creation
        return $this->created_at->diffInHours(now()) <= 3;
    }

    /**
     * Recalculate and update the property's average rating cached in properties table.
     */
    public static function recalculatePropertyRating(int $propertyId): void
    {
        $avgRating = self::where('property_id', $propertyId)
            ->where('status', 'approved')
            ->avg('rating');

        $roundedRating = $avgRating ? round($avgRating, 2) : 0.00;

        Properties::where('id', $propertyId)->update(['rating' => $roundedRating]);
    }

    protected static function booted()
    {
        static::saved(function ($review) {
            static::recalculatePropertyRating($review->property_id);
        });

        static::deleted(function ($review) {
            static::recalculatePropertyRating($review->property_id);
        });
    }
}
