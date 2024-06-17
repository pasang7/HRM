<?php

namespace App\Http\Controllers;
use App\Helpers\NepaliDate;
use Illuminate\Http\Request;
use Auth;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Support\Facades\Hash;
use Validator;


use App\Models\User;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Shift;
use App\Models\DefaultClockout;
use App\Models\AcceptedLeave;
use App\Models\CompanySetting;
use App\Models\Report;
use App\Models\Setting;
use App\Models\SalaryPaid;
use Storage;
use Illuminate\Http\Response;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;

class GuestAttendanceController extends Controller
{
    public function getClockinForm(Request $request){
        $res['status']=false;
        $res['message']='';
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['message']=$errors->first();
        }else{
            $user=User::find($request->user_id);
            $shifts=$user->department->active_shifts;
            $res['status']=true;
            $res['view']= view('attendance.guest_component.clockin-form',compact('user','shifts'))->render();
        }
        return json_encode($res);
    }

    public function clockin(Request $request){
        $res['status']=false;
        $res['title']='';
        $res['text']='';

        $validator = Validator::make($request->all(), [
            'pin' => 'required',
            'user_id' => 'required|exists:users,id',
            'shift_id' => 'required|exists:shifts,id',

            'time' => 'required',
            'image'=>'required'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['title']=$errors->first();
        }else{
            $user=User::find($request->user_id);
            if($user){
                if (Hash::check($request->pin, $user->pin))
                {
                    $date=Carbon::today();
                    $old_default_clockout = Attendance::where('user_id',$user->id)
                            ->where('default_clockout',true)
                            ->first();
                    $already_clocked_in = Attendance::whereDate('date', $date)
                            ->where('user_id',$user->id)
                            ->where('clockout',null)
                            ->first();
                    $clocked_in_today = Attendance::whereDate('date', $date)
                            ->where('user_id',$user->id)
                            ->where('clockout','!=',null)
                            ->get();
                    $is_already_clocked_in=false;
                    if($clocked_in_today){
                        foreach($clocked_in_today as $clockin){
                            if (strtotime($request->time)<= strtotime($clockin->clockout)){
                                $is_already_clocked_in=true;
                            }
                        }
                    }

                    if($old_default_clockout){
                        $res['title']='Old Attendance';
                        $res['text']='You are yet to clockout.';
                    }elseif($already_clocked_in){
                        $res['title']='Clocked In';
                        $res['text']='You are already clocked in.';
                    }elseif($is_already_clocked_in){
                        $res['title']='Clocked In';
                        $res['text']='You were present.';
                    }else{
                        $shift=Shift::find($request->shift_id);
                        $image = str_replace('data:image/png;base64,', '', $request->image);
                        $image = str_replace(' ', '+', $image);
                        $image_name=  time().'-cin.png';
                        Storage::disk('verification')->put($image_name, base64_decode($image));
                        $is_leave=AcceptedLeave::whereDate('date',Carbon::today())
                                                ->where('user_id',$user->id)
                                                ->count();
                        if($is_leave>=1){
                            $leave=AcceptedLeave::whereDate('date',Carbon::today())
                                                ->where('user_id',$user->id)
                                                ->first();
                            $data['is_leave']=true;
                            $data['leave_id']=$leave->id;
                            $data['leave_type_id']=$leave->type->id;
                            $data['leave_day']=$leave->leave->leave_type_full==1?1:0.5;
                        }
                        if ($request->is_changed) {
                            $data['actual_time']=$request->time;
                            $data['clockin'] = Carbon::now()->format('H:i');
                            $data['status'] = 'unverified';
                        } else {
                            $data['clockin']=$request->time;
                            $data['status'] = 'verified';
                        }
                        $data['user_id']=$user->id;
                        $data['date']=$date;
                        $data['clockin_verification']=$image_name;
                        $data['shift_id']=$shift->id;
                        $settings = CompanySetting::where('id', 1)->first();
                        $data['is_late'] = Carbon::parse($request->time)->gt(Carbon::parse($settings->max_allow_time)) ? 1 : 0;
                        $data['remarks']=$request->remarks;
                        Attendance::create($data);
                        $res['status']=true;
                    }
                }else{
                    $res['title']='Incorrect pin';
                    $res['text']='Please try again with correct pin.';
                }

            }else{
                $res['title']='No such user found';
                $res['text']='Please try again later';

            }

        }

        return json_encode($res);
    }
    public function getClockoutForm(Request $request){
        $res['status']=false;
        $res['text']='';
        $res['title']='';
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['text']='Oops';
            $res['text']=$errors->first();
        }else{
                $user=User::find($request->user_id);
                $today=Carbon::today();
                $attendance=Attendance::where('user_id',$user->id)
                                        ->whereDate('date',$today)
                                        ->where('clockout',null)
                                        ->first();
                if($attendance){
                    $res['status']=true;
                    $res['view']= view('attendance.guest_component.clockout-form',compact('user','attendance'))->render();

                }else{
                    $res['text']='Cannot Clockout without clockin';
                    $res['title']='Oops';

                }
        }


        return json_encode($res);
    }

    public function clockout(Request $request){
        $res['status']=false;
        $res['title']='';
        $res['text']='';

        $validator = Validator::make($request->all(), [
            'pin' => 'required',
            'user_id' => 'required|exists:users,id',
            'attendance_id' => 'required|exists:attendances,id',
            'time' => 'required',
            'image'=>'required'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['title']=$errors->first();
        }else{
            $user=User::find($request->user_id);
            if($user){
                if (Hash::check($request->pin, $user->pin))
                {
                    $date=Carbon::today();
                    $attendance = Attendance::where('user_id',$user->id)
                            ->where('id',$request->attendance_id)
                            ->where('clockout',null)
                            ->first();
                    if($attendance){
                        $image = str_replace('data:image/png;base64,', '', $request->image);
                        $image = str_replace(' ', '+', $image);
                        $image_name=  time().'-cin.png';
                        Storage::disk('verification')->put($image_name, base64_decode($image));
                        $attendance->clockout=$request->time;
                        $attendance->clockout_verification=$image_name;
                        $attendance->update();
                        $res['status']=true;
                    }else{
                        $res['title']='Already Clockout';
                        $res['text']='You are already clockedout.';
                    }
                }else{
                    $res['title']='Incoreect pin';
                    $res['text']='Please try again with correct pin.';
                }
            }else{
                $res['title']='No such user found';
                $res['text']='Please try again later';
            }
        }
        return json_encode($res);
    }

    public function getDefaultClockoutForm(Request $request){
        $res['status']=false;
        $res['text']='';
        $res['title']='';

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'attendance_id' => 'required|exists:attendances,id'

        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['text']='Oops';
            $res['text']=$errors->first();
        }else{

            $today=Carbon::today();
            $user=User::find($request->user_id);
            $attendance=Attendance::where('id',$request->id)
                                    ->where('user_id',$user->id)
                                    ->where('default_clockout',1)
                                    ->first();
            if($attendance){
                $res['status']=true;
                $res['view']= view('attendance.guest_component.default-clockout-form',compact('user','attendance'))->render();

            }else{
                $res['text']='Already Clocked Out';
                $res['title']='Oops';
            }
        }

        return json_encode($res);
    }

    public function defaultClockout(Request $request){
        $res['status']=false;
        $res['title']='';
        $res['text']='';

        $validator = Validator::make($request->all(), [
            'pin' => 'required',
            'user_id' => 'required|exists:users,id',
            'attendance_id' => 'required|exists:attendances,id',
            'time' => 'required',
            'image'=>'required'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['title']=$errors->first();
        }else{
            $user=User::find($request->user_id);
            if($user){
                if (Hash::check($request->pin, $user->pin))
                {
                    $date=Carbon::today();
                    $attendance = Attendance::where('user_id',$user->id)
                            ->where('id',$request->attendance_id)
                            ->where('default_clockout',true)
                            ->first();
                    if($attendance){

                        $image = str_replace('data:image/png;base64,', '', $request->image);
                        $image = str_replace(' ', '+', $image);
                        $image_name=  time().'-cin.png';
                        Storage::disk('verification')->put($image_name, base64_decode($image));


                        $attendance->clockout=$request->time;
                        $attendance->clockout_verification=$image_name;
                        $attendance->default_clockout=false;
                        $attendance->update();

                        $res['status']=true;
                    }else{
                        $res['title']='Already Clockout';
                        $res['text']='You are already clockedout.';
                    }



                }else{
                    $res['title']='Incoreect pin';
                    $res['text']='Please try again with correct pin.';
                }

            }else{
                $res['title']='No such user found';
                $res['text']='Please try again later';

            }

        }

        return json_encode($res);
    }

    public function autoDefaultClockout(){
        $min_date= config('software.start_date');
        $latest_default_clockout=DefaultClockout::orderBy('id', 'desc')->first();
        if($latest_default_clockout){
            $from=Carbon::parse($latest_default_clockout->date);
        }else{
            $from=Carbon::parse($min_date);
        }
        if($from>=Carbon::yesterday()){
            dd('yesterday');
        }else{

            $dates=CarbonPeriod::create($from->add(1,'days'),Carbon::yesterday());

            foreach ($dates as $date) {
                $users=User::where('is_deleted',false)
                            ->where('department_id','!=',1)
                            ->get();
                if($users){
                    foreach($users as $user){
                        //For creating attendance
                        $data['user_id']=$user->id;
                        $data['date']=$date;
                        $data['is_absent']=false;
                        $data['is_holiday']=false;
                        $data['holiday_id']=null;
                        $data['holiday_type']=null;

                        $data['is_leave']=false;
                        $data['leave_id']=null;
                        //For creating attendance

                        $is_user_holiday=false;
                        $is_department_holiday=false;
                        $holiday_id=null;

                        if($user->holidays->count()>0){
                            foreach($user->holidays as $holiday){
                                if($holiday->day==$date->format('w')){
                                    $is_user_holiday=true;
                                    $holiday_id=$holiday->id;

                                }
                            }
                        }
                        else{
                            if($user->department->holidays->count()>0){
                                foreach($user->department->holidays as $holiday){
                                    if($holiday->day==$date->format('w')){
                                        $is_department_holiday=true;
                                        $holiday_id=$holiday->id;
                                    }
                                }
                            }else{

                            }
                        }
                        $attendances=Attendance::where('user_id',$user->id)->whereDate('date',$date)->get();

                        if($attendances->count()>=1){ //If attendance
                            foreach($attendances as $attendance){
                                if($attendance->clockout==null){//If no clockout
                                    $attendance->clockout=Carbon::now();
                                    $attendance->default_clockout=true;
                                    $attendance->update();
                                }
                            }
                        }else{ //If no attendance
                           //Leave Check
                                $leave=AcceptedLeave::where('user_id',$user->id)
                                                    ->whereDate('date',$date)
                                                    ->first();

                           //Leave Check
                            if($is_user_holiday || $is_department_holiday || $leave){ //If holiday

                                if($leave){
                                    $data['is_leave']=true;
                                    $data['leave_id']=$leave->id;
                                    $data['leave_type_id']=$leave->type->id;
                                    $data['leave_day']=1;

                                }else{
                                    if($is_user_holiday){
                                        $data['holiday_id']=$holiday_id;
                                        $data['holiday_type']=01;
                                    }elseif($is_department_holiday){
                                        $data['holiday_id']=$holiday_id;
                                        $data['holiday_type']=10;
                                    }
                                    $data['is_holiday']=true;
                                }
                                Attendance::create($data);
                            }else{ //If no Holiday
                                $data['is_absent']=true;
                                Attendance::create($data);
                            }
                        }

                    }
                }

                $default_clockout_data['date']=$date;
                DefaultClockout::create($default_clockout_data);
            }

            dd('done');
            die;

        }
    }

    public function getVerificationImage($name){
        $file = Storage::disk('verification')->get($name);
        return new Response($file,200);
    }

    public function getAttendanceDetail(Request $request){
        $res['status']=false;
        $res['title']='';
        $res['text']='';

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date'

        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['title']=$errors->first();
        }else{
            $user=User::with('department','department.shifts')->where('id',$request->user_id)->first();
            $date=Carbon::parse($request->date);
            $nepali_date = NepaliDate::eng_to_nep($date->format('Y'),$date->format('m'),$date->format('d'));

            $attendances=Attendance::where('user_id',$user->id)
                                    ->whereDate('date',$date)
                                    ->get();
            $is_leave=false;
            $is_holiday=false;
            $is_absent=false;
            $is_present=false;
            $is_salary_paid=SalaryPaid::whereMonth('date',$date->format('m'))->whereYear('date',$date->format('y'))->first();
            $is_real=false;
            if($is_salary_paid){
                $is_real=true;
            }
            if($attendances->count()==0){ //No entry
                $res['status']=true;
                $res['view']= view('attendance.guest_component.noentry-modal',compact('user','date','nepali_date','is_real'))->render();
            }elseif($attendances->count()>=1){ //Present //Absent //Holiday //Leave
                foreach($attendances as $attendance){
                    if($attendance->is_holiday){
                        $is_holiday=true;
                    }elseif($attendance->is_absent){
                        $is_absent=true;
                    }elseif($attendance->is_leave){
                        if($attendance->clockin){
                            $is_leave=true;
                            $is_present=true;
                        }else{
                            $is_leave=true;
                        }

                    }else{
                        $is_present=true;
                    }
                }
            }

            if($is_present && $is_leave){
                $res['view']= view('attendance.guest_component.present-modal',compact('user','attendances','date','nepali_date','is_leave','is_real'))->render();
            }
            elseif($is_leave){
                $leave_type='';
                $reason='';

                foreach($attendances as $attendance){
                    $leave_type=$attendance->leave_type->name;
                    $reason=$attendance->remarks;
                }
                $res['view']= view('attendance.guest_component.leave-modal',compact('user','attendances','date','nepali_date','is_leave','leave_type','reason','is_real'))->render();

            }elseif($is_holiday){
                $holiday_type='';
                $holiday_reason='';
                // 01->user
                // 10->department
                // 11->custom
                foreach($attendances as $attendance){
                    if($attendance->holiday_type==01){
                        $holiday_type='user';
                        $day=$attendance->holiday->day;
                        $holiday_reason=$day;
                    }elseif($attendance->holiday_type==10){
                        $holiday_type='department';
                        $day=$attendance->holiday->day;
                        $holiday_reason=$day;
                    }
                    elseif($attendance->holiday_type==11){
                        $holiday_type='custom';
                        $day=$attendance->holiday->day;
                        $holiday_reason=$day;
                    }
                }
                $res['view']= view('attendance.guest_component.holiday-modal',compact('user','attendances','date','nepali_date','holiday_type','holiday_reason'))->render();

            }elseif($is_absent){
                $res['view']= view('attendance.guest_component.absent-modal',compact('user','attendances','date','nepali_date','is_real'))->render();

            }elseif($is_present){
                $res['view']= view('attendance.guest_component.present-modal',compact('user','attendances','date','nepali_date','is_leave'))->render();
            }
            $res['data']=[
                'present'=>$is_present,
                'absent'=>$is_absent,
                'holiday'=>$is_holiday,
                'leave'=>$is_leave,
            ];
            $res['at']=$attendances;
            $res['status']=true;

        }

        return json_encode($res);
    }
}
