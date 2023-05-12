<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'status',
    ];

    function fees(){
        return $this->hasMany(CourseFee::class);
    }

    function users(){
        return $this->hasMany(UserCourse::class);
    }
}
