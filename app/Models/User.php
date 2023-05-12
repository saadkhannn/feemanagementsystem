<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'email_verified_at',
        'password',
        'gender',
        'image',
        'is_developer',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function departments(){
        return $this->hasMany(\Modules\Setups\Entities\UserDepartment::class);
    }

    function courses(){
        return $this->hasMany(\Modules\Setups\Entities\UserCourse::class);
    }

    public function anyPermissions(array $permissions)
    {
        $user_permissions = auth()->user()->getAllPermissions()->pluck('name')->toArray();
        foreach($permissions as $e){
            if(in_array($e, $user_permissions)) return true;
        }

        return false;
    }

    public function allPermissions(array $permissions)
    {
        $user_permissions = auth()->user()->getAllPermissions()->pluck('name')->toArray();
        foreach($permissions as $e){
            if(!in_array($e, $user_permissions)) return false;
        }

        return true;
    }
}
