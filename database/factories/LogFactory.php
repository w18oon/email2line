<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Log;
use Faker\Generator as Faker;

$factory->define(Log::class, function (Faker $faker) {
    return [
        'gmail_message_id' => $faker->uuid,
        'line_notify_flag' => rand(0,1)
    ];
});
