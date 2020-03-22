<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Grimzy\LaravelMysqlSpatial\Types\Point;
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

$factory->define(\App\Models\User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(\App\Models\Company::class, function (\Faker\Generator $faker) {

    static $reduce = 999;

    return [
        'name' => $faker->company,
        'created_at' => \Carbon\Carbon::now()->subSeconds($reduce--),
    ];
});

$factory->define(App\Models\Station::class, function (\Faker\Generator $faker) {
    static $reduce = 999;
    return [
        'name' => $faker->streetName,
        'created_at' => \Carbon\Carbon::now()->subSeconds($reduce--),
        'location' => new Point(
            $faker->randomFloat(6, 35.170106, 35.655129),
            $faker->randomFloat(6, 51.116461, 51.389839)
        ),
    ];
});

$factory->state(App\Models\Station::class, 'with-company',  function (\Faker\Generator $faker) {

    return [
        'name' => $faker->streetName,
        'created_at' => \Carbon\Carbon::now(),
        'location' => new Point(
            $faker->randomFloat(6, 35.170106, 35.655129),
            $faker->randomFloat(6, 51.116461, 51.389839)
        ),
        'company_id' => factory(\App\Models\Company::class)->create()->id,
    ];
});
