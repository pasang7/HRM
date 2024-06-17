<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistration;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use App\Models\UserPermission;
use App\Models\Change;
use App\Models\UserHoliday;
use App\Models\LeaveType;
use App\Models\UserLeaveType;
use App\Models\Attendance;
use App\Models\BloodGroup;
use App\Models\CompanySetting;
use App\Models\ContractType;
use App\Models\Designation;
use App\Models\District;
use App\Models\EmployeeId;
use App\Models\Gender;
use App\Models\Province;
use App\Models\Religion;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Salary;
use App\Models\SalaryHistory;
use App\Models\Service\User\UserService;
use App\Models\UserDocument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;
use Image;
use Storage;
use Rats\Zkteco\Lib\ZKTeco;

class UserController extends Controller
{
    protected $user;
    protected $imageController;
    function __construct(UserService $user, ImageController $imageController)
    {
        $this->user=$user;
        $this->imageController=$imageController;
    }
    public function index(){
        $users=User::where('department_id','!=',1)->get();
        return view('user.index')->with('users',$users);
    }
    public function create(){
        $data['setting']= $this->companySetting();
        $data['details'] = $this->getOtherDetails();
        return view('user.create')->with($data);
    }
    public function store(Request $request){
        //validation
        $request->validate([
            'name' => 'required',
            'religion' => 'required',
            'gender' => 'required',
            'role' => 'required',
            'department_id' => 'required|numeric|exists:departments,id',
            'dob' => 'required',
            'blood_group' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'province' => 'required',
            'district' => 'required',
            'municipality_vdc' => 'required',
            'address' => 'required',
            'temp_province' => 'required',
            'temp_district' => 'required',
            'temp_municipality_vdc' => 'required',
            'temp_address' => 'required',
            'interview_date'=>'required',
            'joined'=>'required',
            'designation' => 'required',
            // 'first_approval_id' => 'required',
        ]);
        //pan validation
        if($request->has('has_pan')){
            $request->validate([
                'pan_no' => 'required'
            ]);
        }
        //ssf validation
        if($request->has('has_ssf')){
            $request->validate([
                'ssf_no' => 'required'
            ]);
        }
        //pf validation
        if($request->has('has_pf')){
            $request->validate([
                'pf_no' => 'required'
            ]);
        }
        //end validation
        $random_password='password';
        $random_pin=1111;
        $userInfo=$request->except('_token','department_id');
        // $userInfo['slug']=Str::slug($request->get('name'));
        $userInfo['password']=bcrypt($random_password);
        $userInfo['pin']=bcrypt($random_pin);
        $department=Department::find($request->department_id);
        $userInfo['department_id']=$department->id;
        $userInfo['interview_date']=Carbon::parse($request->interview_date);
        $userInfo['joined']=Carbon::parse($request->joined);
        $userInfo['dob']=Carbon::parse($request->dob);
        //cit validation
        if($request->has('has_cit')){
            $request->validate([
                'cit_no' => 'required',
                'cit_amount' => 'required|numeric',
                'cit_percent' => 'required|numeric'
            ]);
            $userInfo['cit_percent'] = ceil($request->cit_percent);
        }
         $folder_name='UserDocuments';
            if($request->hasFile('profile_image')){
                $request->validate([
                    'profile_image' => 'sometimes|mimes:jpg,jpeg,png|max:5000'
                ]);
                $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'profile_image',450,450);
                $userInfo['profile_image']=$ImgName;
            }
            if($request->hasFile('citizenship')){
                $request->validate([
                    'citizenship' => 'mimes:pdf|max:5000'
                ]);
                $ImgName=$this->imageController->saveAnyFile($request,$folder_name,'citizenship');
                $userInfo['citizenship']=$ImgName;
            }
            if($request->hasFile('cv')){
                $request->validate([
                    'cv' => 'mimes:pdf|max:5000'
                ]);
                $ImgName=$this->imageController->saveAnyFile($request,$folder_name,'cv');
                $userInfo['cv']=$ImgName;
            }
        if($user=User::create($userInfo)){
        EmployeeId::insert(['employee_id' => $request->get('employee_id'), 'created_at'=>now(),'updated_at'=>now(),]);
        //salary
        $salaryInfo['user_id']=$user->id;
        $salaryInfo['salary']=$request['salary'];
        $salaryInfo['from']=$user->joined;
        $salaryInfo['created_by']=Auth::user()->id;
        $salaryDetails = Salary::create($salaryInfo);
        //salary history
        $salaryHistory['user_id'] = $user->id;
        $salaryHistory['salary'] = $salaryDetails->salary;
        $salaryHistory['from'] = $salaryDetails->from;
        SalaryHistory::create($salaryHistory);

        //for Attendance Device
        // $zk = new ZKTeco('192.168.0.190');
        // $zk->connect();
        // $zk->enableDevice();
        // $zk->setUser($user->id,$user->id,$user->name,'');

        //Permission
        if($request->has('permission')){
            if(in_array(0, $request->permission)){
                for($i=1;$i<=3;$i++){
                    $data['permission']=$i;
                    $data['user_id']=$user->id;
                    UserPermission::create($data);
                }
            }else{
                foreach($request->permission as $permission){
                    $data['permission']=$permission;
                    $data['user_id']=$user->id;
                    UserPermission::create($data);
                }
            }
        }
        $group_id=sha1(time());
        //Leaves
            if($request->has('leave')){
                foreach($request->leave as $leave_type_id=>$days){
                    $data_leave['group_id']=$group_id;
                    $data_leave['user_id']=$user->id;
                    $data_leave['leave_type_id']=$leave_type_id;
                    $data_leave['days']=$days;
                    $data_leave['is_active']=true;
                    UserLeaveType::create($data_leave);
                }
            }
            //Mail::to($user->email)->send(new UserRegistration($user,$random_password, $random_pin, route('welcome')));
            toastr()->success('Employee created successfully', 'Success !!!');
            return redirect()->route('user.index');
        }else{
            toastr()->error('Problem in creating employee', 'Oops !!!');
            return redirect()->route('user.index');
        }
    }
    public function show(Request $request, $id)
    {
        if($id)
        {
            $data['details']=$this->getUserWiseDetails($id);
        }
        return view('user.view')->with($data);
    }
    public function edit($slug){
        $user=User::where('slug',$slug)->first();
        if($user){
        $data['setting']= $this->companySetting();
        $data['details'] = $this->getOtherDetails();
            $leaves=[];
            $leave_types=LeaveType::all();
            $user_leave=$user->leave_types;
            foreach($leave_types as $leave){
                $leaves[$leave->id]=[
                    'days'=>0,
                    'name'=>$leave->name
                ];
            }
            foreach($user_leave as $leave){
                $leaves[$leave->leave_type_id]['days']=$leave->days;
            }
            return view('user.edit')
                    ->with('user',$user)
                    ->with('leaves',$leaves)
                    ->with($data);
        }else{
            return redirect()->route('user.index');
        }
    }
    public function update(Request $request){
        $request->validate([
            'slug'=>'required|exists:users,slug'
        ]);
        $request->validate([
            'name' => 'required',
            'religion' => 'required',
            'gender' => 'required',
            'role' => 'required',
            'department_id' => 'required|numeric|exists:departments,id',
            'dob' => 'required',
            'blood_group' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'province' => 'required',
            'district' => 'required',
            'municipality_vdc' => 'required',
            'address' => 'required',
            'temp_province' => 'required',
            'temp_district' => 'required',
            'temp_municipality_vdc' => 'required',
            'temp_address' => 'required',
            'interview_date'=>'required',
            'joined'=>'required',
            'designation' => 'required',
        ]);
        //pan validation
        if($request->has('has_pan')){
            $request->validate([
                'pan_no' => 'required'
            ]);
        }
        //ssf validation
        if($request->has('has_ssf')){
            $request->validate([
                'ssf_no' => 'required'
            ]);
        }
        //pf validation
        if($request->has('has_pf')){
            $request->validate([
                'pf_no' => 'required'
            ]);
        }
        //end validation
        $userInfo = $request->all();
        $user=User::where('slug',$request->slug)->first();
        $userInfo['password']=$user->password;
        $userInfo['pin']=$user->pin;
        $department=Department::find($request->department_id);
        $userInfo['department_id']=$department->id;
        $userInfo['interview_date']=Carbon::parse($request->interview_date);
        $userInfo['joined']=Carbon::parse($request->joined);
        $userInfo['dob']=Carbon::parse($request->dob);
        //cit validation
        if($request->has('has_cit')){
            $request->validate([
                'cit_no' => 'required',
                'cit_amount' => 'required|numeric',
                'cit_percent' => 'required|numeric'
            ]);

            $userInfo['cit_percent'] = ceil($request->cit_percent);
        }
        $folder_name='UserDocuments';
        //profile image update
        if($request->file('profile_image')==''){
            if($request->get('delete_profile_image')){
                $this->imageController->deleteImg($folder_name,$user->profile_image);
                $userInfo['profile_image'] = NULL;
            }else {
                $userInfo['profile_image'] = $user->profile_image;
            }
        }
        else{
            $this->imageController->deleteImg($folder_name,$user->profile_image);
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'profile_image', 500,500);
            $userInfo['profile_image']=$ImgName;
        }
        //citizenship update
        if($request->file('citizenship')==''){
            if($request->get('delete_citizenship')){
                $this->imageController->deleteFile($folder_name,$user->citizenship);
                $userInfo['citizenship'] = NULL;
            }else {
                $userInfo['citizenship'] = $user->citizenship;
            }
        }
        else{
            $this->imageController->deleteFile($folder_name,$user->citizenship);
            $ImgName=$this->imageController->saveAnyFile($request,$folder_name,'citizenship');
            $userInfo['citizenship']=$ImgName;
        }
        //cv update
        if($request->file('cv')==''){
            if($request->get('delete_cv')){
                $this->imageController->deleteFile($folder_name,$user->cv);
                $userInfo['cv'] = NULL;
            }else {
                $userInfo['cv'] = $user->cv;
            }
        }
        else{
            $this->imageController->deleteFile($folder_name,$user->cv);
            $ImgName=$this->imageController->saveAnyFile($request,$folder_name,'cv');
            $userInfo['cv']=$ImgName;
        }
        $user->update($userInfo);
        //salary update
        $user->current_salary->salary=$request->salary;
        $user->current_salary->update();
        if($request->has('leave')){
            $group_id=sha1(time());
            foreach($request->leave as $key=>$leave){
                $leave_type=UserLeaveType::where('user_id',$user->id)
                                        ->where('leave_type_id',$key)
                                        ->first();
                if($leave_type){
                    $leave_type->group_id=$group_id;
                    $leave_type->days= $leave;
                    $leave_type->remaining_leave= $leave;
                    $leave_type->taken= $leave_type->taken;
                    $leave_type->update();

                }else{
                    if($leave>=1){
                        UserLeaveType::create([
                            'group_id'=>$group_id,
                            'user_id'=>$user->id,
                            'days'=>$leave,
                            'remaining_leave'=>$leave,
                            'taken'=>0,
                            'leave_type_id'=>$key
                        ]);
                    }
                }
            }
        }
        toastr()->success('Employee updated successfully', 'Success !!!');
        return redirect()->route('user.index');
    }

    public function delete($slug){
        $staff = User::where('slug',$slug)->first();
        if(!empty($staff)){
            $staff->is_deleted =1;
            $staff->save();
            toastr()->success('Employee deleted successfully', 'Success !!!');
            return redirect()->route('user.index');
        }else{
            toastr()->success('Problem to delete employee', 'Success !!!');
            return redirect()->route('user.index');
        }

    }
    public function undoDelete($slug){
        $staff = User::where('slug',$slug)->first();
        if(!empty($staff)){
            $staff->is_deleted =0;
            $staff->save();
            toastr()->success('Employee activated successfully', 'Success !!!');
            return redirect()->route('user.index');
        }else{
            toastr()->error('Problem to activate employee', 'Oops !!!');
            return redirect()->route('user.index');
        }
    }
    //Other Functions
    public function changePassword(){
        return view('user.change-password');
    }
    public function changePasswordUpdate(Request $request){
        $this->validate($request, [
            'cpassword'=>'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if(Hash::check($request->cpassword ,Auth::User()->password )){
            $user = Auth::User();
            $user->password =bcrypt($request['password']);
            $user->save();
            return redirect()->route('home');
        }else{
        }
        return redirect()->back();
    }

    public function changePin(){
        return view('user.change-pin');
    }
    public function changePinUpdate(Request $request){
        $this->validate($request, [
            'cpassword'=>'required',
            'pin'=>'required|numeric|digits:4',
        ]);
        if(Hash::check($request->cpassword ,Auth::User()->password )){
            $user = Auth::User();
            $user->pin =bcrypt($request['pin']);
            $user->save();
        }else{
            return redirect()->back();
        }
        return redirect()->route('home');
    }

    public function getChangeHolidayForm(Request $request){
        $res['status']=false;
        $res['message']='';
        if($request->has('user_id')){
            $user=User::with('holidays')->find($request->user_id);
            $current_holiday=[];
            foreach($user->holidays as $holiday){
                $current_holiday[]=$holiday->day;
            }
            $res['status']=true;
            $res['view']= view('user.component.change-holiday',compact('user','current_holiday'))->render();
        }
        return json_encode($res);
    }

    public function updateHoliday(Request $request){

        $res['status']=false;
        $res['message']='';
        //Validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'holiday' => 'sometimes',
            'holiday.*' => 'numeric',

        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['message']=$errors->first();
        }else{
            $user= User::with('holidays')->find($request->user_id);
            $current_holidays=$user->holidays;
            $current_holiday_arr=[];
            foreach($current_holidays as $ch){
                $current_holiday_arr[]=$ch->day;
            }

            if($current_holiday_arr==$request->holiday){
                $res['message']='No Change';
            }else{
                if($request->has('holiday')){
                    $res['message']='New Change';
                    $previous_change=Change::where('user_id',$user->id)->where('status',1)->first();
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
                    $change_data['user_id']= $user->id;
                    $change_data['from']= Carbon::today();
                    $change=Change::create($change_data);


                    $data['user_id']=$user->id;
                    $data['change_id']=$change->id;
                    $data['active_from']=$change->from;

                    foreach($request->holiday as $holiday){
                        //Save new Holiday
                        $data['day']=$holiday;
                        UserHoliday::create($data);
                    }
                    $res['status']=true;


                }else{
                    $previous_change=Change::where('user_id',$user->id)->where('status',1)->first();
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
            //Create Change

            //Store Holiday


        }

        return json_encode($res);
    }

    public function getLeaveReport(Request $request){
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
            $user=User::where('id',$request->user_id)->with('leave_types')->first();
            $user_leave_types=[];
            $this_fiscal_year_start=Setting::where('key','fiscal-year-start')->first()->value;
            $this_fiscal_year_end=Setting::where('key','fiscal-year-end')->first()->value;
            $this_fiscal_year_start_year=date('Y');
            $this_fiscal_year_end_year=Carbon::now()->add(1,'year')->format('Y');
            $fiscal_year_start=Carbon::parse($this_fiscal_year_start_year.'-'.$this_fiscal_year_start);
            $fiscal_year_end=Carbon::parse($this_fiscal_year_end_year.'-'.$this_fiscal_year_end);
            $fiscal_year=[
                'this_start'=>Carbon::parse($this_fiscal_year_start_year.'-'.$this_fiscal_year_start)->format('Y-m-d'),
                'this_end'=>Carbon::parse($this_fiscal_year_end_year.'-'.$this_fiscal_year_end)->format('Y-m-d')
            ];
            foreach($user->leave_types as $user_leave_type){
                $total_leave=$user_leave_type->days;
                $leave_taken=Attendance::where('user_id',$user->id)
                                    ->where('is_leave',true)
                                    ->where('leave_type_id',$user_leave_type->leave_type->id)
                                    ->whereDate('date','>=',$fiscal_year_start)
                                    ->whereDate('date','<=',$fiscal_year_end)
                                    ->sum('leave_day');
                if($user->joined->gt($fiscal_year_start)){ //Partial leave
                    $unavailable_days = $user->joined->diffInDays($fiscal_year_start);
                    $total_days = $fiscal_year_end->diffInDays($fiscal_year_start);
                    $available_days=$total_days-$unavailable_days;
                    $available_percent=($available_days*100)/$total_days;
                    $available_leave=($available_percent/100)*$total_leave;
                    $user_leave_types[]=[
                        'name'=>$user_leave_type->leave_type->name,
                        'yearly'=>$available_leave,
                        'taken'=>$leave_taken,
                        'available'=>$available_leave-$leave_taken
                    ];
                }else{//100% holiday
                    $user_leave_types[]=[
                        'name'=>$user_leave_type->leave_type->name,
                        'yearly'=>$total_leave,
                        'taken'=>$leave_taken,
                        'available'=>$total_leave-$leave_taken
                    ];
                }
            }
            $res['view']= view('user.component.leave-report-modal',compact('user_leave_types','user','fiscal_year'))->render();
            $res['status']=true;
        }
        return json_encode($res);
    }

    public function uploadImage(Request $request){
        $userInfo = $request->all();
        $user=User::where('id',Auth::user()->id)->first();
        $folder_name='UserDocuments';
        //profile image update
        if($request->file('profile_image')==''){
            if($request->get('delete_profile_image')){
                $this->imageController->deleteImg($folder_name,$user->profile_image);
                $userInfo['profile_image'] = NULL;
            }else {
                $userInfo['profile_image'] = $user->profile_image;
            }
        }
        else{
            $this->imageController->deleteImg($folder_name,$user->profile_image);
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'profile_image', 500,500);
            $userInfo['profile_image']=$ImgName;
        }
        $user->update($userInfo);
        toastr()->success('Image uploaded successfully', 'Success !!!');
        return back();
    }

    public function upgradeSalary(Request $request){
        //Validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'salary' => 'required',
            'starting' => 'required'
        ]);

        $user= User::with('current_salary')->find($request->user_id);
        //Update Salary Table
        $data['user_id']=$request->user_id;
        $data['old_salary']=$user->current_salary->salary;
        $data['old_date']=$user->current_salary->from;
        if(isset($user->current_salary)){
            $user->current_salary->salary=$request->salary;
            $user->current_salary->from=Carbon::parse($request->starting)->format('Y-m-d');
            $user->current_salary->is_upgraded=true;
            $user->current_salary->update();
        }
        //Add Salary History
        $data['revised_date']=Carbon::parse($request->starting)->format('Y-m-d');
        $data['revised_salary']=$request->salary;
        $last_revision = SalaryHistory::where('user_id', $request->user_id)->max('revision_count');
        $data['revision_count']=$last_revision + 1;
        SalaryHistory::create($data);

        toastr()->success('Salary Increased', 'Success !!!');
        return redirect()->route('user.index');
    }
    public function profile(){
        $data['details']=$this->getUserWiseDetails(Auth::user()->id);

        return view('user.profile')->with($data);
    }
    public function companySetting(){
        $setting = CompanySetting::where('id', 1)->first();
        return $setting;
    }
    public function getOtherDetails(){
        $data['employeeId'] = EmployeeId::latest()->first()->employee_id;
        $data['genders'] = Gender::all();
        $data['roles'] = Role::where('is_active', 'yes')->where('is_default', 0)->get();
        $data['provinces'] = Province::where('is_active', 'yes')->get();
        $data['districts'] = District::where('is_active', 'yes')->orderBy('name')->get();
        $data['departments']=Department::where('is_default',false)->get();
        $data['blood_groups']=BloodGroup::all();
        $data['religions']=Religion::all();
        $data['designations']=Designation::where('is_default',false)->get();
        $data['contract_types']=ContractType::where('is_active', 'yes')->get();
        $data['leave_types']=LeaveType::all();
        $data['top_level_users']= User::whereIn('role', [2,4])->orderBy('role')->get();
        return $data;
    }
    public function getUserWiseDetails($id)
    {
        $data['user']=$u=User::where('id',$id)->first();
        $data['province']=$province = Province::where('id', $u->province)->first()->name;
        $data['temp_province']=$temp_province = Province::where('id', $u->temp_province)->first()->name;
        $data['district']=$district = District::where('id', $u->district)->first()->name;
        $data['temp_district']=$temp_district = District::where('id', $u->temp_district)->first()->name;
        $data['address'] = $u->address .','. $u->municipality_vdc ;
        $data['temp_address'] = $u->temp_address .','. $u->temp_municipality_vdc ;
        return $data;
    }
}
