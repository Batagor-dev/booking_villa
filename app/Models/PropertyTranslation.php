<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyTranslation extends Model
{
    use HasFactory;

    protected $table = 'property_translations';

    protected $fillable = [
        'property_id',
        'locale',
        'name',
        'slug',
        'short_description',
        'description',
        'address',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Properties::class, 'property_id');
    }
}
