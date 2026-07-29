<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facilities extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $table = 'facilities';

    protected $guarded = ['id', 'uuid'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function properties()
    {
        return $this->belongsToMany(Properties::class, 'property_facilities', 'facility_id', 'property_id')->withTimestamps();
    }
}
