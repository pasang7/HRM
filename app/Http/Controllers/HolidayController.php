<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Models\Holiday;
use Auth;
class HolidayController extends Controller
{
    public function store(Request $request){
        $res['status']=false;
        $res['title']='';
        $res['text']='';
        $res['redirect']=false;
        $res['redirect_url']='';

        //Validation
        $validator = Validator::make($request->all(), [
            'start' => 'required|date',
            'end' => 'required|date',
            'name' => 'required',

        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();            
            $res['title']=$errors->first();
            $res['text']=$errors->first();
        }else{
            $start=Carbon::parse($request->start);
            $end=Carbon::parse($request->end);
            $data['created_by']=Auth::user()->id;
            $data['name']=$request->name;

            if($start==$end){ //Oneday
                //Isalready Holiday
                $already_single_day_holiday=Holiday::whereDate('start','<=',$start)
                                                    ->whereDate('end','>=',$start)
                                                    ->first();

                if($already_single_day_holiday){
                    $res['title']='Oops';
                    $res['text']='The selected day is  already a holiday';
                }else{
                    $data['start']=$start;
                    $data['end']=$start;
                    Holiday::create($data);

                    $res['status']=true;
                    $res['redirect']=true;
                    $res['redirect_url']=route('company-calendar.index');

                }

            }else{ //Multiple
                $all_holidays=Holiday::whereDate('start','>=',$start)->get();
                $dates=[];
                $requested_dates=[];
                foreach($all_holidays as $holiday){
                    if($holiday->is_multiple){
                        $period = CarbonPeriod::create($holiday->start, $holiday->end);
                        foreach($period as $date){
                            if(!in_array($date->format('Y-m-d'),$dates)){
                                $dates[]=$date->format('Y-m-d');
                            }
                        }
                    }else{
                        if(!in_array($holiday->start->format('Y-m-d'),$dates)){
                            $dates[]=$holiday->start->format('Y-m-d');
                        }

                    }
                }

                $requested_period = CarbonPeriod::create($start, $end);
                foreach($requested_period as $date){
                    $requested_dates[]=$date->format('Y-m-d');
                }



                $common = array_intersect($dates, $requested_dates);
                if (count($common) > 0) {
                    $res['title']='Oops';
                    $res['text']='The selected day is  already a holiday';
                }else{
                    $data['start']=$start;
                    $data['end']=$end;
                    Holiday::create($data);
                    $res['status']=true;
                    $res['redirect']=true;
                    $res['redirect_url']=route('company-calendar.index');
                }

            }
        }

        return json_encode($res);
    }
}
