<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\System::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(5),
        'name' => $faker->city,
    ];
});
