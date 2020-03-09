<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Product::class, function (Faker $faker) {
    $purchase_price = $faker->randomNumber(4);
    $discount = $faker->randomElement([0, 0, 0, 0, $faker->randomNumber(3)]);
    $price = ceil((($purchase_price-$discount)*1.25)/100)*100;
    return [
        'name' => $faker->userName,
        'purchase_price' => $purchase_price,
        'discount' => $discount,
        'price' => $price,
    ];
});
