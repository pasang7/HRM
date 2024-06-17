<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function download($name){
        return response()->download(storage_path('app/public/files/' . $name));
    }
     
    public function districtByProvince(Request $request){
       $province = Province::with('districts')->where('id',$request->get('province_id'))->first();
       $result_district='';
       $result_district .='<label for="district" class="required">District</label>';
       $result_district.='<select class="form-control custom-form-control" name="district" required>';
       $result_district.='<option value="">Choose District</option>';
       foreach($province->districts as $district){
        $result_district.='<option value="'.$district->id.'">'.$district->name.'</option>';
       }
       $result_district.='</select>';
       
       return $result_district;
    }  
    public function tempdistrictByProvince(Request $request){
       $province = Province::with('districts')->where('id',$request->get('province_id'))->first();
       $result_district='';
       $result_district .='<label for="district" class="required">District</label>';
       $result_district.='<select class="form-control custom-form-control" name="temp_district" required>';
       $result_district.='<option value="">Choose District</option>';
       foreach($province->districts as $district){
        $result_district.='<option value="'.$district->id.'">'.$district->name.'</option>';
       }
       $result_district.='</select>';
       
       return $result_district;
    }
}
