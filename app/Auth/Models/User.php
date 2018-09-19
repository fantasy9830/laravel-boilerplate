<?php

namespace App\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class User extends Model
{
    use HasRoles;

    protected $table = 'users';

    protected $guard_name = 'web';

    protected $fillable = [
        'name', 'username', 'secret', 'email', 'address',
    ];

    public static function create(array $attributes = [])
    {
        $attributes['secret'] = bcrypt($attributes['password']);

        unset($attributes['password']);

        return static::query()->create($attributes);
    }
}
