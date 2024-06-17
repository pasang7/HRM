<?php

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Shift;
use Illuminate\Support\Str;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'name'=>'Default',
            'status'=>true,
            'is_default'=>true
        ]);
        $departments = collect([
            'Top Level Management',
            'Software Development',
            'Graphic Designs',
            'Sales & Marketing',
            'Admin & Finance',
            ])->each(function($depts, $name){
                $departments = factory(Department::class, 1)->create([
                    'name' => $depts,
                    'slug' => Str::slug($depts)
                 ])->each(function($departments) use ($depts){
                collect($depts)->each(function($department) use($departments){
                    Shift::create([
                        'department_id' => $departments->id,
                        'clockin' => '10:00',
                        'clockout' => '17:00',
                        'status' => '0',
                        'created_by' => '1',
                    ]);
                 });

             });
            });

        Designation::create([
            'name'=>'SuperAdmin',
            'slug'=>'superadmin',
            'is_active'=>'yes',
            'created_by'=>1,
            'is_default'=>true
        ]);
       collect([
            'CEO',
            'COO',
            'Full Stack Developer',
            'Web Developer',
            'Sr. Graphic Designer',
            'Graphic Designer',
            'Content Creator',
            'Marketing Executive',
            'Office Support',
            'Office Driver',
            ])->each(function($name){
                factory(Designation::class, 1)->create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                ]);
            });
    }
}
