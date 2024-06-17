<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'key'=>'master-pin',
            'value'=>Hash::make(1111)
        ]);
        Setting::create([
            'key'=>'fiscal-year-start',
            'value'=>'07-16'           
        ]);
        Setting::create([
            'key'=>'fiscal-year-end',
            'value'=>'07-15'           
        ]);
        Setting::create([
            'key'=>'company-name',
            'value'=>'HR Software'            
        ]);
    }
}
