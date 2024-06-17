<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

use Session;
class LockedController extends Controller
{
    public function unlock(Request $request){
        $master_pin=Setting::where('key','master-pin')->first();
        if($master_pin){
            if (Hash::check($request->pin, $master_pin->value))
            {
                Session::put('is_locked',false);
                Session::save();
            }else{
                Session::put('is_locked',true);
                Session::save();
            }
            return redirect()->route('welcome');
        }
        dd('sorry no pin');
    }
}
