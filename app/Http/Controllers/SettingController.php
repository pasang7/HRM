<?php

namespace App\Http\Controllers;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class SettingController extends Controller
{
    public function index(){
        $company_name=Setting::firstOrCreate(
            ['key' => 'company-name'], ['value' => 'HR']
        )->value;
        $fiscal_year=Setting::firstOrCreate(
            ['key' => 'fiscal-year-start'], ['value' => '06-16']
        )->value;
        return view('setting.index',compact('company_name','fiscal_year'));
    }

    public function changeMasterPin(Request $request){
        $request->validate([
            'pin' => 'required|numeric|between:1000,9999'
        ]);
        $pin = Setting::updateOrCreate(
            ['key' => 'master-pin'],
            ['value' => Hash::make($request->pin)]
        );
        return redirect()->back();
    }
    public function changeCompanyDetails(Request $request){
        $request->validate([
            'name' => 'required'
        ]);
        $name = Setting::updateOrCreate(
            ['key' => 'company-name'],
            ['value' => $request->name]
        );
        return redirect()->back();

    }
    public function changeCompanyFiscalYear(Request $request){
        $request->validate([
            'fiscal_year' => 'required'
        ]);
        $fiscal_start=Carbon::parse($request->fiscal_year);
        $fiscal_end=Carbon::parse($request->fiscal_year)->subtract('1','year')->subtract('1','day');

        $name = Setting::updateOrCreate(
            ['key' => 'fiscal-year-start'],
            ['value' => $fiscal_start->format('m-d')]
        );
        $name = Setting::updateOrCreate(
            ['key' => 'fiscal-year-end'],
            ['value' =>$fiscal_end->format('m-d')]
        );
        return redirect()->back();
    }
}
