<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ConsumedDrink;
use Faker\Generator as Faker;
use App\Drink;

$factory->define(ConsumedDrink::class, function (Faker $faker) {
    return [
        'drink_id' => $faker->randomElement(Drink::all()->pluck('id')->toArray())
    ];
});
