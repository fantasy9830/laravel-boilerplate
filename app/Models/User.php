<?php

namespace App\Models;

//use Illuminate\Notifications\Notifiable;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    //use Notifiable;
    use HasRoles;

    protected $guard_name = 'api';

    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'name',
        'nickname',
        'gender',
        'email',
    ];

    protected $hidden = [
        'password'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->password = bcrypt($model->password);
        });
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
