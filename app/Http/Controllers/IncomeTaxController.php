<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomeTax;
class IncomeTaxController extends Controller
{
    public function index(){
        $income_taxes=IncomeTax::all();
        return view('income-tax.index')->with('income_taxes',$income_taxes);
    }

    public function edit($id){
        $income_tax=IncomeTax::with('slab')->where('id',$id)->first();
        return view('income-tax.tax-slab')->with('income_tax',$income_tax);
    }
}
