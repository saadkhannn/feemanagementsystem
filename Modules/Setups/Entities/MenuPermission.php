<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class MenuPermission extends Model
{
    protected $fillable = [
        'menu_id',
        'permission_id',
    ];

    function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id');
    }

    function permission()
    {
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }
}
