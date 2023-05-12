<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class CourseFee extends Model
{
    protected $fillable = [
        'course_id',
        'date',
        'fee',
        'description',
    ];

    function course(){
        return $this->belongsTo(Course::class);
    }
}
