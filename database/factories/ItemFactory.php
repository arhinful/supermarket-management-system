<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'purchase_price' => $faker->randomFloat(2, 1, 3),
        'selling_price' => $faker->randomFloat(2, 1, 3),
        'store_box' => $faker->text(5),
        'quantity' => $faker->randomNumber(),
    ];
});
