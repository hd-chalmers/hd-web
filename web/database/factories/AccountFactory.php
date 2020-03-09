<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Account;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'uid'=>$faker->uuid,
        'name' => $faker->firstName(),
        'password' => '',
        'balance' => $faker->randomNumber(4),
        'active' => $faker->boolean(70)
    ];
});
