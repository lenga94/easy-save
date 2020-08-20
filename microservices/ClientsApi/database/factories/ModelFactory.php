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

$factory->define(App\Transaction::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name($faker->randomElement(['male', 'female'])),
        'email' => $faker->email,
        'address' => $faker->address,
        'dial_code' => $faker->countryCode,
        'phone_number' => $faker->phoneNumber,
        'title' => $faker->sentence(3, true),
        'message' => $faker->sentence(6, true),
        'channel' => $faker->randomElement(['MOBILE APP', 'WEBSITE', 'AGENT PORTAL', 'BROKER PORTAL']),
    ];
});
