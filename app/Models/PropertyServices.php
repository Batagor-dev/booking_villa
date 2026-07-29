<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyServices extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $table = 'property_services';

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

