<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'status',
    ];

    function users(){
        return $this->hasMany(UserDepartment::class);
    }
}
