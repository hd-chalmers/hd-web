<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\PurchaseHistory::class, function (Faker $faker) {
    return [
        'sum' => 0,
    ];
});
