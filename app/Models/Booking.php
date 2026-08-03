<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $table = 'bookings';

    protected $guarded = ['id', 'uuid'];

    protected $casts = [
        'check_in'  => 'date',
        'check_out' => 'date',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function property()
    {
        return $this->belongsTo(Properties::class, 'property_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
