<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'description',
    ];

    function user(){
        return $this->belongsTo(\App\Models\User::class);
    }

    function userBills(){
        return $this->hasMany(\Modules\FeeManagement\Entities\UserBill::class);
    }

    function course(){
        return $this->belongsTo(Course::class);
    }
}
