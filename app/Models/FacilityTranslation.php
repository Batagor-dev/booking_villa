<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacilityTranslation extends Model
{
    use HasFactory;

    protected $table = 'facility_translations';

    protected $fillable = [
        'facility_id',
        'locale',
        'name',
        'description',
    ];

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facilities::class, 'facility_id');
    }
}
