<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'slug' => $faker->word,
        'brief' => $faker->sentence,
        'description' => $faker->sentence,
        'venue' => $faker->city,
        'location' => $faker->address,
        'date' => $faker->date,
        'start_time' => $faker->time,
        'public_price' => $faker->randomDigitNotNull,
        'member_price' => $faker->randomDigitNotNull,
    ];
});
