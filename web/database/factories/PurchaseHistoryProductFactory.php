<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\PurchaseHistoryProduct::class, function (Faker $faker) {
    return [
        'price' => $faker->randomNumber(2),
        'name' => $faker->userName,
    ];
});
