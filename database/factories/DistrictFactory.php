<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\District;
use Faker\Generator as Faker;

$factory->define(District::class, function (Faker $faker) {
    return [
        'is_active' => 'yes', 
        'created_by'=> 1
    ];
});
