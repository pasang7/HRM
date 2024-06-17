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
            'Fixed',
            'Temporary',
            'Rolling',
            'Probation',
            'Project Based',
            ])->each(function($name){
                factory(ContractType::class, 1)->create([
                    'name' => $name,
                    'slug' => Str::slug($name)
                ]);
            });
    }
}
