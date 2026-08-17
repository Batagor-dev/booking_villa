<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromotionTranslation extends Model
{
    use HasFactory;

    protected $table = 'promotion_translations';

    protected $fillable = [
        'promotion_id',
        'locale',
        'name',
        'description',
    ];

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }
}
