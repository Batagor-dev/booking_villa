<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermissionGroup extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(self::class, 'permission_group_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'permission_group_id');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'permission_group_id');
    }

    public function menuGroups()
    {
        return $this->hasMany(MenuGroup::class, 'permission_group_id');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

}
