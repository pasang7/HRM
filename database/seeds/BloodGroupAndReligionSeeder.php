<?php

use App\Models\BloodGroup;
use App\Models\Religion;
use Illuminate\Database\Seeder;

class BloodGroupAndReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blood_groups = [
            ['id' => 1, 'name' => 'A+','created_by'=> 1],
            ['id' => 2, 'name' => 'A-','created_by'=> 1],
            ['id' => 3, 'name' => 'B+','created_by'=> 1],
            ['id' => 4, 'name' => 'B-','created_by'=> 1],
            ['id' => 5, 'name' => 'O+','created_by'=> 1],
            ['id' => 6, 'name' => 'O-','created_by'=> 1],
            ['id' => 7, 'name' => 'AB+','created_by'=> 1],
            ['id' => 8, 'name' => 'AB-','created_by'=> 1],
        ];

        foreach($blood_groups as $bg){
            BloodGroup::create($bg);
        }

        $religions = [
            ['id' => 1, 'name' => 'Hinduism','created_by'=> 1],
            ['id' => 2, 'name' => 'Buddhism','created_by'=> 1],
            ['id' => 3, 'name' => 'Islam','created_by'=> 1],
            ['id' => 4, 'name' => 'Kirat','created_by'=> 1],
            ['id' => 5, 'name' => 'Christianity','created_by'=> 1],
            ['id' => 6, 'name' => 'Others','created_by'=> 1],
        ];

        foreach($religions as $religion){
            Religion::create($religion);
        }
    }
}
