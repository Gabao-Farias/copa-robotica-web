<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Escola::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->unique()->company,
        'cidade' => $faker->city
    ];
});

$factory->define(App\Equipe::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->unique()->lastName,
        'path_foto' => null
    ];
});

$factory->define(App\Integrante::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->unique()->name
    ];
});