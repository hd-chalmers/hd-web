<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->paragraph,
        'location' => $faker->address,
        'show_on_frontpage' => $faker->boolean,
        'facebook_event_link' => $faker->url,
        'date' => $faker->dateTimeThisMonth('next month', 'Europe/Stockholm')
    ];
});
