<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyRule extends Model
{
    use HasFactory, HasUuid, SoftDeletes, HasTranslations;

    protected $table = 'property_rules';

    protected $guarded = ['id', 'uuid'];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getTitleAttribute($value)
    {
        return $this->translate('title') ?: $value;
    }

    public function getDescriptionAttribute($value)
    {
        return $this->translate('description') ?: $value;
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForPropertyType($query, $type)
    {
        return $query->where(function ($q) use ($type) {
            $q->where('property_type', 'all')
              ->orWhere('property_type', $type);
        });
    }
}
