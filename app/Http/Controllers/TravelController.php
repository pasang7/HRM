<?php

namespace App\Http\Controllers;

use App\Mail\TravelRequestApprove;
use App\Mail\TravelRequest;
use App\Mail\TravelRequestReject;
use App\Models\Attendance;
use App\Models\Designation;
use App\Models\Travel;
use App\Models\User;
use App\Notifications\Travel\TravelApproveNotification;
use App\Notifications\Travel\TravelRejectNotification;
use App\Notifications\Travel\TravelRequestNotification;
use App\Notifications\Travel\TravelReviewNotification;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use PDF;

class TravelController extends Controller
{
    protected $imageController;
    function __construct(ImageController $imageController)
    {
        $this->imageController=$imageController;
    }
    public function index()
    {
        // $data['travel_requests'] = Travel::orderBy('created_at', 'desc')->where('is_reviewed', 1)
        //     ->when(Auth::user()->userRole->id != 2 && Auth::user()->userRole->id != 3, function($query){
        //        $query->whereHas('user.department', function($query){
        //             $query->where('id', Auth::user()->department->id);
        //         });
        //     })
        //     ->get();
        if(Auth::user()->role == 5){
        $data['travel_histories'] = Travel::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
            return view('travel.history')->with($data);
        }
        else{
        $data['travel_requests'] = Travel::orderBy('created_at', 'desc')->get();
        return view('travel.index')->with($data);
        }

    }
    public function reviewRequest(Request $request)
    {
        if (Auth::user()->id == 3) {
            $data['travel_requests'] = Travel::orderBy('created_at', 'desc')->where('is_reviewed', 0)->get();
        } else {
            $data['travel_requests'] = Travel::orderBy('created_at', 'desc')
                ->whereHas('user.department', function($query){
                    $query->where('id', Auth::user()->department->id);
        }       )->get();
        }
        
        
        return view('travel.review')->with($data);
    }
    public function create()
    {
        $data['user']=$user = User::where('id', auth()->user()->id)->first();
        $data['designation'] = Designation::where('id', $user->designation)->first()->name;
        return view('travel.create')->with($data);
    }
    public function store(Request $request)
    {
         //validation
        Validator::make($request->all(), [
            'user_id' => 'required',
            'shift_id' => 'required',
            'program_name' => 'required',
            'from' => 'required',
            'to' => 'required',
            'place' => 'required',
            'purpose' => 'required',
            'travel_plan' => 'required|mimes:pdf|max:50000',
            'accommodation_day' => 'bail|required|numeric',
            'accommodation_per_diem' => 'bail|required|numeric',
            'accommodation_total' => 'numeric',
            'daily_allowance_day' => 'bail|required|numeric',
            'daily_allowance_per_diem' => 'bail|required|numeric',
            'daily_allowance_total' => 'bail|required|numeric',
            'contingency_day' => 'bail|required|numeric',
            'contingency_per_diem' => 'bail|required|numeric',
            'contingency_total' => 'bail|required|numeric',
            'advance_taken' => 'bail|required|numeric',
        ]);

            $start=Carbon::parse($request->from);
            $end=Carbon::parse($request->to);

            if ($end <= $start) {
                toastr()->error('End date should be greater than Start date', 'Oops !!!');
                return redirect()->route('travel.create');

            }else{


            $user=User::where('id',$request->user_id)->first();
            $ceos = User::where('is_head', 'yes')->where('role', '2')->get();
            $line_managers = User::where('is_head', 'yes')->where('role', '4')->where('department_id', $user->department_id)->get();
            $travelPlan=$this->imageController->saveAnyFile($request,'Travel','travel_plan');
            $data['user_id']=$user->id;

            $all_travels=Travel::where('user_id',$user->id)
            ->whereDate('from','>=',$start)
            ->get();
            $dates=[];
            $requested_dates=[];
            foreach($all_travels as $travel){
                $period = CarbonPeriod::create($travel->from, $travel->to);
                foreach($period as $date){
                    if(!in_array($date->format('Y-m-d'),$dates)){
                        $dates[]=$date->format('Y-m-d');
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
                $res['text']='The selected day is already on request';
            }else{
                $data['from']=$start;
                $data['to']=$end;
                $data['shift_id']=$request->shift_id;
                $data['program_name']=$request->program_name;
                $data['place']=$request->place;
                $data['purpose']=$request->purpose;
                if($request->get('travel_mode')){
                    $data['travel_mode']=implode(',', $request->get('travel_mode'));
                }
                $data['other_travel_mode']=$request->other_travel_mode;
                $data['justification']=$request->justification;
                $data['accommodation_day']=$request->accommodation_day;
                $data['accommodation_per_diem']=$request->accommodation_per_diem;
                $data['accommodation_total']=$request->accommodation_total;
                $data['daily_allowance_day']=$request->daily_allowance_day;
                $data['daily_allowance_per_diem']=$request->daily_allowance_per_diem;
                $data['daily_allowance_total']=$request->daily_allowance_total;
                $data['contingency_day']=$request->contingency_day;
                $data['contingency_per_diem']=$request->contingency_per_diem;
                $data['contingency_total']=$request->contingency_total;
                $data['remarks']=$request->remarks;
                $data['advance_taken']=$request->advance_taken;
                $data['travel_plan']=$travelPlan;
                $data['submitted_by']=$user->id;
                $data['submitted_date']=now()->format('Y-m-d');
                $data['submitted_name'] = $user->name;
                $data['submitted_dept'] = $user->department->name;

                $pdf = PDF::loadView('mail.travel.travel_plan', $data);

                if($user->is_head == 'yes' && $user->role ==4){
                $data['is_reviewed']=true;
                $data['recommended_by']=Auth::user()->id;
                $data['recommended_date']=now()->format('Y-m-d');
                $data['is_read']='yes';

                foreach($ceos as $ceo){
                    $ceo->notify(new TravelRequestNotification($ceo, $user));
                    Mail::to($ceo->email)->send(new TravelRequest($user, route('travel.index')));
                     // $data["email"]= $ceo->email;
                //     Mail::send('mail.travel.travel_plan', $data, function($message)use($data, $pdf) {
                //     $message->to($data["email"])
                //             ->attachData($pdf->output(), "TravelRequest.pdf");
                // });
                }
                }else{
                    $data['is_reviewed']=false;
                    $data['is_read']='no';
                    foreach($line_managers as $line_manager){
                    $line_manager->notify(new TravelRequestNotification($line_manager, $user));
                    Mail::to($line_manager->email)->send(new  TravelRequest($user, route('travel.index')));
                    }
                }
                if(Travel::create($data)){
                    toastr()->success('The request submitted successfully.', 'Success !!!');
                    return redirect()->route('travel.create');
                }else{
                    toastr()->error('Error on sending request.', 'Oops !!!');
                    return redirect()->route('travel.create');
                }
            }
        }

    }
    public function rejectTravel(Request $request){
        $res['status']=false;
        $res['title']='';
        $res['text']='';
        $res['reload']=true;

        $validator = Validator::make($request->all(), [
            'travel_id' => 'required|numeric|exists:travel,id'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['title']=$errors->first();
            $res['text']=$errors->first();
        }else{
            $travel=Travel::find($request->travel_id);
            if($travel->is_rejected){
                $res['title']='Oops';
                $res['text']='The travel request has already been rejected';
            }else{
                $travel->is_rejected=true;
                $travel->approved_by=Auth::user()->id;
                $travel->approved_date=now()->format('Y-m-d');
                $travel->user->notify(new TravelRejectNotification($travel->user, Auth::user()));
                Mail::to($travel->user->email)->send(new  TravelRequestReject($travel->user, route('travel.index')));
                $travel->update();
                $res['title']='Success';
                $res['text']='The travel request has been rejected';
                $res['status']=true;
                $res['reload']=true;
            }
        }
        return json_encode($res);
    }
    public function recommendTravel(Request $request){
        $travel = Travel::find($request->travel_id);
        if(!empty($travel)){
            if($travel->is_rejected){
                toastr()->error('The travel request has already been rejected', 'Oops !!!');
                return redirect()->route('travel.create');
            }elseif($travel->is_accepted){
                toastr()->error('The travel request has already been accepted', 'Oops !!!');
                return redirect()->route('travel.create');
            }else{
                $travel->is_reviewed=true;
                $travel->recommended_remarks=$request->get('recommended_remarks');
                $travel->recommended_by=Auth::user()->id;
                $travel->recommended_date=now()->format('Y-m-d');
                $travel->is_read='yes';
                $travel->update();
                $travel->user->notify(new TravelReviewNotification($travel->user, Auth::user()));
                $ceos = User::where('role', 2)->where('is_head', 'yes')->where('is_deleted', false)->get();
                foreach($ceos as $ceo){
                $ceo->notify(new TravelReviewNotification($ceo, Auth::user()));
                }
                toastr()->success('The travel request has been recommended', 'Success !!!');
                return redirect()->route('travel.review');
            }
        }
    }
    public function approveTravel(Request $request){
        $travel = Travel::find($request->travel_id);
        $user = User::where('id', $travel->user->id)->first();
        if(!empty($travel)){
            if($travel->is_rejected){
                toastr()->error('The travel request has already been rejected', 'Oops !!!');
                return redirect()->route('travel.create');
            }elseif($travel->is_accepted){
                toastr()->error('The travel request has already been accepted', 'Oops !!!');
                return redirect()->route('travel.create');
            }else{
                $start=Carbon::parse($travel->from);
                $end=Carbon::parse($travel->to);
                while (strtotime($start) <= strtotime($end)) {
                    $prev_travel = Attendance::where('user_id',$travel->user->id)
                                    ->where('date',date ("Y-m-d", strtotime($start)))
                                    ->first();
                    if(!$prev_travel){
                        if( $request->x[date ("Y/m/d", strtotime($start))] ==1){
                            $dates[]=date ("Y-m-d", strtotime($start));
                            $attendance = new Attendance();
                            $attendance->user_id = $travel->user->id;
                            $attendance->shift_id = $travel->shift_id;
                            $attendance->date = date ("Y-m-d", strtotime($start));
                            $attendance->remarks = $travel->purpose;
                            $attendance->clockin = $travel->shift->clockin;
                            $attendance->clockout = $travel->shift->clockout;
                            $attendance->is_travel = true;
                            $attendance->is_paid = true;
                            $attendance->save();
                        }elseif($request->x[date ("Y/m/d", strtotime($start))] ==2){

                        }
                    }
                    $start = date ("Y-m-d", strtotime("+1 day", strtotime($start)));
                    $start = Carbon::parse($start);
                    $travel->is_accepted=true;
                    $travel->accepted_remarks=$request->get('accepted_remarks');
                    $travel->approved_by=Auth::user()->id;
                    $travel->approved_date=now()->format('Y-m-d');
                    $travel->update();
                }
                $user->notify(new TravelApproveNotification($user, Auth::user()));
                $line_managers = User::where('department_id', $user->department_id)->where('role', 4)->where('is_head', 'yes')->get();
                foreach($line_managers as $line_manager){
                    $line_manager->notify(new TravelApproveNotification($line_manager, Auth::user()));
                        // Mail::to($line_manager->email)->send(new  TravelRequest($user, route('travel.index')));
                    }
                // Mail::to($user->email)->send(new  TravelRequestApprove($user, route('travel.index')));
                toastr()->success('The travel request has been approved', 'Success !!!');
                return redirect()->route('travel.index');
            }
        }
    }
}
