<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class BookingService extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'booking_services';

    protected $guarded = ['id', 'uuid'];

    protected $casts = [
        'price'    => 'decimal:2',
        'subtotal' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function propertyService()
    {
        return $this->belongsTo(PropertyServices::class, 'property_service_id');
    }
}
