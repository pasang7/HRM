<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Project;
use App\Models\AcceptedLeave;
use App\Models\Attendance;
use Session;
use Carbon\Carbon;
use App\Charts\UserChart;
use App\Models\Department;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\Report;
use App\Models\Travel;
use Illuminate\Support\Facades\DB;
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('welcome');
    }
    public function welcome(){
        if(Auth::User()){
            return redirect()->route('home');
        }else{
            $users=User::with('clockout','default_clockout')
                        ->where('is_deleted',0)
                        ->where('department_id','!=',1)
                        ->get();
            $attendance_user=[];
            $late_clockout=[];

            foreach($users as $user){
                $is_leave=AcceptedLeave::whereDate('date',Carbon::today())
                                            ->where('user_id',$user->id)
                                            ->count();
                if($is_leave>=1){
                    $leave=AcceptedLeave::whereDate('date',Carbon::today())
                                        ->where('user_id',$user->id)
                                        ->first();
                    $type='';
                    if($leave->leave->leave_type_full){
                        $data=[
                            'leave'=>true,
                            'allow_attendance'=>false,
                            'leave_type'=>'full',
                            'user'=>$user,
                            'type'=>'clockin',
                            'attendance'=>null
                        ];
                    }else{
                        $type='half';
                        if($user->clockout || $user->default_clockout){
                            if($user->clockout){
                                $data=[
                                    'leave'=>true,
                                    'allow_attendance'=>true,
                                    'leave_type'=>'half',
                                    'user'=>$user,
                                    'type'=>'clockout',
                                    'attendance'=>$user->clockout
                                ];
                            }elseif($user->default_clockout){
                                $data=[
                                    'leave'=>true,
                                    'allow_attendance'=>true,
                                    'leave_type'=>'half',
                                    'user'=>$user,
                                    'type'=>'default-clockout',
                                    'attendance'=>$user->default_clockout
                                ];
                            }
                        }else{
                            $attendance=Attendance::where('user_id',$user->id)
                                                    ->whereDate('date',Carbon::today())
                                                    ->count();
                            if($attendance==0){
                                $data=[
                                    'leave'=>true,
                                    'allow_attendance'=>true,
                                    'leave_type'=>'half',
                                    'user'=>$user,
                                    'type'=>'clockin',
                                ];
                            }else{
                                $data=[
                                    'leave'=>true,
                                    'allow_attendance'=>false,
                                    'leave_type'=>'half',
                                    'user'=>$user,
                                    'type'=>'clockin',
                                ];
                            }
                        }
                    }

                }else{
                    if($user->clockout || $user->default_clockout){
                        if($user->clockout){
                            $data=[
                                'leave'=>false,
                                'allow_attendance'=>true,
                                'user'=>$user,
                                'type'=>'clockout',
                                'attendance'=>$user->clockout
                            ];
                        }elseif($user->default_clockout){
                            $data=[
                                'leave'=>false,
                                'allow_attendance'=>true,
                                'user'=>$user,
                                'type'=>'default-clockout',
                                'attendance'=>$user->default_clockout
                            ];
                        }
                    }else{
                        $data=[
                            'leave'=>false,
                            'allow_attendance'=>true,
                            'leave_type'=>'',
                            'user'=>$user,
                            'type'=>'clockin',
                            'attendance'=>null
                        ];
                    }

                }
                $attendance_user[]=$data;
            }
            return view('welcome')->with('attendance_user',$attendance_user);
        }
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user=Auth::user();
        $userAttendance = $user->today_attendance;
            if(count($userAttendance) != 0) {
                $data['clock_in']=$userAttendance[0]->clockin;
                $data['clock_out']=$userAttendance[0]->clockout;
                $data['clockedIn']=true;
            } else {
                $data['clockedIn']=false;
            }
        $data['employees'] = $data['users'] = User::where('department_id', '!=',1)->where('is_deleted',false)->get();
        $data['travelReports'] = $user->recentTravelReports;
        $data['user_leave_types'] = $this->getLeaveReport($user);
        $data['all_projects']=Project::where('status','active');
        $data['reports']=Report::all()->count();
        $data['projects']=Project::where('department_id',$user->department_id)->get();
        $data['my_tasks']=$user->active_tasks;
        $data['assigned_tasks']=$user->assigned_tasks;
        $data['line_managers']=User::where('role', 4)->where('is_deleted', false)->get();
        //attendance count overview
        $data['attendance_count']= $this->todayAttendanceCount();
        //PIE CHART DETAILS
        $data['pie_chart'] = $this->getPieChartValue();
        //OTHER CHART
        $data['chart'] = $this->newEmployeeChart();
        //Horizontal Bar
        $data['role'] = $this->roleWiseBar();
        //Google Bar Chart
        $data['departments'] = Department::where('is_default','!=',1)->get()->count();
        $current_month = now()->format('m');
        $data['current_month_birthdays'] = User::where('department_id', '!=',1)->where('is_deleted',false)->whereMonth('dob', $current_month)->orderBy('dob', 'desc')->get();
        $data['current_month_holidays'] = Holiday::whereMonth('start', $current_month)->get();
        $data['today_leaves'] = Leave::whereMonth('from',$current_month)
        ->whereDate('from','<=',Carbon::today())
        ->whereDate('to','>=',Carbon::today())->orderBy('from', 'desc')->get();
        $data['today_travels'] = Travel::whereMonth('from',$current_month)
        ->whereDate('from','<=',Carbon::today())
        ->whereDate('to','>=',Carbon::today())->orderBy('from', 'desc')->get();
        return view('home', $data);
    }

    public function getLeaveReport($user) {
        $user_leave_types=[];

        foreach($user->leave_types as $user_leave_type){
            //new
            $available_leave=$user_leave_type->days;
            $leave_taken = $user_leave_type->taken;
            $remaining = $user_leave_type->remaining_leave;
            $user_leave_types[]=[
                'name'=>$user_leave_type->leave_type->name,
                'yearly'=>$available_leave,
                'taken'=>$leave_taken,
                'available'=>$remaining
            ];
        }
        return $user_leave_types;
    }
    public function todayAttendanceCount()
    {
        $present = Attendance::where('is_absent', false)->where('is_leave', false)->whereDate('date',Carbon::now()->format('Y-m-d'))
        ->get()->count();
        $late = Attendance::where('is_late', true)->where('date',Carbon::now()->format('Y-m-d'))
        ->get()->count();
        $absent = Attendance::where('is_absent', true)->where('is_leave', false)->where('date',Carbon::now()->format('Y-m-d'))
        ->get()->count();
        $on_leave = Attendance::where('is_leave', true)->where('is_absent', false)->where('date',Carbon::now()->format('Y-m-d'))
        ->get()->count();
        $data = [
            'present' => $present,
            'late' => $late,
            'absent' => $absent,
            'on_leave' => $on_leave,
        ];
        return $data;
    }
    public function getPieChartValue()
    {
        $data['male_count'] = User::where('department_id','!=',1)->where('gender', 1)->get()->count();
        $data['female_count'] = User::where('department_id','!=',1)->where('gender', 0)->get()->count();
        $data['unmarried_count'] = User::where('department_id','!=',1)->where('is_married', 0)->get()->count();
        $data['married_count'] = User::where('department_id','!=',1)->where('is_married', 1)->get()->count();
        return $data;
    }
    public function newEmployeeChart()
    {
        $employee = User::select(DB::raw("COUNT(*) as count"))
        ->where('department_id','!=',1)
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))
        ->pluck('count');
        $data['chart'] = new UserChart;
        $data['chart']->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $data['chart']->dataset('Total Employee', 'line', $employee)->options([
            'fill' => 'true',
            'borderColor' => '#51C1C0'
        ]);
        return $data;
    }
    public function roleWiseBar()
    {
        $data['ceo'] = User::where('role',2)->get()->count();
        $data['hr'] = User::where('role',3)->get()->count();
        $data['line_manager'] = User::where('role',4)->get()->count();
        $data['staff_count'] = User::where('role',5)->get()->count();
        return $data;
    }
}
