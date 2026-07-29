<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertySettings extends Model
{
    use HasFactory;

    protected $table = 'property_settings';

    protected $guarded = ['id'];

    public function property()
    {
        return $this->belongsTo(Properties::class, 'property_id');
    }
}
