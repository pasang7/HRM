<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { Role::create([
        'id' => 1,
        'name'=>'SuperAdmin',
        'slug'=>'superadmin',
        'is_active'=>'yes',
        'is_default'=>1
    ]);
    Role::create([
        'id' => 2,
        'name'=>'CEO',
        'slug'=>'ceo',
        'is_active'=>'yes'
    ]);
    Role::create([
        'id' => 3,
        'name'=>'HR',
        'slug'=>'hr',
        'is_active'=>'yes'
    ]);
    Role::create([
        'id' => 4,
        'name'=>'Line Manager',
        'slug'=>'line-manager',
        'is_active'=>'yes'
    ]);
    Role::create([
        'id' => 5,
        'name'=>'Staff',
        'slug'=>'staff',
        'is_active'=>'yes'
    ]);
    Role::create([
        'id' => 6,
        'name'=>'Intern',
        'slug'=>'intern',
        'is_active'=>'no'
    ]);
    }
}
