<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'id' => 1,
        'username' => 'admin',
        'name' => 'Admin',
        'nickname' => 'Admin',
        'gender' => 'male',
        'email' => 'admin@gmail.com',
        'password' => 'admin',
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
