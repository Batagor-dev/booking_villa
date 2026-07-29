<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Properties extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $table = 'properties';

    protected $guarded = ['id', 'uuid'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function settings()
    {
        return $this->hasOne(PropertySettings::class, 'property_id');
    }

    public function galleries()
    {
        return $this->hasMany(PropertyGallery::class, 'property_id')->orderBy('sort');
    }

    public function facilities()
    {
        return $this->belongsToMany(Facilities::class, 'property_facilities', 'property_id', 'facility_id')->withTimestamps();
    }

    public function services()
    {
        return $this->hasMany(PropertyServices::class, 'property_id');
    }
}
