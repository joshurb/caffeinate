<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Drink;
use Faker\Generator as Faker;

$factory->define(Drink::class, function (Faker $faker) {
    return [
        'drink_name' => $faker->company,
        'drink_description' => $faker->catchPhrase,
        'servings' => $faker->randomElement([1,2]),
        'caffeine_amount' => $faker->randomElement([25,50,250]),
        'image_url' => $faker->imageUrl($width = 640, $height = 480, 'cats'),
    ];
});
