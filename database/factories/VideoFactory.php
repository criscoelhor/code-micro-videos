<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Video;
use Faker\Generator as Faker;

$factory->define(Video::class, function (Faker $faker) {
    $rating = Video::RATING_LIST[array_rand(Video::RATING_LIST)];
    return [
        'title' => $faker->colorName,
        'description' => $faker->sentence(10),
        'year_launched' => rand(1930, 2020),
        'opened' => rand(0, 1),
        'rating' => $rating,
        'duration' => rand(20, 120)
    ];
});
