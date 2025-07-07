<?php

use App\Models\ContractType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContractTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            'Full Time',
            'Part Time',
            'Casual',
            'Contract or Project Based',
            ])->each(function($name){
                factory(ContractType::class, 1)->create([
                    'name' => $name,
                    'slug' => Str::slug($name)
                ]);
            });
    }
}
