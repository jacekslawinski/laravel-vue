<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Hardware::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(5),
        'name' => $faker->company,
        'serial_number' => $faker->uuid,
        'production_month' => '2011-02',
        'system_id' => 1
    ];
});
