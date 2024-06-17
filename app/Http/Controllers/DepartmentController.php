<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Shift;
use App\Models\Change;
use App\Models\DepartmentHoliday;
use App\Models\Project;
use Carbon\Carbon;
use Validator;
class DepartmentController extends Controller
{
    public function index(){
        $departments=Department::with('shifts')->with('holidays')->where('is_default',false)->get();
        return view('department.index')
                ->with('departments',$departments);
    }
    public function create(){
        return view('department.create');
    }
    public function store(Request $request){
        $department=Department::create($request->only('name'));
        if($request->has('clockin')){
            $data['department_id']=$department->id;
            foreach($request->clockin as $key=>$clockin){
                $data['clockin']=date("H:i", strtotime($clockin));
                $data['clockout']=date("H:i", strtotime($request->clockout[$key]));
                Shift::create($data);
            }
        }
        //Department Holiday
        if($request->has('holiday')){
            $change_data['department_id']= $department->id;
            $change_data['from']= Carbon::now()->format('Y/m/d');
            $change=Change::create($change_data);
            foreach($request->holiday as $holiday){
                $data_department_hliday['department_id']=$department->id;
                $data_department_hliday['change_id']=$change->id;
                $data_department_hliday['day']=$holiday;
                if($holiday == 0){
                    $data_department_hliday['day_name'] = "Sun";
                }elseif($holiday == 1){
                    $data_department_hliday['day_name'] = "Mon";
                }elseif($holiday == 2){
                    $data_department_hliday['day_name'] = "Tue";
                }elseif($holiday == 3){
                    $data_department_hliday['day_name'] = "Wed";
                }elseif($holiday == 4){
                    $data_department_hliday['day_name'] = "Thu";
                }elseif($holiday == 5){
                    $data_department_hliday['day_name'] = "Fri";
                }elseif($holiday == 6){
                    $data_department_hliday['day_name'] = "Sat";
                }else{
                    $data_department_hliday['day_name'] = "";
                }
                $data_department_hliday['active_from']=Carbon::now();
                DepartmentHoliday::create($data_department_hliday);
            }
        }
        //Project
            $data_project['name']='Other';
            $data_project['is_other']=true;
            $data_project['department_id']=$department->id;
            $data_project['deadline']=Carbon::today();
            Project::create($data_project);
        //Project
        toastr()->success('Department created successfully', 'Success !!!');
        return redirect()->route('department.index');
    }

    public function getChangeHolidayForm(Request $request){
        $res['status']=false;
        $res['message']='';
        if($request->has('department_id')){
            $department=Department::with('holidays')->find($request->department_id);
            $current_holiday=[];
            foreach($department->holidays as $holiday){
                $current_holiday[]=$holiday->day;
            }
            $res['status']=true;
            $res['view']= view('department.component.change-holiday',compact('department','current_holiday'))->render();
        }
        return json_encode($res);
    }

    public function updateHoliday(Request $request){

        $res['status']=false;
        $res['message']='';
        //Validation
        $validator = Validator::make($request->all(), [
            'department_id' => 'required|exists:departments,id',
            'holiday' => 'sometimes',
            'holiday.*' => 'numeric',

        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['message']=$errors->first();
        }else{
            $department= Department::with('holidays')->find($request->department_id);
            $current_holidays=$department->holidays;
            $current_holiday_arr=[];
            foreach($current_holidays as $ch){
                $current_holiday_arr[]=$ch->day;
            }

            if($current_holiday_arr==$request->holiday){
                $res['message']='No Change';
            }else{
                if($request->has('holiday')){
                    $res['message']='New Change';
                    $previous_change=Change::where('department_id',$department->id)->where('status',1)->first();
                    if($previous_change){
                       //Update Old Change
                        $previous_change->status=false;
                        $previous_change->to=Carbon::now();
                        $previous_change->update();
                        $res['message']='Change and also old holiday changed';
                    }
                    foreach($current_holidays as $ch){
                        //Update Old Holiday
                        $ch->status=false;
                        $ch->update();
                    }

                    //Create New Change
                    $change_data['department_id']= $department->id;
                    $change_data['from']= Carbon::today();
                    $change=Change::create($change_data);


                    $data['department_id']=$department->id;
                    $data['change_id']=$change->id;
                    $data['active_from']=$change->from;

                    foreach($request->holiday as $holiday){
                        //Save new Holiday
                        $data['day']=$holiday;
                        if($holiday == 0){
                            $data['day_name'] = "Sun";
                        }elseif($holiday == 1){
                            $data['day_name'] = "Mon";
                        }elseif($holiday == 2){
                            $data['day_name'] = "Tue";
                        }elseif($holiday == 3){
                            $data['day_name'] = "Wed";
                        }elseif($holiday == 4){
                            $data['day_name'] = "Thu";
                        }elseif($holiday == 5){
                            $data['day_name'] = "Fri";
                        }elseif($holiday == 6){
                            $data['day_name'] = "Sat";
                        }else{
                            $data['day_name'] = "";
                        }
                        DepartmentHoliday::create($data);
                    }
                    $res['status']=true;


                }else{
                    $previous_change=Change::where('department_id',$department->id)->where('status',1)->first();
                    if($previous_change){
                       //Update Old Change
                        $previous_change->status=false;
                        $previous_change->to=Carbon::now();
                        $previous_change->update();
                        $res['message']='Change and also old holiday changed';
                    }
                    foreach($current_holidays as $ch){
                        //Update Old Holiday
                        $ch->status=false;
                        $ch->update();
                    }
                    $res['status']=true;
                    $res['message']='Remove All Holiday';

                }
            }
        }
        toastr()->success('Holiday changed', 'Success!!');
        return json_encode($res);
    }
}
