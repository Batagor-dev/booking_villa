<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destination extends Model
{
    use HasFactory, HasUuid, HasSlug, SoftDeletes;

    protected $table = 'destinations';

    protected $guarded = ['id', 'uuid'];

    protected $slugFrom = 'name';

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
