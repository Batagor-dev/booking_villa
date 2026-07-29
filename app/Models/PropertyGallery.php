<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class PropertyGallery extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'property_galleries';

    protected $guarded = ['id', 'uuid'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function property()
    {
        return $this->belongsTo(Properties::class, 'property_id');
    }
}
