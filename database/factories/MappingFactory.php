<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Mapping;
use Faker\Generator as Faker;

$factory->define(Mapping::class, function (Faker $faker) {
    return [
        'subject' => $faker->unique()->word,
    ];
});
