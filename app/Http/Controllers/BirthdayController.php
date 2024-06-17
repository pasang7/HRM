<?php

namespace App\Http\Controllers;
use DateTime;
use DateInterval;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BirthdayController extends Controller
{
    public function index(){
        $birthday=array();
        $users = User::where('department_id','!=',1)
                        ->where('is_deleted',0)
                        ->get();
        $date = new DateTime();

        foreach($users as $user){

            $dob= $user->dob->format('m-d');
            $dob_m =$user->dob->format('m');

            if($dob==date('m-d')){
                $birthday['today'][]=$user;
            }
            if($dob>date('m-d') && $dob <= Carbon::now()->endOfWeek()->format('m-d')){
                $birthday['this_week'][]=$user;
            }
            if($dob_m==date('m') && $dob > date('m-d') ){
                $birthday['this_month'][]=$user;
            }
        }
        return view('birthday.index')->with('birthday',$birthday);
    }
}
