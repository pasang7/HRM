<?php

namespace App\Http\Controllers;

use App\Models\PayrollIncome;
use App\Models\PivotUserAllowance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollSettingController extends Controller
{
    //Payroll Incomes Settings
    public function incomeIndex()
    {
        $data['incomes']= PayrollIncome::all();
        $data['staffs'] = User::where('department_id', '!=', 1)->get();

        return view('setting.payroll_income.index', $data);
    }
    public function incomeCreate()
    {
        return view('setting.payroll_income.create');
    }
    public function incomeStore(Request $request)
    {
        //validation
        $request->validate([
            'name' => 'required',
        ]);
        
        $payrollIncomeInfo=$request->all();
        if(PayrollIncome::create($payrollIncomeInfo)){
            toastr()->success('Allowance created.', 'Success !!!');
            return redirect()->route('payroll-setting.income');
        }
        toastr()->error('Failed to create allowance', 'Oops !!!');
        return redirect()->route('payroll-setting.income');
    }
    public function incomeEdit($id)
    {
        $data['income'] = PayrollIncome::find($id);
        return view('setting.payroll_income.edit', $data);
    }
    public function incomeUpdate(Request $request)
    {
        //validation
        $request->validate([
            'name' => 'required',
        ]);
        if($request->calculation_method == "percent"){
            $request->validate([
                'percent_rate' => 'required|numeric',
            ]);
        }
        
        $payrollIncomeInfo=$request->all();
        $payrollIncome=PayrollIncome::where('id',$request->get('id'))->first();
        if(!empty($payrollIncome)){
            $payrollIncome->update($payrollIncomeInfo);
            toastr()->success('Allowance updated.', 'Success !!!');
            return redirect()->route('payroll-setting.income');
        }
        toastr()->error('Failed to update allowance', 'Oops !!!');
        return redirect()->route('payroll-setting.income');
    }
    public function incomeAssignForm($id)
    {
        $data['income'] = PayrollIncome::find($id);
        $data['staffs'] = User::where('department_id', '!=', 1)->get();
        return view('setting.payroll_income.income_assign', $data);
    }
    public function showStaffwiseAllowance(Request $request){
        $income = PayrollIncome::where('id', $request->income_id)->first();
        $staff = User::where('id', $request->staff_id)->first();
        $allowance = $income->calculation_method=='percent' ? ($staff->current_salary->salary * $income->percent_rate)/100 : $income->fixed_amount ;
        $result='';
        $result .='<input type="text" style="margin-top:10px; " name="staff_allowance['.$request->staff_id.']" class="form-control" value="'.$allowance.'">';
        return response([
            'staffId' => $request->staff_id, 
            'result' => $result, 
        ]);
    }
    public function hideStaffwiseAllowance(Request $request){
        $income = PayrollIncome::where('id', $request->income_id)->first();
        $staff = User::where('id', $request->staff_id)->first();
        PivotUserAllowance::where('user_id', $staff->id)->where('income_id', $income->id)->delete();
        return response([
            'staffId' => $request->staff_id, 
        ]);
    }
    public function incomeAssign(Request $request)
    {
        //validation
        $request->validate([
            'income_id' => 'required',
            'assign_status' => 'required',
        ]);
        $incomeId = $request->get('income_id');
        $allowance = PayrollIncome::find($incomeId);
        $allowance->update([
            'is_assign' => 'yes',
            'assign_status' => $request->assign_status
        ]);
        $assigningUserInfo=$request->all();
        if($request->assign_status == "partial"){
            $request->validate([
                'user_id' => 'required',
            ]);
            $users = $request->get('user_id');
            if(!empty($users)){
                foreach($users as $userId){
                    $assigningUserInfo['income_id'] = $incomeId;
                    $assigningUserInfo['user_id'] = $userId;
                    if($allowance->calculation_method =="percent"){
                        $assigningUserInfo['percent_rate'] = $request->staff_allowance[$userId];
                    }else{
                        $assigningUserInfo['amount'] = $request->staff_allowance[$userId];
                    }
                    $assigningUserInfo['is_selected'] = 1;
                    PivotUserAllowance::create($assigningUserInfo);
                }
                toastr()->success('Allowance assigned.', 'Success !!!');
                return redirect()->route('payroll-setting.income');
            }
        }else{
            $assigningUsers=User::where('department_id','!=', 1)->get();
            if(!empty($assigningUsers)){
                foreach($assigningUsers as $assigningUser){
                    $assigningUserInfo['income_id'] = $incomeId;
                    $assigningUserInfo['user_id'] = $assigningUser->id;
                    $assigningUserInfo['percent_rate'] = $allowance->percent_rate;
                    $assigningUserInfo['amount'] = $allowance->fixed_amount;
                    $assigningUserInfo['is_selected'] = 1;
                    PivotUserAllowance::create($assigningUserInfo);
                }
                toastr()->success('Allowance assigned.', 'Success !!!');
                return redirect()->route('payroll-setting.income');
            }
        }
        toastr()->error('Failed to assigning allowance', 'Oops !!!');
        return redirect()->route('payroll-setting.income');
    }
    
    public function incomeAssignEditForm($id)
    {
        $data['income'] =$i= PayrollIncome::find($id);
        $data['selectedStaffIds'] =$data['income']->users->pluck('id')->toArray();
        $staffAllowanceArray[]='';
        foreach($data['income']->users as $staff){
            $staff->allowanceById($id);
            if($i->calculation_method == 'percent'){
                $staffAllowanceArray[$staff->id] = $staff->allowanceById($id)->pivot->percent_rate;
            }else{
                $staffAllowanceArray[$staff->id] = $staff->allowanceById($id)->pivot->amount;
            }
        }
        $data['staffAllow'] = $staffAllowanceArray;
        $data['selectedStaffAllowances'] = $data['income']->users->pluck('id')->toArray();
        $data['staffs'] = User::where('department_id', '!=', 1)->get();
        return view('setting.payroll_income.edit_income_assign', $data);
    }
    public function incomeAssignEdit(Request $request)
    {
        $incomeId = $request->get('income_id');
        $allowance = PayrollIncome::find($incomeId);
        $assigningUserInfo=$request->all();
        if($request->assign_status == "partial"){
            $users = $request->get('user_id');
            if(!empty($users)){
               $allowance->update([
                    'is_assign' => 'yes',
                    'assign_status' => $request->assign_status
                ]);
                foreach($users as $userId){
                    $assigningUserInfo['income_id'] = $incomeId;
                    $assigningUserInfo['user_id'] = $userId;
                    if($allowance->calculation_method =="percent"){
                        $assigningUserInfo['percent_rate'] = $request->staff_allowance[$userId];
                    }else{
                        $assigningUserInfo['amount'] = $request->staff_allowance[$userId];
                    }
                    $assigningUserInfo['is_selected'] = 1;
                    PivotUserAllowance::create($assigningUserInfo);
                }
                toastr()->success('Allowance updated.', 'Success !!!');
                return redirect()->route('payroll-setting.income');
            }else{
                $allowance->update([
                    'is_assign' => 'no',
                    'assign_status' => 'none'
                ]);
                toastr()->info('Allowance not assigned.', 'Success !!!');
                return redirect()->route('payroll-setting.income');
            }
        }else{
            $assigningUsers=User::where('department_id','!=', 1)->get();
            if(!empty($assigningUsers)){
               $allowance->update([
                    'is_assign' => 'yes',
                    'assign_status' => $request->assign_status
                ]);
                foreach($assigningUsers as $assigningUser){
                    $assigningUserInfo['income_id'] = $incomeId;
                    $assigningUserInfo['user_id'] = $assigningUser->id;
                    $assigningUserInfo['percent_rate'] = $allowance->percent_rate;
                    $assigningUserInfo['amount'] = $allowance->fixed_amount;
                    $assigningUserInfo['is_selected'] = 1;
                    PivotUserAllowance::create($assigningUserInfo);
                }
                toastr()->success('Allowance assigned.', 'Success !!!');
                return redirect()->route('payroll-setting.income');
            }
        }
        toastr()->error('Failed to assigning allowance', 'Oops !!!');
        return redirect()->route('payroll-setting.income');
    }
    
    public function statusChange(Request $request){
        $status = $request->get('status');
         if($status == 'active'){
           DB::table('payroll_incomes')->where('id', $request->get('id'))->update([
               'is_assign'=>'no',
               'assign_status'=>'none',
               'status' => 'in_active'
           ]);
           PivotUserAllowance::where('income_id', $request->get('id'))->truncate();
        }else{
            DB::table('payroll_incomes')->where('id', $request->get('id'))->update([
                'status' => 'active'
            ]);
        }
        return 1;
    }  

}
