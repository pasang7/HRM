<?php

use App\Models\CompanySetting;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanySetting::create([
            'name'=>'Example Company',
            'website'=>'examplewebsite.com',
            'address'=> 'Kathmandu Nepal',
            'phone'=>'977-1-1234567',
            'email'=>'contact@examplewebsite.com',
            'min_leave_days_for_review'=> '1',
            'normal_overtime_rate'=> '1.5',
            'day_in_month'=>30,
            'month_in_year'=>12,
            'working_hour'=>8
        ]);
    }
}
