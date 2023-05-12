<?php

namespace Modules\FeeManagement\Entities;

use Illuminate\Database\Eloquent\Model;

class UserBill extends Model
{
    protected $fillable = [
        'user_course_id',
        'deadline',
        'fee',
        'description',
    ];

    function userCourse(){
        return $this->hasOne(\Modules\Setups\Entities\UserCourse::class, 'id', 'user_course_id');
    }

    function billCollections(){
        return $this->hasMany(BillCollection::class, 'user_bill_id', 'id');
    }
}
