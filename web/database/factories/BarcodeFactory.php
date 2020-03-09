<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Barcode::class, function (Faker $faker) {
    return [
        'barcode' => $faker->ean8,
    ];
});
