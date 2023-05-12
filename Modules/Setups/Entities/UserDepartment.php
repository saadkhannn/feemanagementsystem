<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
        'description',
    ];

    function user(){
        return $this->belongsTo(\App\User::class);
    }

    function department(){
        return $this->belongsTo(Department::class);
    }
}
