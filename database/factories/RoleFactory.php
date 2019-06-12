<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'id' => 1,
        'name' => 'admin',
        'guard_name' => 'api',
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
