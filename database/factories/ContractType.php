<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\ContractType;
use Faker\Generator as Faker;

$factory->define(ContractType::class, function (Faker $faker) {
    return [
        'is_active'=>'yes',
        'created_by'=>1,
        'created_at'=>now(),
        'updated_at'=>now()
    ];
});
