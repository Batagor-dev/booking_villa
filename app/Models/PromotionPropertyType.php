<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionPropertyType extends Model
{
    use HasFactory;

    protected $table = 'promotion_property_types';

    protected $guarded = ['id'];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }
}
