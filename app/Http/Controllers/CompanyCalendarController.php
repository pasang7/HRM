<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Holiday;
use App\Models\Leave;
use Auth;
use App\Http\Resources\HolidayResource;
use App\Http\Resources\LeaveResource;
use App\Http\Resources\TravelResource;
use App\Models\Travel;

class CompanyCalendarController extends Controller
{
    public function index(){
    
        return view('company-calendar.index');
    }
    public function getMonthEvent(Request $request){
        $start=Carbon::parse($request->start);
        $end=Carbon::parse($request->end);
        $this_month=$start->add('15','days');
        $holidays=Holiday::whereMonth('start',$this_month->format('n'))
                        ->whereYear('start',$this_month->format('Y'))
                        ->get();
        $events=[];
        $leaves=Leave::whereMonth('from',$this_month->format('n'))
            ->whereYear('from',$this_month->format('Y'))
            ->get();
        $events_leaves=LeaveResource::collection($leaves);
        foreach($events_leaves as $leave){
            $events[]=$leave;
        }
        $events_holidays=HolidayResource::collection($holidays);
        foreach($events_holidays as $holiday){
            $events[]=$holiday;
        }
        $travels=Travel::whereMonth('from',$this_month->format('n'))
            ->whereYear('from',$this_month->format('Y'))
            ->get();
        $events_travels=TravelResource::collection($travels);
        foreach($events_travels as $travel){
            $events[]=$travel;
        }
        return json_encode($events);
    }
}
