<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'id' => 1,
        'name' => 'read_user',
        'guard_name' => 'api',
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
