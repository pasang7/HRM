<?php

namespace App\Http\Controllers;

use App\Mail\LeaveApprove;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveRequest;
use App\Mail\LeaveRequestApprove;
use App\Mail\LeaveRequestReject;
use Illuminate\Http\Request;
use App\Models\LeaveType;
use App\Models\UserLeaveType;

use App\Models\Leave;
use App\Models\User;

use App\Models\AcceptedLeave;
use App\Models\Attendance;
use App\Models\CompanySetting;
use App\Models\Setting;
use App\Models\UserHoliday;
use App\Notifications\Leave\LeaveApproveNotification;
use App\Notifications\Leave\LeaveRejectNotification;
use App\Notifications\Leave\LeaveRequestNotification;
use App\Notifications\Leave\LeaveReviewNotification;
use Validator;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    public function index(){
        $data['setting'] = CompanySetting::where('id', 1)->first();
        $data['leave_requests'] = Leave::where('user_id','!=', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('leave.index')->with($data);
    }
    public function create(){
        $data['user'] = Auth::user();
        return view('leave.create', $data);
    }
    public function request(){
        return view('leave.create-guest');
    }
    public function store(Request $request){
        //Validation
        $validator = Validator::make($request->all(), [
            'user_id'=>'required',
            'start' => 'required|date',
            'end' => 'required|date',
            'leave_type' => 'required',
            'leave_type_full'=>'required',
            'description' => 'required',
            'shift_id'=>'required'
        ]);
        if ($validator->fails()){
            return redirect()->back();
        }else{
            $start=Carbon::parse($request->start);
            $end=Carbon::parse($request->end);
            if($end < $start) {
                toastr()->error('End date should be greater than Start date', 'Oops !!!');
                return redirect()->route('leave.create');
            }else{
            $user=User::where('id',$request->user_id)->first();
            $data['user_id']=$user->id;
            $data['description'] = $reason=$request->description;
            $ceos = User::where('is_head', 'yes')->where('role', '2')->get();
            $line_managers = User::where('department_id', $user->department_id)->where('role', 4)->where('is_head', 'yes')->get();
            $first_approval = User::where('id', $user->first_approval_id)->first();
            if($start==$end){
                //IsAlready Holiday
                $already_leave=Leave::where('user_id',$user->id)
                                    ->whereDate('from','<=',$start)
                                    ->whereDate('to','>=',$start)
                                    ->first();
                if($already_leave){
                    toastr()->success('The selected day is already a leave', 'Success !!!');
                    return redirect()->back();
                }else{
                    $data['from']=$start;
                    $data['to']=$start;
                    $data['shift_id']=$request->shift_id;
                    $data['leave_type_id']=$request->leave_type;
                    $data['leave_type_full']=$request->leave_type_full;
                    $leave_type = $request->leave_type_full==0?'half':'full';
                    $data['is_reviewed']=false;
                    $data['is_read']='no';
                    $first_approval->notify(new LeaveRequestNotification($first_approval, $user));
                    Mail::to($first_approval->email)->send(new LeaveRequest($user,$start,$end,$reason,$leave_type));
                    foreach($ceos as $ceo){
                        Mail::to($ceo->email)->send(new LeaveRequest($user,$start,$end,$reason,$leave_type));
                    }
                    Leave::create($data);
                }
            }else{
                if ($request->leave_type_full == 0) {
                    toastr()->error('Half leave is not allowed for multiple days!', 'Oops !!!');
                    return redirect()->route('leave.create');
                }
                $all_leaves=Leave::where('user_id',$user->id)->whereDate('from','>=',$start)->get();
                $dates=[];
                $requested_dates=[];
                foreach($all_leaves as $leave){
                    $period = CarbonPeriod::create($leave->from, $leave->to);
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
                    $res['text']='The selected day is  already a holiday';
                }else{
                    $data['shift_id']=$request->shift_id;
                    $data['leave_type_id']=$request->leave_type;
                    $data['leave_type_full']=$request->leave_type_full;
                    $leave_type = 'full';
                    $data['from']=$start;
                    $data['to']=$end;
                    $data['is_reviewed']=false;
                    $data['is_read']='no';
                    $first_approval->notify(new LeaveRequestNotification($first_approval, $user));
                    Mail::to($first_approval->email)->send(new LeaveRequest($user,$start,$end,$reason,$leave_type));
                    foreach($ceos as $ceo){
                        Mail::to($ceo->email)->send(new LeaveRequest($user,$start,$end,$reason,$leave_type));
                    }
                    Leave::create($data);
                    }
                }
            }
        }
        toastr()->success('Your leave has been submitted.', 'Success !!!');
        return redirect()->back();
    }
    public function reviewLeave(Request $request){
        $leave = Leave::find($request->leave_id);
        if(!empty($leave)){
            if($leave->is_rejected){
                toastr()->error('The leave request has already been rejected', 'Oops !!!');
                return redirect()->route('leave.create');
            }elseif($leave->is_accepted){
                toastr()->error('The leave request has already been accepted', 'Oops !!!');
                return redirect()->route('leave.create');
            }else{
                $leave->is_reviewed=true;
                $leave->reviewed_by=Auth::user()->id;
                $leave->reviewed_date=now()->format('Y-m-d');
                $leave->update();
                $ceos = User::where('role', 2)->where('is_head', 'yes')->where('is_deleted', false)->get();
                foreach($ceos as $ceo){
                $ceo->notify(new LeaveReviewNotification($ceo, Auth::user()));
                }
                toastr()->success('The leave request has been reviewed', 'Success !!!');
                return redirect()->route('leave.index');
            }
        }
    }
    public function rejectLeave(Request $request){
        $res['status']=false;
        $res['title']='';
        $res['text']='';
        $res['reload']=true;
        $validator = Validator::make($request->all(), [
            'leave_id' => 'required|numeric|exists:leaves,id'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['title']=$errors->first();
            $res['text']=$errors->first();
        }else{
            $leave=Leave::find($request->leave_id);
            if($leave->is_rejected){
                $res['title']='Oops';
                $res['text']='The leave has already been rejected';
            }elseif($leave->is_accepted){
                $res['title']='Oops';
                $res['text']='The leave has already been accepted';
            }else{
                if($leave->reviewed_by && $leave->reviewed_date){
                    $leave->approved_by=Auth::user()->id;
                    $leave->approved_date=now()->format('Y-m-d');
                    $leave->is_rejected=true;
                }
                else{
                    $leave->reviewed_by=Auth::user()->id;
                    $leave->reviewed_date=now()->format('Y-m-d');
                    $leave->is_reviewed=true;
                    $leave->approved_by=Auth::user()->id;
                    $leave->approved_date=now()->format('Y-m-d');
                    $leave->is_rejected=true;
                }
                $leave->update();
                $this->rejectedLeaveMail($leave);
                $res['title']='Success';
                $res['text']='The leave has been rejected';
                $res['status']=true;
                $res['reload']=true;
            }
        }
        return json_encode($res);
    }
    public function unpaidAcceptLeave(Request $request){
        $res['status']=false;
        $res['title']='';
        $res['text']='';
        $res['reload']=true;

        $validator = Validator::make($request->all(), [
            'leave_id' => 'required|numeric|exists:leaves,id'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['title']=$errors->first();
            $res['text']=$errors->first();
        }else{
            $leave=Leave::find($request->leave_id);
            if($leave->is_rejected){
                $res['title']='Oops';
                $res['text']='The leave has already been rejected';
            }elseif($leave->is_accepted){
                $res['title']='Oops';
                $res['text']='The leave has already been accepted';
            }else{
                $start=Carbon::parse($leave->from);
                $end=Carbon::parse($leave->to);
                $data['leave_type_id']=$leave->type->id;
                $data['leave_id']=$leave->id;
                $data['user_id']=$leave->user->id;
                $data['accepted_by']=Auth::user()->id;
                $data['is_paid']=false;

                $u=$leave->user;
                $dh=$u->department->holidays;
                foreach($dh as $row){
                    $days[]=$row->day;
                }
                while (strtotime($start) <= strtotime($end)) {
                    $day = $start->format('w');
                        if(!empty($days))
                        {
                            if(!in_array($day, $days))
                            {
                                $prev_leave = Attendance::where('user_id',$leave->user->id)
                                                            ->where('date',date ("Y-m-d", strtotime($start)))
                                                            ->where('is_leave',1)
                                                            ->first();
                                if(!$prev_leave){

                                    $dates[]=date ("Y-m-d", strtotime($start));
                                    $attendance = new Attendance();
                                    $attendance->user_id = $leave->user->id;
                                    $attendance->shift_id = $leave->shift_id;
                                    $attendance->date = date ("Y-m-d", strtotime($start));
                                    $attendance->remarks = $leave->description;
                                    $attendance->is_leave = 1;
                                    $attendance->leave_type_id = $leave->type->id;
                                    $attendance->leave_day = 1;
                                    $attendance->leave_id= $leave->id;
                                    $attendance->is_paid = false;
                                    $attendance->save();
                                    $data['date']=date ("Y-m-d", strtotime($start));
                                    AcceptedLeave::create($data);
                                }
                            }
                        }
                        $start = date ("Y-m-d", strtotime("+1 day", strtotime($start)));
                        $start = Carbon::parse($start);
                }
                if($leave->reviewed_by && $leave->reviewed_date){
                    $leave->approved_by=Auth::user()->id;
                    $leave->approved_date=now()->format('Y-m-d');
                    $leave->is_accepted=true;
                }else{
                    $leave->reviewed_by=Auth::user()->id;
                    $leave->reviewed_date=now()->format('Y-m-d');
                    $leave->is_reviewed=true;
                    $leave->approved_by=Auth::user()->id;
                    $leave->approved_date=now()->format('Y-m-d');
                    $leave->is_accepted=true;
                }
                $leave->update();
                $this->leaveMailNotification($leave);
                $res['title']='Success';
                $res['text']='The leave has been accepted';
                $res['status']=true;
                $res['reload']=true;
            }
        }
        return json_encode($res);
    }
    public function getLeaveForm(Request $request){
        $res['status']=false;
        $res['title']='';
        $res['text']='';
        //Validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['title']=$errors->first();
        }else{
            $user=User::with('leave_types')
                        ->where('id',$request->user_id)
                        ->first();
            $res['status']=true;
            $res['view']= view('leave.component.leave-request-form',compact('user'))->render();

        }
        return json_encode($res);
    }
    public function getLeaveFormGuest(Request $request){
        $res['status']=false;
        $res['title']='';
        $res['text']='';
        //Validation
        $validator = Validator::make($request->all(), [

        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['title']=$errors->first();
        }else{
            $res['status']=true;
            $res['view']= view('leave.component.leave-request-form-guest')->render();

        }
        return json_encode($res);
    }
    public function checkUser(Request $request){
        $res['status']=false;
        $res['title']='';
        $res['text']='';
        //Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['title']=$errors->first();
        }else{
            $user=User::where('email',$request->email)->first();
            $res['status']=true;
            $res['view']= view('leave.component.leave-request-form-guest-2',compact('user'))->render();

        }
        return json_encode($res);
    }
//new

    public function paidAcceptLeave(Request $request){
        Validator::make($request->all(), [
            'leave_id' => 'required|numeric|exists:leaves,id'
        ]);
            $leave=Leave::find($request->leave_id);
            if($leave->is_rejected){
                toastr()->error('The leave has already been rejected', 'Oops !!!');
                return redirect()->back();
            }elseif($leave->is_accepted){
                toastr()->error('The leave has already been accepted', 'Oops !!!');
                return redirect()->back();
            }else{
                $start=Carbon::parse($leave->from);
                $end=Carbon::parse($leave->to);
                $u=$leave->user;
                $dh=$u->department->holidays;
                foreach($dh as $row){
                    $days[]=$row->day;
                }
                while (strtotime($start) <= strtotime($end)) {
                    $day = $start->format('w');
                        if(!empty($days))
                        {
                            if(!in_array($day, $days))
                            {
                                $prev_leave = Attendance::where('user_id',$leave->user->id)->where('date',date ("Y-m-d", strtotime($start)))
                                                        ->where('is_leave',1)->first();
                                if(!$prev_leave){
                                    $dates[]=date ("Y-m-d", strtotime($start));
                                    $attendance = new Attendance();
                                    $attendance->user_id = $leave->user->id;
                                    $attendance->shift_id = $leave->shift_id;
                                    $attendance->date = date ("Y-m-d", strtotime($start));
                                    $attendance->remarks = $leave->description;
                                    $attendance->is_leave = 1;
                                    $attendance->leave_type_id = $leave->type->id;
                                    $attendance->leave_day = 1;
                                    $attendance->leave_id= $leave->id;
                                    $attendance->is_paid = true;
                                    $attendance->save();
                                    $data['date']=date ("Y-m-d", strtotime($start));
                                    $data['leave_type_id']=$leave->type->id;
                                    $data['leave_id']=$leave->id;
                                    $data['user_id']=$leave->user->id;
                                    $data['accepted_by']=Auth::user()->id;
                                    $data['is_paid']=true;
                                    AcceptedLeave::create($data);
                                }
                            }
                        }
                        $start = date ("Y-m-d", strtotime("+1 day", strtotime($start)));
                        $start = Carbon::parse($start);
                }
                if($leave->reviewed_by && $leave->reviewed_date){
                $leave->approved_by=Auth::user()->id;
                $leave->approved_date=now()->format('Y-m-d');
                $leave->is_accepted=true;
                }else{
                $leave->reviewed_by=Auth::user()->id;
                $leave->reviewed_date=now()->format('Y-m-d');
                $leave->is_reviewed=true;
                $leave->approved_by=Auth::user()->id;
                $leave->approved_date=now()->format('Y-m-d');
                $leave->is_accepted=true;
                }
                $userLeave = UserLeaveType::where('user_id',$u->id)->where('leave_type_id', $leave->type->id)->first();
                $takenLeave = $end->diffInDays($start) + 1;
                $userLeave->taken = $takenLeave;
                $userLeave->remaining_leave = $userLeave->remaining_leave - $takenLeave;
                $userLeave->update();
                $leave->update();
                $this->leaveMailNotification($leave);
                toastr()->success('The leave has been accepted', 'Success !!!');
                return redirect()->back();
            }
    }
    public function getPartialForm(Request $request){
        $leave = Leave::find($request->id);
        if($leave){
            $begin = Carbon::parse($leave->from);
            $end = Carbon::parse($leave->to);
            $dates = array();
            $view=view('leave.component.leave-grant-form')->with('begin',$begin)->with('end',$end)->with('leave',$leave)->render();
            return $view;
        }else{
            // return redirect()->back();
        }
    }
    public function partialAcceptLeave(Request $request){
        $leave= Leave::find($request->leave_id);
        $begin = Carbon::parse($leave->from);
        $end = Carbon::parse($leave->to);
        $data['leave_type_id']=$leave->type->id;
        $data['leave_id']=$leave->id;
        $data['user_id']=$leave->user->id;
        $data['accepted_by']=Auth::user()->id;
        $dates = array();
        $dh=$leave->user->department->holidays;
        foreach($dh as $row){
            $days[]=$row->day;
        }
        while (strtotime($begin) <= strtotime($end)) {
            $day = $begin->format('w');
                if(!in_array($day, $days)){
                    $prev_leave = Attendance::where('user_id',$leave->user->id)
                                                ->where('date',date ("Y-m-d", strtotime($begin)))
                                                ->where('is_leave',1)
                                                ->first();
                    if(!$prev_leave){
                        if( $request->x[date ("Y/m/d", strtotime($begin))] ==1){
                            //paid custom leave
                            $leave->status=true;
                            $leave->is_accepted=true;
                            $dates[]=date ("Y-m-d", strtotime($begin));
                            $attendance = new Attendance();
                            $attendance->user_id = $leave->user_id;
                            $attendance->shift_id = $leave->shift_id;
                            $attendance->date = date ("Y-m-d", strtotime($begin));
                            $attendance->remarks = $leave->description;
                            $attendance->is_leave = 1;
                            $attendance->leave_type_id = $leave->type->id;
                            $attendance->leave_day = 1;
                            $attendance->leave_id= $leave->id;
                            $attendance->is_paid = true;
                            $attendance->save();
                            $data['is_paid'] = true;
                            $data['date']=date ("Y-m-d", strtotime($begin));
                            AcceptedLeave::create($data);
                        }elseif($request->x[date ("Y/m/d", strtotime($begin))] ==2){
                            //unpaid custom leave
                            $leave->status=true;
                            $leave->is_accepted=true;
                            $dates[]=date ("Y-m-d", strtotime($begin));
                            $attendance = new Attendance();
                            $attendance->user_id = $leave->user_id;
                            $attendance->shift_id = $leave->shift_id;
                            $attendance->date = date ("Y-m-d", strtotime($begin));
                            $attendance->remarks = $leave->description;
                            $attendance->is_leave = 1;
                            $attendance->leave_type_id = $leave->type->id;
                            $attendance->leave_day = 1;
                            $attendance->is_paid = false;
                            $attendance->leave_id= $leave->id;
                            $attendance->save();
                            $data['is_paid'] = false;
                            $data['date']=date ("Y-m-d", strtotime($begin));
                            AcceptedLeave::create($data);
                        }elseif($request->x[date ("Y/m/d", strtotime($begin))] ==3){
                            $leave->is_rejected = true;
                        }
                    }
                 }
                 $begin = date ("Y-m-d", strtotime("+1 day", strtotime($begin)));
                 $begin = Carbon::parse($begin);
        }
        if($leave->reviewed_by && $leave->reviewed_date){
            $leave->approved_by=Auth::user()->id;
            $leave->approved_date=now()->format('Y-m-d');
            $leave->is_accepted=true;
        }else{
            $leave->reviewed_by=Auth::user()->id;
            $leave->reviewed_date=now()->format('Y-m-d');
            $leave->is_reviewed=true;
            $leave->approved_by=Auth::user()->id;
            $leave->approved_date=now()->format('Y-m-d');
            $leave->is_accepted=true;
        }
        $leave->update();
        $this->leaveMailNotification($leave);
        // Mail::to($leave->user->email)->send(new LeaveResult($leave->user->name,$leave->start->format('Y/m/d'),$leave->end->format('Y/m/d')));
        toastr()->success('Leave accepted successfully', 'Success !!!');
        return redirect()->route('leave.index');
    }
    public function minimumLeave(){
        $min_leave = CompanySetting::where('id', 1)->first()->min_leave_days_for_review;
        return $min_leave;
    }
    public function leaveMailNotification($leave)
    {
        $user = User::where('id', $leave->user->id)->first();
        $ceos = User::where('role', 2)->where('is_head', 'yes')->where('is_deleted', false)->get();
        $first_approval = User::where('id', $user->first_approval_id)->first();
        // $line_managers = User::where('department_id', $user->department_id)->where('role', 4)->where('is_head', 'yes')->get();
        $start=Carbon::parse($leave->from);
        $end=Carbon::parse($leave->to);
        $reason=$leave->description;
        foreach($ceos as $ceo){
            Mail::to($ceo->email)->send(new LeaveApprove($user, $first_approval,$start,$end,$reason));
        }
        $user->notify(new LeaveApproveNotification($user, Auth::user()));
        Mail::to($user->email)->send(new LeaveRequestApprove($user));
        return true;
    }
    public function rejectedLeaveMail($leave)
    {
        $user = User::where('id', $leave->user->id)->first();
        $ceos = User::where('role', 2)->where('is_head', 'yes')->where('is_deleted', false)->get();
        $line_managers = User::where('department_id', $user->department_id)->where('role', 4)->where('is_head', 'yes')->get();
        if(Auth::user()->role == 4 && Auth::user()->is_head == 'yes'){
            foreach($ceos as $ceo){
                $ceo->notify(new LeaveRejectNotification($ceo, Auth::user()));
            }
        }else{
            foreach($line_managers as $lm){
                $lm->notify(new LeaveRejectNotification($lm, Auth::user()));
            }
        }
        $user->notify(new LeaveRejectNotification($user, Auth::user()));
        Mail::to($user->email)->send(new LeaveRequestReject($user, route('leave.index')));
        return;
    }
}
