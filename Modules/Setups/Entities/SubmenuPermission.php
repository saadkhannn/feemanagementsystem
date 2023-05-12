<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class SubmenuPermission extends Model
{
    protected $fillable = [
        'submenu_id',
        'permission_id',
    ];

    function menu()
    {
        return $this->hasOne(Submenu::class, 'id', 'submenu_id');
    }

    function permission()
    {
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }
}
