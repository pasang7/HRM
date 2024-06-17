<?php

use Illuminate\Database\Seeder;
use App\Models\IncomeTax;
use App\Models\SsTaxSlab;
use App\Models\TaxSlab;

class IncomeTaxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IncomeTax::create([
            'id'=> 1,
            'name'=>'Unmarried Male',
            'is_married'=>false,
            'gender'=>1
        ]);
        IncomeTax::create([
            'id'=> 2,
            'name'=>'Unmarried Female',
            'is_married'=>false,
            'gender'=>0
        ]);
        IncomeTax::create([
            'id'=> 3,
            'name'=>'Married Male',
            'is_married'=>true,
            'gender'=>1
        ]);
        IncomeTax::create([
            'id'=> 4,
            'name'=>'Married Female',
            'is_married'=>true,
            'gender'=>0
        ]);

        //1% SOCIAL SECURITY
        //unmarried 
        SsTaxSlab::create([
            'id'=>1,
            'income_tax_id'=>1,
            'position'=>'1',
            'amount'=>'400000',
            'percent'=>'1',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        
        SsTaxSlab::create([
            'id'=>2,
            'income_tax_id'=>2,
            'position'=>'1',
            'amount'=>'400000',
            'percent'=>'1',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        //married 
        SsTaxSlab::create([
            'id'=>3,
            'income_tax_id'=>3,
            'position'=>'1',
            'amount'=>'450000',
            'percent'=>'1',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        
        SsTaxSlab::create([
            'id'=>4,
            'income_tax_id'=>4,
            'position'=>'1',
            'amount'=>'450000',
            'percent'=>'1',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);

    //   REM TAX
        TaxSlab::create([
            'id'=>1,
            'income_tax_id'=>1,
            'position'=>'2',
            'amount'=>'100000',
            'percent'=>'10',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        TaxSlab::create([
            'id'=>2,
            'income_tax_id'=>1,
            'position'=>'2',
            'amount'=>'200000',
            'percent'=>'20',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        TaxSlab::create([
            'id'=>3,
            'income_tax_id'=>1,
            'position'=>'2',
            'amount'=>'1300000',
            'percent'=>'30',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        TaxSlab::create([
            'id'=>4,
            'income_tax_id'=>1,
            'position'=>'2',
            'amount'=>'2000000',
            'percent'=>'36',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        
        TaxSlab::create([
            'id'=>5,
            'income_tax_id'=>2,
            'position'=>'2',
            'amount'=>'100000',
            'percent'=>'10',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        TaxSlab::create([
            'id'=>6,
            'income_tax_id'=>2,
            'position'=>'2',
            'amount'=>'200000',
            'percent'=>'20',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        TaxSlab::create([
            'id'=>7,
            'income_tax_id'=>2,
            'position'=>'2',
            'amount'=>'1300000',
            'percent'=>'30',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        TaxSlab::create([
            'id'=>8,
            'income_tax_id'=>2,
            'position'=>'2',
            'amount'=>'2000000',
            'percent'=>'36',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        TaxSlab::create([
            'id'=>9,
            'income_tax_id'=>3,
            'position'=>'2',
            'amount'=>'100000',
            'percent'=>'10',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        TaxSlab::create([
            'id'=>10,
            'income_tax_id'=>3,
            'position'=>'2',
            'amount'=>'200000',
            'percent'=>'20',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        TaxSlab::create([
            'id'=>11,
            'income_tax_id'=>3,
            'position'=>'2',
            'amount'=>'1300000',
            'percent'=>'30',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        TaxSlab::create([
            'id'=>12,
            'income_tax_id'=>3,
            'position'=>'2',
            'amount'=>'2000000',
            'percent'=>'36',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        TaxSlab::create([
            'id'=>13,
            'income_tax_id'=>4,
            'position'=>'2',
            'amount'=>'100000',
            'percent'=>'10',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        TaxSlab::create([
            'id'=>14,
            'income_tax_id'=>4,
            'position'=>'2',
            'amount'=>'200000',
            'percent'=>'20',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        TaxSlab::create([
            'id'=>15,
            'income_tax_id'=>4,
            'position'=>'2',
            'amount'=>'1300000',
            'percent'=>'30',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        TaxSlab::create([
            'id'=>16,
            'income_tax_id'=>4,
            'position'=>'2',
            'amount'=>'2000000',
            'percent'=>'36',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
      
    }
}
