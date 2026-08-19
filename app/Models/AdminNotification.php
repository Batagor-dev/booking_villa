<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasUuid;

class AdminNotification extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $table = 'admin_notifications';

    protected $guarded = ['id', 'uuid'];

    protected $casts = [
        'data'    => 'array',
        'read_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRecent($query)
    {
        return $query->latest()->limit(30);
    }

    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }

    public function markAsRead(): bool
    {
        if ($this->isUnread()) {
            return $this->update(['read_at' => now()]);
        }
        return false;
    }
}
