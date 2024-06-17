<?php

use App\Models\EngMonth;
use Illuminate\Database\Seeder;

class EngMonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            ['January','01'],
            ['February','02'],
            ['March','03'],
            ['April','04'],
            ['May','05'],
            ['June','06'],
            ['July','07'],
            ['August','08'],
            ['September','09'],
            ['October','10'],
            ['November','11'],
            ['December','12'],
        ])->each(function($value){
           factory(EngMonth::class, 1)->create([
                'name' => $value[0],
                'value' => $value[1],
           ]);
        });
    }
}
