<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\EmployeeId;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(User::class, function (Faker $faker) {
    return [
        'employee_id' => EmployeeId::create(['employee_id' => (string) $faker->unique()->numberBetween(1000, 9999)])->employee_id,
        'name' => $faker->name,
        'gender' => rand(0, 1),
        'role' => 5, // Default, override in seeder
        'department_id' => 1, // Override in seeder
        'designation' => 5,
        'is_married' => $faker->boolean,
        'province' => rand(1, 7),
        'district' => rand(1, 77),
        'blood_group' => rand(1, 4),
        'religion' => rand(1, 5),
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make('password'),
        'pin' => Hash::make('1111'),
        'dob' => $faker->date(),
        'interview_date' => $faker->date(),
        'joined' => $faker->date(),
    ];
});
