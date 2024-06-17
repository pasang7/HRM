<?php

use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $province = collect([
            'Province No. 1' => [
                'Bhojpur',
                'Dhankuta',
                'Ilam',
                'Jhapa',
                'Khotang',
                'Morang',
                'Okhaldhunga',
                'Pachthar',
                'Sankhuwasabha',
                'Solukhumbu',
                'Sunsari',
                'Taplejung',
                'Terathum',
                'Udaypur',
            ],
            'Province No. 2' => [
                'Bara',
                'Dhanusa',
                'Mahottari',
                'Parsa',
                'Rautahat',
                'Saptari',
                'Sarlahi',
                'Siraha',
            ],
            'Bagmati Province' => [
                'Bhaktapur',
                'Chitwan',
                'Dhading',
                'Dolka',
                'Kathmandu',
                'Kavrepalanchok',
                'Lalitpur',
                'Makwanpur',
                'Nuwakot',
                'Ramechap',
                'Rasuwa',
                'Sindhuli',
                'Sindhupalchowk',
            ],
            'Gandaki Province' => [
                'Baglung',
                'Gorkha',
                'Kaski',
                'Lamjung',
                'Manag',
                'Mustang',
                'Myagdi',
                'Nawalpur',
                'Parbat',
                'Syangja',
                'Tanahu',
            ],
            'Lumbini Province' => [
            'Arghakhachi',
            'Banke',
            'Bardiya',
            'Dang',
            'Eastern Rukum',
            'Gulmi',
            'Kapilvastu',
            'Palpa',
            'Parasi',
            'Pyuthan',
            'Rolpa',
            'Rubandehi'
            ],
            'Karnali Province' =>[
                'Dolpa',
                'Humla',
                'Jajarkot',
                'Jumla',
                'Kalikot',
                'Mugu',
                'Salyan',
                'Surkhet',
                'Western Rukum',
            ],
            'Sudurpaschim Province' => [
                'Aacham',
                'Baitadi',
                'Bajhang',
                'Bajura',
                'Dadeldhura',
                'Darchula',
                'Doti',
                'Kailali',
                'Kanchanpur',
            ],
        ])->each(function($districts, $name){
           $province = factory(Province::class, 1)->create([
                'name' => $name,
                'slug' => Str::slug($name),
            ])->each(function($province) use($districts){
                collect($districts)->each(function($districtName) use($province){
                   District::create([
                       'province_id' => $province->id,
                        'name' => $districtName,
                        'slug' => Str::slug($districtName)
                   ]);
                });

            });
        });
    }
}
