<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Province;
use Faker\Generator as Faker;

$factory->define(Province::class, function (Faker $faker) {
    return [
        'is_active'=> 'yes',
        'created_by' => 1
    ];
});
