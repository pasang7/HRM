<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [

        'designation'=>'Jr xyz',
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'remember_token' => Str::random(10),        
        'employee_id'=>$faker->numberBetween($min = 100000, $max = 999999),
        'department_id'=>1,
        'password'=>Hash::make('password'),
        'dob'=>Carbon::now(),
        'joined'=>Carbon::now()->subtract(1,'years'),
        'pin'=>Hash::make('1111'),
        'gender'=>$faker->numberBetween($min = 0, $max = 1),
        'is_married'=>$faker->numberBetween($min = 0, $max = 1),
        'role'=>11
    ];
});
