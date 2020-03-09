<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Game::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'min_players' => $faker->numberBetween(1, 5),
        'max_players' => $faker->numberBetween(5, 10),
        'published_year' => $faker->year,
        'min_playtime' => $faker->numberBetween(30, 180),
        'max_playtime' => $faker->numberBetween(180, 360),
    ];
});
