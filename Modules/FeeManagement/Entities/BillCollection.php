<?php

namespace Modules\FeeManagement\Entities;

use Illuminate\Database\Eloquent\Model;

class BillCollection extends Model
{
    public $table = 'user_bill_collections';
    protected $fillable = [
        'user_bill_id',
        'date',
        'collection',
        'description',
    ];

    function userBill(){
        return $this->belongsTo(UserBill::class);
    }
}
