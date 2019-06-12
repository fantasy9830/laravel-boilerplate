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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'nickname' => $this->nickname,
            'roles' => $this->getRoleNames(),
            'permissions' => $this->getAllPermissions()
                ->groupBy('guard_name')
                ->flatMap(function ($item) {
                    return $item->pluck('name');
                })
                ->reduce(function ($carry, $permission) {
                    [$action, $name] = explode('_', $permission);
                    $carry[$name][] = $action;

                    return $carry;
                }, []),
        ];
    }

    public static function create(array $attributes = [])
    {
        $attributes['password'] = bcrypt($attributes['password']);

        return static::query()->create($attributes);
    }
}
