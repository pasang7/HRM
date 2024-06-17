<?php

use App\Models\EmployeeId;
use App\Models\Gender;
use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmployeeId::create([
            'employee_id' => '0'
        ]);
        Gender::create([
            'name'=>'Male',
            'value'=>true
        ]);
        Gender::create([
            'name'=>'Female',
            'value'=>false
        ]);

        User::create([
            'employee_id'=>'0',
            'name'=>'Admin',
            'gender'=>1,
            'role'=>1,
            'department_id'=>1,
            'designation'=>1,
            'is_married'=>false,
            'province'=>3,
            'district'=>27,
            'blood_group'=>1,
            'religion'=>1,
            'email'=>'admin@hr.com',
            'password'=>Hash::make('password'),
            'pin'=>Hash::make('1111'),
            'dob'=>Carbon::now(),
            'interview_date'=>Carbon::now()->subtract(1,'years'),
            'joined'=>Carbon::now()->subtract(1,'years'),
        ]);
     
        // factory(User::class, 10)->create();

    }
}
