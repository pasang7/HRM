<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\IncomeTax;
use App\Models\Attendance;
use App\Models\CompanySetting;
use App\Models\PayrollIncome;
use Illuminate\Validation\Rule;
use App\Models\SalaryPaid;
use App\Models\SalaryPaidDetail;
use App\Models\SalaryPaymentDetail;
use App\Models\SalarySheetReport;
use App\Models\SalarySheetReportDetail;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\DB;
use Validator;
class SalarySheetController extends Controller {
    public function sheetReports() {
        $data['setting'] = $this->companySetting();
        $data['current_year'] = $now = Carbon::now()->format('Y');
        $data['prev_year'] = Carbon::now()->subtract(1, 'years')->format('Y');
        $data['payroll_histories'] = SalarySheetReport::orderBy('month', 'desc')->get();
        return view('salary-sheet.generator', $data);
    }
    public function sheetGenerator(Request $request) {
        $sheet['year'] = $year = $request->year;
        $sheet['month'] = $month = $request->month;
        $messages = DB::select('SELECT * FROM salary_sheet_reports WHERE month='.$month.' AND year ='.$year);
        if(empty($messages)){
            $new_salary_sheet_report_id = SalarySheetReport::create($sheet);
            $companySetting = $this->companySetting();
            $allowances = PayrollIncome::with('users')->where('is_assign', 'yes')->where('status', 'active')->get();
                $firstDay = Carbon::createFromDate($year, $month, 1);
                $midDay = Carbon::createFromDate($year, $month, 1)->add(14, 'days');
                $lastDay = Carbon::createFromDate($year, $month, 1)->endofMonth();
                $users = User::with('current_salary', 'allowances')->where('department_id', '!=', 1)->where('is_deleted', 0)->get();
                $data = [];
                foreach ($users as $user){
                    $joined_month = $user->joined->format('m');
                    $joined_year = $user->joined->format('Y');
                    $is_joined_this_month = false;
                    if ($joined_year <= $year) {
                        if ($joined_year < $year) {
                            $allow = true;
                        } else {
                            if ($joined_month <= $month) {
                                $allow = true;
                                if ($joined_month = $month) {
                                    $is_joined_this_month = true;
                                }
                            }
                        }
                    }
                    $designation = $user->userDesignation->name;
                    if ($allow){
                        if ($user->current_salary) {
                            $basic_salary = $bs = $user->current_salary->salary;
                            $end = $this->getFiscalYearEnd();
                            $joinedDate = new DateTime($user->joined);
                            $gap = $this->getGap($joinedDate, $end);
                            //allowance
                            $given_allowances = 0;
                            $userAllowance = [];
                            $userAllowanceIds = $user->allowances->pluck('id')->toArray();
                            $year_amount='';
                            foreach ($allowances as $allowance) {
                                if (in_array($allowance->id, $userAllowanceIds)) {
                                    if ($allowance->calculation_method == "percent") {
                                        if ($allowance->assign_status == "all") {
                                            $amount = ($allowance->percent_rate * $bs) / 100;
                                            $year_amount = (($allowance->percent_rate * $bs) / 100) * $gap;
                                            $given_allowances+= $year_amount;
                                        } else {
                                            $singleAllowance = $user->allowances->where("id", $allowance->id)->first();
                                            $amount = ($singleAllowance->pivot->percent_rate * $bs) / 100;
                                            $year_amount = (($allowance->percent_rate * $bs) / 100) * $gap;
                                            $given_allowances+= $year_amount;
                                        }
                                    } else {
                                        if ($allowance->assign_status == "all") {
                                            $amount = $allowance->fixed_amount;
                                            $year_amount = ($allowance->fixed_amount) * $gap;
                                            $given_allowances+= $year_amount;
                                        } else {
                                            $singleAllowance = $user->allowances->where("id", $allowance->id)->first();
                                            $amount = $singleAllowance->pivot->amount;
                                            $year_amount = ($allowance->fixed_amount) * $gap;
                                            $given_allowances+= $year_amount;
                                        }
                                    }
                                } else {
                                    $amount = "0";
                                }
                                $userAllowance[] = number_format((float)$year_amount, 2, '.', '');
                                $monthlyUserAllowance[] = $amount;
                            }
                            // dump($given_allowances);
                            $annual_salary = 0;
                            if($user->current_salary->is_upgraded == 1){
                                $annual_salary = $this->getRevisedAnnualSalary($user->salary_histories) + $given_allowances;

                            }else{
                                $annual_salary = $this->getAnnualSalary($bs, $gap, $given_allowances);
                            }
                            //income
                            $annual_employee_pf = $annual_salary * $companySetting->employee_pf_value;
                            $gratuity = $annual_salary * $companySetting->gratuity_value;
                            $grossSalary = $annual_salary + $annual_employee_pf + $gratuity;
                            //deduction
                            $an_employer_pf = $annual_salary * $companySetting->employer_pf_value;
                            $cit = $user->cit_amount * $gap;
                            $totDep = $an_employer_pf + $cit + $gratuity;
                            $allowable_deduction = $totDep > 300000 ? 300000 : $totDep;
                            //Insurance Section if any
                            $insurance = 0;
                            $total_deduction = $allowable_deduction + $insurance;
                            $taxable_salary = $grossSalary - $total_deduction;
                            //calculation of SS Tax (1%)
                            $social_security_tax = '';
                            if ($user->is_married == 0) {
                                if ($taxable_salary <= 400000) {
                                    $social_security_tax = $taxable_salary * 0.01;
                                } else {
                                    $social_security_tax = 4000;
                                }
                                $taxable_salary_after = $taxable_salary - 400000;
                            } else {
                                if ($taxable_salary <= 450000) {
                                    $social_security_tax = $taxable_salary * 0.01;
                                } else {
                                    $social_security_tax = 4500;
                                }
                                $taxable_salary_after = $taxable_salary - 450000;
                            }
                            //rem tds calculation
                            $income_tax = IncomeTax::with('slab')->where('is_married', $user->is_married)->where('gender', $user->gender)->first();
                            $monthly_rem_tds = self::calculateTax($income_tax, $taxable_salary_after, $user);
                            $remTax = number_format((float)$monthly_rem_tds * $gap, 2, '.', '');
                            $annual_rem_tax = $remTax > 0 ? $remTax : 0;
                            $rebate = $this->getRebate($user->gender, $annual_rem_tax);
                            $total_annual_tax = $social_security_tax + $annual_rem_tax - $rebate;
                            $monthly_tds = $total_annual_tax / $gap;
                            $rounded_monthly_tds = number_format((float)$monthly_tds, 2, '.', '');
                            $monthly_employee_pf = $bs * $companySetting->employee_pf_value;
                            $monthly_employer_pf = $bs * $companySetting->employer_pf_value;
                            //present days
                            $total_working_days = 0;
                            $total_worked_days = 0;
                            $paid_leave = 0;
                            $unpaid_leave = 0;
                            $holiday = 0;
                            $absent = 0;
                            $period = CarbonPeriod::create($firstDay, $lastDay);
                            if ($is_joined_this_month) {
                                $period = CarbonPeriod::create($user->joined, $lastDay);
                            }
                            foreach ($period as $key => $date) {
                                $attendance = Attendance::with('leave')->where('user_id', $user->id)->whereDate('date', $date)->first();
                                if ($attendance) {
                                    if ($attendance->is_holiday) {
                                        $holiday+= 1;
                                    } elseif ($attendance->is_leave) {
                                        $total_working_days+= 1;
                                        if ($attendance->is_paid) {
                                            $paid_leave+= $attendance->leave_day;
                                            if ($attendance->clockin != null) {
                                                $total_worked_days+= 0.5;
                                            }
                                        } else {
                                            $unpaid_leave+= $attendance->leave_day;
                                        }
                                    } elseif ($attendance->is_absent) {
                                        $total_working_days+= 1;
                                        $absent+= 1;
                                    } else {
                                        $total_working_days+= 1;
                                        $total_worked_days+= 1;
                                    }
                                } else {
                                    $total_working_days+= 1;
                                }
                            }
                            if ($is_joined_this_month) {
                                $default_department_holiday = 0;
                                $day_count = $lastDay->diffInDays($user->joined) + 1;
                                foreach ($user->department->holidays as $defaultHoliday) {
                                    $i = 0;
                                    $joinedDay = $user->joined->format('d');
                                    while ($i < $day_count) // Loop will work firstDay to the lastDay date
                                    {
                                        $date = $year . '/' . $month . '/' . $joinedDay; //format date
                                        $get_name = date('l', strtotime($date)); //get week day
                                        $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
                                        if ($day_name == $defaultHoliday->day_name) {
                                            $default_department_holiday++;
                                        }
                                        $i++;
                                        $joinedDay++;
                                    }
                                }
                                $total_payable_days = $total_worked_days + $default_department_holiday + $paid_leave;
                            } else {
                                $total_payable_days = $companySetting->day_in_month - $unpaid_leave;
                            }
                            //monthly salary calculation
                            $payable_salary = number_format((float)$bs * ($total_payable_days / $companySetting->day_in_month), 2, '.', '');
                            $cutPF = $payable_salary * $companySetting->employee_pf_value;
                            $citMonthly = $user->cit_amount ? $user->cit_amount : 0;
                            $net_salary = $payable_salary - $cutPF - $citMonthly - $monthly_tds;
                            $rounded_net_salary = number_format((float)$net_salary, 2, '.', '');
                            $data[] = [
                            'salary_sheet_report_id'=>$new_salary_sheet_report_id->id, 
                            'user_id' => $user->id, 
                            'name' => $user->name, 
                            'gender' => $user->gender == 0 ? 'Female' : 'Male', 
                            'designation' => $designation, 
                            'basic_salary' => $basic_salary,
                            'joinedDate' => $joinedDate,
                            'end_date'=>$end->format('m/d/Y'),
                            // 'gap'=>$gap,
                            'allowances'=>$allowances,
                            'userAllowance' => $userAllowance, 
                            'annual_salary' => $annual_salary, 
                            'gratuity' => $gratuity, 
                            'grossSalary' => $grossSalary, 
                            'cit' => $cit, 
                            'totDep' => $totDep, 
                            'allowable_deduction' => $allowable_deduction, 
                            'total_deduction' => $total_deduction, 
                            'taxable_salary' => $taxable_salary, 
                            'social_security_tax' => $social_security_tax, 
                            'annual_rem_tax' => $annual_rem_tax, 
                            'rebate' => $rebate, 
                            'total_annual_tax' => $total_annual_tax, 
                            'monthly_tds' => $rounded_monthly_tds, 
                            'annual_employee_pf' => $annual_employee_pf, 
                            'monthly_employee_pf' => $monthly_employee_pf, 
                            'monthly_employer_pf' => $monthly_employer_pf, 
                            'an_employer_pf' => $an_employer_pf, 
                            'payable_salary' => $payable_salary, 
                            'citMonthly' => $citMonthly, 
                            'net_salary' => $rounded_net_salary, 
                            'work_days' => $companySetting->day_in_month, 
                            'present_days' => $total_worked_days, 
                            'paid_leave' => $paid_leave, 
                            'unpaid_leave' => $unpaid_leave, 
                            'payable_days' => $total_payable_days, 
                            'absent' => $absent, 
                            'total_payable_days' => $total_payable_days, ];
                        }
                    }
                }
                foreach ($data as $salary) {
                    SalarySheetReportDetail::create([
                        'salary_sheet_report_id' => $salary['salary_sheet_report_id'],
                        'user_id' => $salary['user_id'],  
                        'user_retire_date' => $salary['end_date'], 
                        'monthly_salary' => $salary['basic_salary'], 
                        'annual_salary' => $salary['annual_salary'], 
                        'gratuity' => $salary['gratuity'], 
                        'grossSalary' => $salary['grossSalary'], 
                        'cit' => $salary['cit'], 
                        'totDep' => $salary['totDep'], 
                        'allowable_deduction' => $salary['allowable_deduction'], 
                        'total_deduction' => $salary['total_deduction'], 
                        'taxable_salary' => $salary['taxable_salary'], 
                        'social_security_tax' => $salary['social_security_tax'], 
                        'annual_rem_tax' => $salary['annual_rem_tax'], 
                        'rebate' => $salary['rebate'], 
                        'total_annual_tax' => $salary['total_annual_tax'], 
                        'monthly_tds' => $salary['monthly_tds'], 
                        'annually_employee_pf' => $salary['annual_employee_pf'], 
                        'annually_employer_pf' => $salary['an_employer_pf'], 
                        'monthly_employee_pf' => $salary['monthly_employee_pf'], 
                        'monthly_employer_pf' => $salary['monthly_employer_pf'], 
                        'payable_salary' => $salary['payable_salary'], 
                        'citMonthly' => $salary['citMonthly'], 
                        'net_salary' => $salary['net_salary'], 
                        'work_days' => $salary['work_days'], 
                        'present_days' => $salary['present_days'], 
                        'paid_leave' => $salary['paid_leave'], 
                        'unpaid_leave' => $salary['unpaid_leave'], 
                        'payable_days' => $salary['payable_days'], 
                        'total_payable_days' => $salary['total_payable_days']
                    ]);
                }
            toastr()->success('Sheet Generated', 'Success !!!');
            return redirect()->route('salary.sheet.report', $new_salary_sheet_report_id->id);
        }else{
        toastr()->error('Sheet already generated.', 'Oops !!!');

            return back();

        }
    }
    public function sheetReportDetails($id)
    {
        $data['companySetting']=$this->companySetting();
        $data['sheetReport'] =$w = SalarySheetReport::find($id);
        return view('salary-sheet.details', $data);
    }

