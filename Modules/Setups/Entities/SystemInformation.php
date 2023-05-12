<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class SystemInformation extends Model
{
    protected $fillable = [
        'name',
        'description',
        'motto',
        'tagline',
        'phone',
        'mobile',
        'address',
        'email',
        'website',
        'twitter',
        'facebook',
        'instagram',
        'skype',
        'linked_in',
        'logo',
        'secondary_logo',
        'icon',
        'status',
    ];
}
