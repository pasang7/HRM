<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Designation;
use Faker\Generator as Faker;

$factory->define(Designation::class, function (Faker $faker) {
    return [
        'is_active'=>'yes',
        'created_by'=>1,
        'is_default'=>false
    ];
});