    public function salarySheet($year, $month, $new_salary_sheet_report_id) {
        $companySetting = $this->companySetting();
        $allowances = PayrollIncome::with('users')->where('status', 'active')->get();
        // if (request()->year && request()->month){
        //     $date = Carbon::createFromDate(request()->year, request()->month, date('d'));
        //     $month = request()->month;
        //     $year = request()->year;
        // }else{
        //     $date = Carbon::createFromDate(date('Y'), date('m'), date('d'));
        //     $month = date('m');
        //     $year = date('Y');
        // }
        $is_salary_paid = SalaryPaid::whereMonth('date', $month)->whereYear('date', $year)->first();
        $is_real = false;
        if ($is_salary_paid){ //Real Salary
            $is_real = true;
            $details = $is_salary_paid->details;
            $data = [];
            foreach ($details as $detail) {
                $user = $detail->user;
                $userAllowance = [];
                $data[] = ['name' => $user->name, 'gender' => $user->gender == 0 ? 'Female' : 'Male', 'designation' => $user->userDesignation->name, 'basic_salary' => number_format($detail->monthly_salary, 2), 'joinedDate' => date('m/d/Y', strtotime($user->joined)), 'userAllowance' => $detail->userAllowance, 'annual_salary' => $detail->annual_salary, 'gratuity' => $detail->gratuity, 'grossSalary' => $detail->grossSalary, 'cit' => $detail->cit, 'totDep' => $detail->totDep, 'allowable_deduction' => $detail->allowable_deduction, 'total_deduction' => $detail->total_deduction, 'taxable_salary' => $detail->taxable_salary, 'social_security_tax' => $detail->social_security_tax, 'annual_rem_tax' => $detail->annual_rem_tax, 'rebate' => $detail->rebate, 'total_annual_tax' => $detail->total_annual_tax, 'monthly_tds' => $detail->monthly_tds, 'annual_employee_pf' => $detail->annually_employee_pf, 'monthly_employee_pf' => $detail->monthly_employee_pf, 'an_employer_pf' => $detail->annually_employer_pf, 'payable_salary' => $detail->payable_salary, 'citMonthly' => $detail->citMonthly, 'net_salary' => $detail->net_salary, 'work_days' => $detail->work_days, 'present_days' => $detail->total_worked_days, 'paid_leave' => $detail->paid_leave, 'unpaid_leave' => $detail->unpaid_leave, 'payable_days' => $detail->total_payable_days, 'absent' => $detail->absent, 'total_payable_days' => $detail->total_payable_days, 'userAllowance' => $userAllowance];
            }
        }else{ //Expected
            $is_real = false;
            $firstDay = Carbon::createFromDate($year, $month, 1);
            $midDay = Carbon::createFromDate($year, $month, 1)->add(14, 'days');
            $lastDay = Carbon::createFromDate($year, $month, 1)->endofMonth();
            $users = User::with('current_salary', 'allowances')->where('department_id', '!=', 1)->get();
            $data = [];
            foreach ($users as $user){
                $joined_month = $user->joined->format('m');
                $joined_year = $user->joined->format('Y');
                $is_joined_this_month = false;
                if ($joined_year <= $year) {
                    if ($joined_year < $year) {
                        $allow = true;
                    } else {
                        if ($joined_month <= $month) {
                            $allow = true;
                            if ($joined_month = $month) {
                                $is_joined_this_month = true;
                            }
                        }
                    }
                }
                $designation = $user->userDesignation->name;
                if ($allow){
                    if ($user->current_salary) {
                        $basic_salary = $bs = $user->current_salary->salary;
                        $end = $this->getFiscalYearEnd();
                        $joinedDate = new DateTime($user->joined);
                        $gap = $this->getGap($joinedDate, $end);
                        //allowance
                        $given_allowances = 0;
                        $userAllowance = [];
                        $userAllowanceIds = $user->allowances->pluck('id')->toArray();
                        foreach ($allowances as $allowance) {
                            if (in_array($allowance->id, $userAllowanceIds)) {
                                if ($allowance->calculation_method == "percent") {
                                    if ($allowance->assign_status == "all") {
                                        $amount = ($allowance->percent_rate * $bs) / 100;
                                        $year_amount = (($allowance->percent_rate * $bs) / 100) * $gap;
                                        $given_allowances+= $year_amount;
                                    } else {
                                        $singleAllowance = $user->allowances->where("id", $allowance->id)->first();
                                        $amount = ($singleAllowance->pivot->percent_rate * $bs) / 100;
                                        $year_amount = (($allowance->percent_rate * $bs) / 100) * $gap;
                                        $given_allowances+= $year_amount;
                                    }
                                } else {
                                    if ($allowance->assign_status == "all") {
                                        $amount = $allowance->fixed_amount;
                                        $year_amount = ($allowance->fixed_amount) * $gap;
                                        $given_allowances+= $year_amount;
                                    } else {
                                        $singleAllowance = $user->allowances->where("id", $allowance->id)->first();
                                        $amount = $singleAllowance->pivot->amount;
                                        $year_amount = ($allowance->fixed_amount) * $gap;
                                        $given_allowances+= $year_amount;
                                    }
                                }
                            } else {
                                $amount = "0";
                            }
                            $userAllowance[] = number_format((float)$year_amount, 2, '.', '');
                            $monthlyUserAllowance[] = $amount;
                        }
                        // dump($given_allowances);
                        $annual_salary = $this->getAnnualSalary($bs, $gap, $given_allowances);
                        //income
                        $annual_employee_pf = $annual_salary * $companySetting->employee_pf_value;
                        $gratuity = $annual_salary * $companySetting->gratuity_value;
                        $grossSalary = $annual_salary + $annual_employee_pf + $gratuity;
                        //deduction
                        $an_employer_pf = $annual_salary * $companySetting->employer_pf_value;
                        $cit = $user->cit_amount * $gap;
                        $totDep = $an_employer_pf + $cit + $gratuity;
                        $allowable_deduction = $totDep > 300000 ? 300000 : $totDep;
                        //Insurance Section if any
                        $insurance = 0;
                        $total_deduction = $allowable_deduction + $insurance;
                        $taxable_salary = $grossSalary - $total_deduction;
                        //calculation of SS Tax (1%)
                        $social_security_tax = '';
                        if ($user->is_married == 0) {
                            if ($taxable_salary <= 400000) {
                                $social_security_tax = $taxable_salary * 0.01;
                            } else {
                                $social_security_tax = 4000;
                            }
                            $taxable_salary_after = $taxable_salary - 400000;
                        } else {
                            if ($taxable_salary <= 450000) {
                                $social_security_tax = $taxable_salary * 0.01;
                            } else {
                                $social_security_tax = 4500;
                            }
                            $taxable_salary_after = $taxable_salary - 450000;
                        }
                        //rem tds calculation
                        $income_tax = IncomeTax::with('slab')->where('is_married', $user->is_married)->where('gender', $user->gender)->first();
                        $monthly_rem_tds = self::calculateTax($income_tax, $taxable_salary_after, $user);
                        $remTax = number_format((float)$monthly_rem_tds * $gap, 2, '.', '');
                        $annual_rem_tax = $remTax > 0 ? $remTax : 0;
                        $rebate = $this->getRebate($user->gender, $annual_rem_tax);
                        $total_annual_tax = $social_security_tax + $annual_rem_tax - $rebate;
                        $monthly_tds = $total_annual_tax / $gap;
                        $rounded_monthly_tds = number_format((float)$monthly_tds, 2, '.', '');
                        $monthly_employee_pf = $bs * $companySetting->employee_pf_value;
                        $monthly_employer_pf = $bs * $companySetting->employer_pf_value;
                        //present days
                        $total_working_days = 0;
                        $total_worked_days = 0;
                        $paid_leave = 0;
                        $unpaid_leave = 0;
                        $holiday = 0;
                        $absent = 0;
                        $period = CarbonPeriod::create($firstDay, $lastDay);
                        if ($is_joined_this_month) {
                            $period = CarbonPeriod::create($user->joined, $lastDay);
                        }
                        foreach ($period as $key => $date) {
                            $attendance = Attendance::with('leave')->where('user_id', $user->id)->whereDate('date', $date)->first();
                            if ($attendance) {
                                if ($attendance->is_holiday) {
                                    $holiday+= 1;
                                } elseif ($attendance->is_leave) {
                                    $total_working_days+= 1;
                                    if ($attendance->is_paid) {
                                        $paid_leave+= $attendance->leave_day;
                                        if ($attendance->clockin != null) {
                                            $total_worked_days+= 0.5;
                                        }
                                    } else {
                                        $unpaid_leave+= $attendance->leave_day;
                                    }
                                } elseif ($attendance->is_absent) {
                                    $total_working_days+= 1;
                                    $absent+= 1;
                                } else {
                                    $total_working_days+= 1;
                                    $total_worked_days+= 1;
                                }
                            } else {
                                $total_working_days+= 1;
                            }
                        }
                        if ($is_joined_this_month) {
                            $default_department_holiday = 0;
                            $day_count = $lastDay->diffInDays($user->joined) + 1;
                            foreach ($user->department->holidays as $defaultHoliday) {
                                $i = 0;
                                $joinedDay = $user->joined->format('d');
                                while ($i < $day_count) // Loop will work firstDay to the lastDay date
                                {
                                    $date = $year . '/' . $month . '/' . $joinedDay; //format date
                                    $get_name = date('l', strtotime($date)); //get week day
                                    $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
                                    if ($day_name == $defaultHoliday->day_name) {
                                        $default_department_holiday++;
                                    }
                                    $i++;
                                    $joinedDay++;
                                }
                            }
                            $total_payable_days = $total_worked_days + $default_department_holiday + $paid_leave;
                        } else {
                            $total_payable_days = $companySetting->day_in_month - $unpaid_leave;
                        }
                        // dump($total_payable_days);
                        // $total_payable_days=$total_worked_days+$paid_leave;
                        //monthly salary calculation
                        $payable_salary = number_format((float)$bs * ($total_payable_days / $companySetting->day_in_month), 2, '.', '');
                        $cutPF = $payable_salary * $companySetting->employee_pf_value;
                        $citMonthly = $user->cit_amount ? $user->cit_amount : 0;
                        $net_salary = $payable_salary - $cutPF - $citMonthly - $monthly_tds;
                        $rounded_net_salary = number_format((float)$net_salary, 2, '.', '');
                        $data[] = [
                            'salary_sheet_report_id'=>$new_salary_sheet_report_id->id, 
                            'user_id' => $user->id, 
                            'name' => $user->name, 
                            'gender' => $user->gender == 0 ? 'Female' : 'Male', 
                            'designation' => $designation, 
                            'basic_salary' => $basic_salary,
                        'joinedDate' => $joinedDate->format('m/d/Y'),
                        'end_date'=>$end->format('m/d/Y'),
                        // 'gap'=>$gap,
                        'userAllowance' => $userAllowance, 
                        'annual_salary' => $annual_salary, 
                        'gratuity' => $gratuity, 
                        'grossSalary' => $grossSalary, 
                        'cit' => $cit, 
                        'totDep' => $totDep, 
                        'allowable_deduction' => $allowable_deduction, 
                        'total_deduction' => $total_deduction, 
                        'taxable_salary' => $taxable_salary, 
                        'social_security_tax' => $social_security_tax, 
                        'annual_rem_tax' => $annual_rem_tax, 
                        'rebate' => $rebate, 
                        'total_annual_tax' => $total_annual_tax, 
                        'monthly_tds' => $rounded_monthly_tds, 
                        'annual_employee_pf' => $annual_employee_pf, 
                        'monthly_employee_pf' => $monthly_employee_pf, 
                        'monthly_employer_pf' => $monthly_employer_pf, 
                        'an_employer_pf' => $an_employer_pf, 
                        'payable_salary' => $payable_salary, 
                        'citMonthly' => $citMonthly, 
                        'net_salary' => $rounded_net_salary, 
                        'work_days' => $companySetting->day_in_month, 
                        'present_days' => $total_worked_days, 
                        'paid_leave' => $paid_leave, 
                        'unpaid_leave' => $unpaid_leave, 
                        'payable_days' => $total_payable_days, 
                        'absent' => $absent, 
                        'total_payable_days' => $total_payable_days, ];
                    }
                }
            }
            foreach ($data as $salary) {
                SalarySheetReportDetail::create([
                    'salary_sheet_report_id' => $salary['salary_sheet_report_id'],
                    'user_id' => $salary['user_id'],  
                    'user_retire_date' => $salary['end_date'], 
                    'monthly_salary' => $salary['basic_salary'], 
                    'annual_salary' => $salary['annual_salary'], 
                    'gratuity' => $salary['gratuity'], 
                    'grossSalary' => $salary['grossSalary'], 
                    'cit' => $salary['cit'], 
                    'totDep' => $salary['totDep'], 
                    'allowable_deduction' => $salary['allowable_deduction'], 
                    'total_deduction' => $salary['total_deduction'], 
                    'taxable_salary' => $salary['taxable_salary'], 
                    'social_security_tax' => $salary['social_security_tax'], 
                    'annual_rem_tax' => $salary['annual_rem_tax'], 
                    'rebate' => $salary['rebate'], 
                    'total_annual_tax' => $salary['total_annual_tax'], 
                    'monthly_tds' => $salary['monthly_tds'], 
                    'annually_employee_pf' => $salary['annual_employee_pf'], 
                    'annually_employer_pf' => $salary['an_employer_pf'], 
                    'monthly_employee_pf' => $salary['monthly_employee_pf'], 
                    'monthly_employer_pf' => $salary['monthly_employer_pf'], 
                    'payable_salary' => $salary['payable_salary'], 
                    'citMonthly' => $salary['citMonthly'], 
                    'net_salary' => $salary['net_salary'], 
                    'work_days' => $salary['work_days'], 
                    'present_days' => $salary['present_days'], 
                    'paid_leave' => $salary['paid_leave'], 
                    'unpaid_leave' => $salary['unpaid_leave'], 
                    'payable_days' => $salary['payable_days'], 
                    'total_payable_days' => $salary['total_payable_days']
                ]);
            }
        }
        //For next
        // if ($month == 12) {
        //     $next = ['year' => $year + 1, 'month' => 1];
        // } else {
        //     $next = ['year' => $year, 'month' => $month + 1];
        // }
        // //For Prev
        // if ($month == 1) {
        //     $prev = ['year' => $year - 1, 'month' => 12];
        // } else {
        //     $prev = ['year' => $year, 'month' => $month - 1];
        // }
        // //For Prev
        // $current = ['year' => $year, 'month' => $month];
        // if ($year == date('Y') && $month == date('m')) {
        //     $next['show'] = false;
        // } else {
        //     $next['show'] = true;
        // }
        return view('salary-sheet.index')->with('data', $data)->with('is_real', $is_real)->with('companySetting', $companySetting)->with('allowances', $allowances);
    }
    public function paySalary(Request $request) {
        $companySetting = $this->companySetting();
        $allowances = PayrollIncome::with('users')->where('status', 'active')->get();
        if ($request->has('year') && $request->has('month')) {
            $date = Carbon::createFromDate(request()->year, request()->month, date('d'));
            $month = request()->month;
            $year = request()->year;
            $is_salary_paid = SalaryPaid::whereMonth('date', $month)->whereYear('date', $year)->first();
            $is_real = false;
            if ($is_salary_paid) {
                $is_real = true;
                toastr()->warning('Already Done', 'Oops!!');
                return redirect()->back();
            } else {
                $is_real = false;
                $new_salary_paid = SalaryPaid::create(['date' => $date, 'paid_at' => Carbon::today() ]);
                $firstDay = Carbon::createFromDate($year, $month, 1);
                $midDay = Carbon::createFromDate($year, $month, 1)->add(14, 'days');
                $lastDay = Carbon::createFromDate($year, $month, 1)->endofMonth();
                $users = User::with('current_salary')->where('department_id', '!=', 1)->get();
                $data = [];
                foreach ($users as $user) {
                    if ($user->current_salary) {
                        $basic_salary = $bs = $user->current_salary->salary;
                        $end = $this->getFiscalYearEnd();
                        $joinedDate = new DateTime($user->joined);
                        $gap = $this->getGap($joinedDate, $end);
                        $given_allowances = 0;
                        $userAllowance = [];
                        // $all_incomes = $users->pluck('id')->toArray();
                        // foreach ($user->allowances as $allowance) {
                        //     if($allowance->is_assign == 'yes'){
                        //                 if($allowance->calculation_method == 'percent') {
                        //                     $amount = ($allowance->pivot->percent_rate * $bs) / 100;
                        //                 }elseif($allowance->calculation_method == 'amount'){
                        //                     $amount = $allowance->pivot->amount;
                        //                 }
                        //                 else{
                        //                     $amount = 0;
                        //                 }
                        //                 $userAllowance[] = $amount;
                        //                 $given_allowances += $amount;
                        //                 }
                        // }
                        $annual_salary = $bs * $gap + $given_allowances;
                        //income
                        $annual_employee_pf = $annual_salary * $companySetting->employee_pf_value;
                        $gratuity = $annual_salary * $companySetting->gratuity_value;
                        $grossSalary = $annual_salary + $annual_employee_pf + $gratuity;
                        //deduction
                        $an_employer_pf = $annual_salary * $companySetting->employer_pf_value;
                        $cit = $user->cit_amount * $gap;
                        $totDep = $an_employer_pf + $cit + $gratuity;
                        $allowable_deduction = $totDep > 300000 ? 300000 : $totDep;
                        //Insurance Section if any
                        $insurance = 0;
                        $total_deduction = $allowable_deduction + $insurance;
                        $taxable_salary = $grossSalary - $total_deduction;
                        //calculation of SS Tax (1%)
                        $social_security_tax = '';
                        if ($user->is_married == 0) {
                            if ($taxable_salary <= 400000) {
                                $social_security_tax = $taxable_salary * 0.01;
                            } else {
                                $social_security_tax = 4000;
                            }
                            $taxable_salary_after = $taxable_salary - 400000;
                        } else {
                            if ($taxable_salary <= 450000) {
                                $social_security_tax = $taxable_salary * 0.01;
                            } else {
                                $social_security_tax = 4500;
                            }
                            $taxable_salary_after = $taxable_salary - 450000;
                        }
                        //rem tds calculation
                        $income_tax = IncomeTax::with('slab')->where('is_married', $user->is_married)->where('gender', $user->gender)->first();
                        $monthly_rem_tds = self::calculateTax($income_tax, $taxable_salary_after, $user);
                        $remTax = number_format((float)$monthly_rem_tds * $gap, 2, '.', '');
                        $annual_rem_tax = $remTax > 0 ? $remTax : 0;
                        $rebate = $this->getRebate($user->gender, $annual_rem_tax);
                        $total_annual_tax = $social_security_tax + $annual_rem_tax - $rebate;
                        $monthly_tds = $total_annual_tax / $gap;
                        $rounded_monthly_tds = number_format((float)$monthly_tds, 2, '.', '');
                        $monthly_employee_pf = $bs * $companySetting->employee_pf_value;
                        $monthly_employer_pf = $bs * $companySetting->employer_pf_value;
                        // $yearly_income=self::getYearlyIncome($user)['income'];
                        $total_working_days = 0;
                        $total_worked_days = 0;
                        $paid_leave = 0;
                        $unpaid_leave = 0;
                        $holiday = 0;
                        $absent = 0;
                        //Here
                        $joined_month = $user->joined->format('m');
                        $joined_year = $user->joined->format('Y');
                        $allow = false;
                        $is_joined_this_month = false;
                        if ($joined_year <= $year) {
                            if ($joined_year < $year) {
                                $allow = true;
                            } else {
                                if ($joined_month <= $month) {
                                    $allow = true;
                                    if ($joined_month = $month) {
                                        $is_joined_this_month = true;
                                    }
                                }
                            }
                        }
                        //HEre
                        if ($allow) {
                            $period = CarbonPeriod::create($firstDay, $lastDay);
                            if ($is_joined_this_month) {
                                $period = CarbonPeriod::create($user->joined, $lastDay);
                            }
                            foreach ($period as $key => $date) {
                                $attendance = Attendance::with('leave')->where('user_id', $user->id)->whereDate('date', $date)->first();
                                if ($attendance) {
                                    if ($attendance->is_holiday) {
                                        $holiday+= 1;
                                    } elseif ($attendance->is_leave) {
                                        $total_working_days+= 1;
                                        if ($attendance->is_paid) {
                                            $paid_leave+= $attendance->leave_day;
                                            if ($attendance->clockin != null) {
                                                $total_worked_days+= 0.5;
                                            }
                                        } else {
                                            $unpaid_leave+= $attendance->leave_day;
                                        }
                                    } elseif ($attendance->is_absent) {
                                        $total_working_days+= 1;
                                        $absent+= 1;
                                    } else {
                                        $total_working_days+= 1;
                                        $total_worked_days+= 1;
                                    }
                                } else {
                                    $total_working_days+= 1;
                                }
                            }
                            if ($is_joined_this_month) {
                                $default_department_holiday = 0;
                                $day_count = $lastDay->diffInDays($user->joined) + 1;
                                foreach ($user->department->holidays as $defaultHoliday) {
                                    $i = 0;
                                    $joinedDay = $user->joined->format('d');
                                    while ($i < $day_count) // Loop will work firstDay to the lastDay date
                                    {
                                        $date = $year . '/' . $month . '/' . $joinedDay; //format date
                                        $get_name = date('l', strtotime($date)); //get week day
                                        $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
                                        if ($day_name == $defaultHoliday->day_name) {
                                            $default_department_holiday++;
                                        }
                                        $i++;
                                        $joinedDay++;
                                    }
                                }
                                $total_payable_days = $total_worked_days + $default_department_holiday + $paid_leave;
                            } else {
                                $total_payable_days = $companySetting->day_in_month - $unpaid_leave;
                            }
                            // dump($total_payable_days);
                            // $total_payable_days=$total_worked_days+$paid_leave;
                            //monthly salary calculation
                            $payable_salary = number_format((float)$bs * ($total_payable_days / $companySetting->day_in_month), 2, '.', '');
                            $cutPF = $payable_salary * $companySetting->employee_pf_value;
                            $citMonthly = $user->cit_amount ? $user->cit_amount : 0;
                            $net_salary = $payable_salary - $cutPF - $citMonthly - $monthly_tds;
                            $rounded_net_salary = number_format((float)$net_salary, 2, '.', '');
                            $data[] = [
                                'user_id' => $user->id, 
                                'name' => $user->name, 
                                'gender' => $user->gender == 0 ? 'Female' : 'Male', 
                                'designation' => $user->userDesignation->name, 
                                'basic_salary' => $basic_salary, 
                                'end_date' => $end->format('m/d/Y'), 
                                'joinedDate' => $joinedDate->format('m/d/Y'), 
                                'gap' => $gap, 
                                'userAllowance' => $userAllowance, 
                                'annual_salary' => $annual_salary, 
                                'gratuity' => $gratuity, 
                                'grossSalary' => $grossSalary, 
                                'cit' => $cit, 
                                'totDep' => $totDep, 
                                'allowable_deduction' => $allowable_deduction, 
                                'total_deduction' => $total_deduction, 
                                'taxable_salary' => $taxable_salary, 
                                'social_security_tax' => $social_security_tax, 
                                'annual_rem_tax' => $annual_rem_tax, 
                                'rebate' => $rebate, 
                                'total_annual_tax' => $total_annual_tax, 
                                'monthly_tds' => $rounded_monthly_tds, 
                                'annual_employee_pf' => $annual_employee_pf, 'monthly_employee_pf' => $monthly_employee_pf, 'monthly_employer_pf' => $monthly_employer_pf, 'an_employer_pf' => $an_employer_pf, 'payable_salary' => $payable_salary, 'citMonthly' => $citMonthly, 'net_salary' => $rounded_net_salary, 'work_days' => $companySetting->day_in_month, 'present_days' => $total_worked_days, 'paid_leave' => $paid_leave, 'unpaid_leave' => $unpaid_leave, 'payable_days' => $total_payable_days, 'absent' => $absent, 'total_payable_days' => $total_payable_days, ];
                        }
                    }
                }
                // dd($data);
                foreach ($data as $salary) {
                    SalaryPaidDetail::create(['user_id' => $salary['user_id'], 'salary_paid_id' => $new_salary_paid->id, 'salary_paid_date' => $date, 'user_retire_date' => $salary['end_date'], 'monthly_salary' => $salary['basic_salary'], 'annual_salary' => $salary['annual_salary'], 'gratuity' => $salary['gratuity'], 'grossSalary' => $salary['grossSalary'], 'cit' => $salary['cit'], 'totDep' => $salary['totDep'], 'allowable_deduction' => $salary['allowable_deduction'], 'total_deduction' => $salary['total_deduction'], 'taxable_salary' => $salary['taxable_salary'], 'social_security_tax' => $salary['social_security_tax'], 'annual_rem_tax' => $salary['annual_rem_tax'], 'rebate' => $salary['rebate'], 'total_annual_tax' => $salary['total_annual_tax'], 'monthly_tds' => $salary['monthly_tds'], 'annually_employee_pf' => $salary['annual_employee_pf'], 'annually_employer_pf' => $salary['an_employer_pf'], 'monthly_employee_pf' => $salary['monthly_employee_pf'], 'monthly_employer_pf' => $salary['monthly_employer_pf'], 'payable_salary' => $salary['payable_salary'], 'citMonthly' => $salary['citMonthly'], 'net_salary' => $salary['net_salary'], 'work_days' => $salary['work_days'], 'present_days' => $salary['present_days'], 'paid_leave' => $salary['paid_leave'], 'unpaid_leave' => $salary['unpaid_leave'], 'payable_days' => $salary['payable_days'], 'total_payable_days' => $salary['total_payable_days']]);
                }
            }
        }
        //For next
        if ($month == 12) {
            $next = ['year' => $year + 1, 'month' => 1];
        } else {
            $next = ['year' => $year, 'month' => $month + 1];
        }
        //For Prev
        if ($month == 1) {
            $prev = ['year' => $year - 1, 'month' => 12];
        } else {
            $prev = ['year' => $year, 'month' => $month - 1];
        }
        //For Prev
        $current = ['year' => $year, 'month' => $month];
        if ($year == date('Y') && $month == date('m')) {
            $next['show'] = false;
        } else {
            $next['show'] = true;
        }
        // dd('done');
        return view('salary-sheet.index')->with('data', $data)->with('current', $current)->with('prev', $prev)->with('next', $next)->with('is_real', $is_real)->with('companySetting', $companySetting)->with('allowances', $allowances);
    }
    public static function getYearlyIncome($user) {
        $companySetting = CompanySetting::find(1);
        $this_fiscal_year_start = Setting::where('key', 'fiscal-year-start')->first()->value;
        $this_fiscal_year_end = Setting::where('key', 'fiscal-year-end')->first()->value;
        $y = date('Y') - 1;
        $fiscal_year_start = Carbon::parse($y . '-' . $this_fiscal_year_start);
        $fiscal_year_end = Carbon::parse(date('Y') . '-' . $this_fiscal_year_end);
        $joined_date = $user->joined;
        $yearly_income = 0;
        $yearly_income_breakdown = [];
        if ($fiscal_year_start->gt($joined_date)) { //Joined before fiscal year
            $interval = DateInterval::createFromDateString('1 month');
            $period = new DatePeriod($fiscal_year_start, $interval, $fiscal_year_end);
            $yearly_income = 0;
            foreach ($period as $dt) {
                $m = $dt->format("m");
                $y = $dt->format("Y");
                $this_month_income = 0;
                $is_salary_paid = SalaryPaymentDetail::where('user_id', $user->id)->whereMonth('date', $m)->whereYear('date', $y)->first();
                if ($is_salary_paid) {
                    $this_month_income = $is_salary_paid->gross_salary_payable;
                } else {
                    $this_month_income = $user->current_salary->salary;
                }
                $yearly_income+= $this_month_income;
                $yearly_income_breakdown[$y . "-" . $m] = $this_month_income;
            }
        } else { //Joined in the middle of fiscal year
            $year = $user->joined->format('Y');
            $month = $user->joined->format('m');
            $monthly_salary = $user->current_salary->salary;
            $interval = DateInterval::createFromDateString('1 month');
            $joined_month = Carbon::createFromDate($year, $month, 1);
            $period1 = new CarbonPeriod($joined_month, $interval, $fiscal_year_end);
            foreach ($period1 as $key => $dt) {
                $m = $dt->format("m");
                $y = $dt->format("Y");
                $this_month_income = 0;
                if ($key == 0 || $key == $period1->count() - 1) { //First or Last Month (Partial Salary)
                    if ($key == 0) { //First Month
                        $is_salary_paid = SalaryPaymentDetail::where('user_id', $user->id)->whereMonth('date', $m)->whereYear('date', $y)->first();
                        if ($is_salary_paid) {
                            $this_month_income = $is_salary_paid->gross_salary_payable;
                        } else {
                            $joined_date = $user->joined;
                            // $total_day_in_joined_month=cal_days_in_month(CAL_GREGORIAN, $joined_date->format('m'), $joined_date->format('Y'));
                            $total_day_in_joined_month = $companySetting->day_in_month;
                            // $payable_days=$total_day_in_joined_month-$joined_date->format('d');
                            $payable_days = $total_day_in_joined_month - $joined_date->format('d');
                            $day_salary_rate = $monthly_salary / $companySetting->day_in_month;
                            $this_month_income = $day_salary_rate * $payable_days;
                        }
                    } else { //Last Month
                        $is_salary_paid = SalaryPaymentDetail::where('user_id', $user->id)->whereMonth('date', $m)->whereYear('date', $y)->first();
                        if ($is_salary_paid) {
                            $this_month_income = $is_salary_paid->gross_salary_payable;
                        } else {
                            $first_day_of_fiscal_year_end = Carbon::createFromDate($y, $m, 1);
                            // $total_day_in_last_month=cal_days_in_month(CAL_GREGORIAN, $m, $y);
                            $total_day_in_last_month = $companySetting->day_in_month;
                            $payable_days = $fiscal_year_end->format('d');
                            $day_salary_rate = $monthly_salary / $total_day_in_last_month;
                            $this_month_income = $day_salary_rate * $payable_days;
                        }
                    }
                    // dd($total_day_in_joined_month);
                    // echo "First or Last";
                    
                } else { //Full Salary
                    $is_salary_paid = SalaryPaymentDetail::where('user_id', $user->id)->whereMonth('date', $m)->whereYear('date', $y)->first();
                    if ($is_salary_paid) {
                        $this_month_income = $is_salary_paid->gross_salary_payable;
                    } else { //Calculate salary from joined date to end of that month
                        $this_month_income = $monthly_salary;
                    }
                }
                $yearly_income+= $this_month_income;
                $yearly_income_breakdown[$y . "-" . $m] = $this_month_income;
            }
        }
        $res = ['income' => $yearly_income, 'breakdown' => $yearly_income_breakdown, ];
        // dd($res);
        return $res;
    }
    public static function calculateTax($income_tax, $yearly_income, $user) {
        $taxes = [];
        foreach ($income_tax->slab as $slab) {
            $taxes[] = ['amount' => $slab->amount, 'percent' => $slab->percent, 'taxable_amount' => 0, 'remaining_amount' => 0, 'tds' => 0, ];
        }
        $total_income = $yearly_income;
        $count = count($taxes);
        foreach ($taxes as $key => $tax) {
            if ($total_income <= $tax['amount']) {
                $taxes[$key]['taxable_amount'] = $total_income;
                $taxes[$key]['remaining_amount'] = 0;
                break;
            } else {
                if ($key + 1 == $count) {
                    $taxes[$key]['taxable_amount'] = $total_income;
                    $taxes[$key]['remaining_amount'] = 0;
                } else {
                    $taxes[$key]['taxable_amount'] = $tax['amount'];
                    $taxes[$key]['remaining_amount'] = $total_income - $tax['amount'];
                    $total_income-= $tax['amount'];
                }
            }
        }
        // dump($taxes);
        //Actual Calculation
        $annual_tds = 0;
        foreach ($taxes as $key => $tax) {
            $this_tds = ($tax['percent'] / 100) * $tax['taxable_amount'];
            $annual_tds+= $this_tds;
            $taxes[$key]['tds'] = $this_tds;
        }
        //Actual Calculation
        $this_fiscal_year_start = Setting::where('key', 'fiscal-year-start')->first()->value;
        $this_fiscal_year_end = Setting::where('key', 'fiscal-year-end')->first()->value;
        $y = date('Y') - 1;
        $fiscal_year_start = Carbon::parse($y . '-' . $this_fiscal_year_start);
        $fiscal_year_end = Carbon::parse(date('Y') . '-' . $this_fiscal_year_end);
        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($fiscal_year_start, $interval, $fiscal_year_end);
        $paid_tds = 0;
        $payable_month = 12;
        foreach ($period as $dt) {
            $month = $dt->format("m");
            $year = $dt->format("Y");
            $is_salary_paid = SalaryPaymentDetail::where('user_id', $user->id)->whereMonth('date', $month)->whereYear('date', $year)->first();
            if ($is_salary_paid) {
                $payable_month-= 1;
                $paid_tds+= $is_salary_paid->tds;
            }
        }
        return ($annual_tds - $paid_tds) / $payable_month;
    }
    public function companySetting() {
        $companySetting = CompanySetting::find(1);
        return $companySetting;
    }
    public function getFiscalYearEnd() {
        $fy_end = Setting::where('key', 'fiscal-year-end')->first()->value;
        $fiscal_year_end = Carbon::parse(date('Y') . '-' . $fy_end);
        return $fiscal_year_end;
    }
    public function getGap($joinedDate, $end) {
        $act_gap = round((($end->diff($joinedDate))->format('%a')) / 30);
        $gap = $act_gap > 12 ? 12 : $act_gap;
        return $gap;
    }
    public function getAnnualSalary($bs, $gap, $allowances) {
        $annualSalary = $bs * $gap + $allowances;
        return $annualSalary;
    }
    public function getRevisedAnnualSalary($histories)
    {
       $sum =0;
       $i=1;
       foreach($histories as $history){
           if($i != count($histories)){
               $diff = $history->revised_date->diffInDays($history->old_date)/30;
               $sum += $history->old_salary * $diff;
           }else{
                $diff = $history->revised_date->diffInDays($history->old_date)/30;
                $sum += $history->old_salary * $diff;
                $newDiff = $this->getFiscalYearEnd()->diffInDays($history->revised_date)/30;
                $sum += $history->revised_salary * $newDiff;
           }
           $i++;
       }
       return $sum;
    }
    public function getRebate($gender, $annual_rem_tax) {
        if ($gender == 0) {
            $rebate = $annual_rem_tax * 0.1;
        } else {
            $rebate = 0;
        }
        return $rebate;
    }
}
