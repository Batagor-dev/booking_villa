<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasSlug;

class Properties extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $table = 'properties';

    protected $guarded = ['id'];

    protected $slugFrom = 'name';

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
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
