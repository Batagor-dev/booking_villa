<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyFacilities extends Model
{
    use HasFactory;

    protected $table = 'property_facilities';

    protected $guarded = ['id'];

    public function property()
    {
        return $this->belongsTo(Properties::class, 'property_id');
    }

    public function facility()
    {
        return $this->belongsTo(Facilities::class, 'facility_id');
    }
}
