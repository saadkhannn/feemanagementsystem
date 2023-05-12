<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
    	'module',
        'name',
        'guard_name',
    ];
}
