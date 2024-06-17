<?php

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LeaveType::create([
            'name'=>'Annual Leave',
            'days'=>'15'
        ]);
        LeaveType::create([
            'name'=>'Sick Leave',
            'days'=>'6'
        ]);
    }
}
