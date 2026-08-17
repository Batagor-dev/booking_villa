<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyRuleTranslation extends Model
{
    use HasFactory;

    protected $table = 'property_rule_translations';

    protected $fillable = [
        'property_rule_id',
        'locale',
        'title',
        'description',
    ];

    public function propertyRule(): BelongsTo
    {
        return $this->belongsTo(PropertyRule::class, 'property_rule_id');
    }
}
