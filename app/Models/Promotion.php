<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'promotions';

    protected $guarded = ['id'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => 'boolean',
        'discount_value' => 'decimal:2',
        'min_transaction' => 'decimal:2',
        'max_uses' => 'integer',
        'used_count' => 'integer',
    ];

    /**
     * Scope a query to only include active promotions.
     * Handled the requirement: "ada masanya jadi kalau lewat masa itu otomatis mati"
     */
    public function scopeActive($query)
    {
        $now = now();
        return $query->where('status', true)
                     ->where('start_date', '<=', $now)
                     ->where('end_date', '>=', $now);
    }

    /**
     * Relationship to specific properties
     */
    public function properties()
    {
        return $this->belongsToMany(Properties::class, 'promotion_properties', 'promotion_id', 'property_id')->withTimestamps();
    }

    /**
     * Relationship to property types (e.g. Villa, Resort, Hotel)
     */
    public function propertyTypes()
    {
        return $this->hasMany(PromotionPropertyType::class, 'promotion_id');
    }

    /**
     * Relationship to destinations/regions
     */
    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'promotion_destinations', 'promotion_id', 'destination_id')->withTimestamps();
    }

    /**
     * Check if promotion is applicable to a given property ID.
     */
    public function isApplicableToProperty(int $propertyId): bool
    {
        if ($this->target_type === 'all') {
            return true;
        }

        if ($this->target_type === 'properties') {
            return $this->properties()->where('properties.id', $propertyId)->exists();
        }

        if ($this->target_type === 'categories') {
            $property = Properties::find($propertyId);
            if (!$property || !$property->type) return false;
            return $this->propertyTypes()->where('property_type', $property->type)->exists();
        }

        if ($this->target_type === 'destinations') {
            $property = Properties::find($propertyId);
            if (!$property || !$property->destination_id) return false;
            return $this->destinations()->where('destinations.id', $property->destination_id)->exists();
        }

        return false;
    }

    /**
     * Increment usage counter for promo.
     */
    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }
}
