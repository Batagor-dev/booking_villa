<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use App\Models\Traits\HasSlug;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destination extends Model
{
    use HasFactory, HasUuid, HasSlug, SoftDeletes, HasTranslations;

    protected $table = 'destinations';

    protected $guarded = ['id', 'uuid'];

    protected $slugFrom = 'name';

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?: $value;
    }

    public function getAttractionAttribute($value)
    {
        return $this->translate('attraction') ?: $value;
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function properties()
    {
        return $this->hasMany(Properties::class, 'destination_id');
    }

    public function getFormattedTagsAttribute(): array
    {
        if (empty($this->tags)) {
            return [];
        }
        if (is_array($this->tags)) {
            return $this->tags;
        }
        return array_values(array_filter(array_map('trim', explode(',', $this->tags))));
    }
}
