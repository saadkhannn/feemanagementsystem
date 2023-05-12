<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
    	'name',
        'guard_name',
    ];
}
