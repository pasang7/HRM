<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Models\Project;
use App\Models\Setting;
use App\Models\IncomeTax;
use App\Models\Attendance;
use App\Models\SalaryPaid;
use App\Models\SalaryPaymentDetail;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
class ReportsController extends Controller
{
    public function staffWiseIndex(){
        $active_staff=User::where('department_id','!=',1)->get();
        $users=[];
        foreach($active_staff as $staff){
            $reports = $staff->reports;
            $working_hour = 0;
                if($reports->count()>0){
                    foreach($reports as $report){
                        $working_hour=$working_hour + $report->time;
                    }
                }
            $users[]=[
                'name'=>$staff->name,
                'slug'=>$staff->slug,
                'id'=>$staff->id,
                'worked_time'=>$working_hour,

            ];
        }
        return view('reports.staff-wise.index')->with('users',$users);
    }

    public function staffWiseReport($slug){
        $user=User::where('slug',$slug)->first();
        if($user){
            if(request()->filter){
                $actual_filter=explode(" - ", request()->filter);

                $startdate= explode("/", $actual_filter[0]);
                $enddate= explode("/", $actual_filter[1]);

                $startdate_in_eng=Carbon::create($startdate[2], $startdate[0], $startdate[1],0,0,0);
                $enddate_in_eng=Carbon::create($enddate[2], $enddate[0], $enddate[1],0,0,0);

                $reports = Report::where('user_id',$user->id)
                ->whereDate('date','>=',$startdate_in_eng)
                ->whereDate('date','<=',$enddate_in_eng)
                ->orderBy('date','desc')
                ->get();
            }
            else{
                $reports = Report::where('user_id',$user->id)
                ->orderBy('date','desc')
                ->get();
            }
            $staffs=User::all();
            $slug =$user->slug;
            return view('reports.staff-wise.report')
                ->with('user',$user)
                ->with('staffs',$staffs)
                ->with('slug',$slug)
                ->with('reports',$reports)
                ->with('filter', request()->filter);
        }else{
            return redirect()->back();
        }
    }

    public function projectWiseIndex(){
        $active_projects=Project::all();
        $projects=[];
        foreach($active_projects as $project){
            $reports = $project->reports;
            $working_hour = 0;
                if($reports->count()>0){
                    foreach($reports as $report){
                        $working_hour=$working_hour + $report->time;
                    }
                }
            $projects[]=[
                'name'=>$project->name,
                'slug'=>$project->slug,
                'id'=>$project->id,
                'worked_time'=>$working_hour,

            ];
        }
        return view('reports.project-wise.index')->with('projects',$projects);
    }

    public function projectWiseReport($slug){
        $project=Project::where('slug',$slug)->first();
        if($project){
            if(request()->filter){
                $actual_filter=explode(" - ", request()->filter);

                $startdate= explode("/", $actual_filter[0]);
                $enddate= explode("/", $actual_filter[1]);

                $startdate_in_eng=Carbon::create($startdate[2], $startdate[0], $startdate[1],0,0,0);
                $enddate_in_eng=Carbon::create($enddate[2], $enddate[0], $enddate[1],0,0,0);

                $reports = Report::where('project_id',$project->id)
                                ->whereDate('date','>=',$startdate_in_eng)
                                ->whereDate('date','<=',$enddate_in_eng)
                                ->orderBy('date','desc')
                                ->get();
            }
            else{
                $reports = Report::where('project_id',$project->id)
                ->orderBy('date','desc')
                ->get();
            }




            $projects=Project::all();
            $slug =$project->slug;
            return view('reports.project-wise.report')
                ->with('project',$project)
                ->with('projects',$projects)
                ->with('slug',$slug)
                ->with('reports',$reports)
                ->with('filter', request()->filter);
        }else{
            return redirect()->back();
        }
    }

    public function salarySheet(Request $request){
        if(request()->year && request()->month){
            $date = Carbon::createFromDate(request()->year, request()->month, date('d'));
            $month=request()->month;
            $year =request()->year;
        }else{
            $date= Carbon::createFromDate(date('Y'), date('m'),date('d'));
            $month= date('m');
            $year = date('Y');
        }
        $is_salary_paid=SalaryPaid::whereMonth('date',$month)->whereYear('date',$year)->first();

        $is_real=false;
        if($is_salary_paid){ //Real Salary
            $is_real=true;

            $details=$is_salary_paid->details;

            $data=[];
            foreach($details as $detail){
                $user=$detail->user;
                $data[]=[
                    'name'=>$user->name,
                    'joined'=>$user->joined->format('Y-m-d'),
                    'tds'=>number_format($detail->tds, 2),
                    'expected_yearly_income'=>number_format($detail->expected_yearly_income, 2),
                    'salary'=>number_format($detail->salary, 2),
                    'work_days'=>$detail->total_days,
                    'present_days'=>$detail->present_days,
                    'paid_leave'=>$detail->paid_leave,
                    'unpaid_leave'=>$detail->unpaid_leave,
                    'payable_days'=>$detail->payable_days,
                    'gross_salary_payable'=>number_format($detail->gross_salary_payable, 2),
                    'incentives'=>0,
                    'total_payable'=>number_format($detail->total_payable, 2),
                    'net_payable'=>number_format($detail->net_payable, 2)
                ];
            }
        }else{ //Expected
            $is_real=false;
            $firstDay = Carbon::createFromDate($year, $month,1);
            $midDay = Carbon::createFromDate($year, $month,1)->add(14,'days');
            $lastDay = Carbon::createFromDate($year, $month,1)->endofMonth();
            $users=User::with('current_salary')
                        ->where('department_id','!=',1)
                        ->get();

            $data=[];
            foreach($users as $user){
                $joined_month=$user->joined->format('m');
                $joined_year=$user->joined->format('Y');
                $allow=false;
                $is_joined_this_month=false;
                if($joined_year<=$year){
                    if($joined_year<$year){
                        $allow=true;
                    }else{
                        if($joined_month<=$month){
                            $allow=true;
                            if($joined_month=$month){
                                $is_joined_this_month=true;
                            }
                        }
                    }
                }
                if($allow){
                    if($user->current_salary){
                        $monthly_salary=$user->current_salary->salary;
                        $yearly_income_data=self::getYearlyIncome($user);
                        $yearly_income= $yearly_income_data['income'];
                        $income_tax=IncomeTax::with('slab')
                                                ->where('is_married',$user->is_married)
                                                ->where('gender',$user->gender==0?1:0)
                                                ->first();
                        $tax_amount=self::calculateTax($income_tax,$yearly_income, $user);
                        $total_working_days=0;
                        $total_worked_days=0;

                        $paid_leave=0;
                        $unpaid_leave=0;
                        $holiday=0;
                        $absent=0;

                        $period = CarbonPeriod::create($firstDay, $lastDay);
                        if($is_joined_this_month){
                            $period = CarbonPeriod::create($user->joined, $lastDay);
                        }
                        foreach($period as $key=>$date){
                            $attendance=Attendance::where('user_id',$user->id)
                                                    ->whereDate('date',$date)
                                                    ->first();

                            if($attendance){
                                if($attendance->is_holiday){
                                    $holiday+=1;
                                }elseif($attendance->is_leave){
                                    $total_working_days+=1;
                                    if($attendance->leave->is_paid){
                                        $paid_leave+=$attendance->leave_day;
                                        if($attendance->clockin!=null){
                                            $total_worked_days+=0.5;
                                        }

                                    }else{
                                        $unpaid_leave+=$attendance->leave_day;

                                    }

                                }elseif($attendance->is_absent){
                                    $total_working_days+=1;
                                    $absent+=1;
                                }else{
                                    $total_working_days+=1;
                                    $total_worked_days+=1;
                                }
                            }else{
                                $total_working_days+=1;
                            }

                        }
                        $total_payable_days=$total_worked_days+$paid_leave;
                        $per=($total_payable_days*100)/$total_working_days;

                        if($is_joined_this_month){
                            // $day_in_month= cal_days_in_month(CAL_GREGORIAN, $month, $year);
                            $day_in_month= 30;
                            $day_rate=$monthly_salary/$day_in_month;
                            $gross_salary_payable=$day_rate*($total_payable_days+$holiday);
                        }else{
                            $gross_salary_payable=($per*$monthly_salary)/100;
                        }
                        $incentive=0;
                        $total_payable=$gross_salary_payable+$incentive;
                        $data[]=[
                            'name'=>$user->name,
                            'joined'=>$user->joined->format('Y-m-d'),
                            'tds'=>number_format($tax_amount, 2),
                            'expected_yearly_income'=>number_format($yearly_income, 2),
                            'salary'=>number_format($monthly_salary, 2),
                            'work_days'=>$total_working_days,
                            'present_days'=>$total_worked_days,
                            'paid_leave'=>$paid_leave,
                            'unpaid_leave'=>$unpaid_leave,
                            'payable_days'=>$total_payable_days,
                            'absent'=>$absent,
                            'gross_salary_payable'=>number_format($gross_salary_payable, 2),
                            'incentives'=>$incentive,
                            'total_payable'=>number_format($total_payable, 2),
                            'net_payable'=>number_format($total_payable-$tax_amount, 2),
                            'yearly_income_breakdown'=>$yearly_income_data['breakdown']
                        ];
                    }
                }
            }

        }
        //For next
        if($month==12){
            $next=[
                'year'=>$year+1,
                'month'=>1
            ];
        }else{
            $next=[
                'year'=>$year,
                'month'=>$month+1
            ];
        }

        //For Prev
        if($month==1){
            $prev=[
                'year'=>$year-1,
                'month'=>12
            ];
        }else{
            $prev=[
                'year'=>$year,
                'month'=>$month-1
            ];
        }

        //For Prev
        $current=[
            'year'=>$year,
            'month'=>$month
        ];

        if($year==date('Y') && $month==date('m')){
            $next['show']=false;
        }else{
            $next['show']=true;
        }
        return view('reports.salary-sheet')
            ->with('data',$data)
            ->with('current',$current)
            ->with('prev',$prev)
            ->with('next',$next)
            ->with('is_real',$is_real);
    }

    public static function getYearlyIncome($user){
        $this_fiscal_year_start=Setting::where('key','fiscal-year-start')->first()->value;
        $this_fiscal_year_end=Setting::where('key','fiscal-year-end')->first()->value;
        $y=date('Y')-1;
        $fiscal_year_start=Carbon::parse($y.'-'.$this_fiscal_year_start);
        $fiscal_year_end=Carbon::parse(date('Y').'-'.$this_fiscal_year_end);

        $joined_date=$user->joined;
        $yearly_income=0;
        $yearly_income_breakdown=[];
        if($fiscal_year_start->gt($joined_date)){  //Joined before fiscal year
            $interval = DateInterval::createFromDateString('1 month');
            $period = new DatePeriod($fiscal_year_start, $interval, $fiscal_year_end);
            $yearly_income=0;
            foreach($period as $dt) {
                $m=$dt->format( "m" );
                $y=$dt->format( "Y" );
                $this_month_income=0;
                $is_salary_paid=SalaryPaymentDetail::where('user_id',$user->id)->whereMonth('date',$m)->whereYear('date',$y)->first();
                if($is_salary_paid){
                    $this_month_income=$is_salary_paid->gross_salary_payable;
                }else{
                    $this_month_income=$user->current_salary->salary;
                }
                $yearly_income+=$this_month_income;
                $yearly_income_breakdown[$y."-".$m]=  $this_month_income;
            }
        }else{//Joined in the middle of fiscal year
            $year=$user->joined->format('Y');
            $month=$user->joined->format('m');
            $monthly_salary=$user->current_salary->salary;
            $interval = DateInterval::createFromDateString('1 month');
            $joined_month=Carbon::createFromDate($year, $month,1);
            $period1 = new CarbonPeriod($joined_month, $interval, $fiscal_year_end);
            foreach($period1 as $key=>$dt) {
                $m=$dt->format( "m" );
                $y=$dt->format( "Y" );
                $this_month_income=0;
                if($key==0 || $key==$period1->count()-1){ //First or Last Month (Partial Salary)
                    if($key==0){ //First Month
                        $is_salary_paid=SalaryPaymentDetail::where('user_id',$user->id)->whereMonth('date',$m)->whereYear('date',$y)->first();
                        if($is_salary_paid){
                            $this_month_income=$is_salary_paid->gross_salary_payable;
                        }else{
                            $joined_date=$user->joined;
                            $total_day_in_joined_month=cal_days_in_month(CAL_GREGORIAN, $joined_date->format('m'), $joined_date->format('Y'));
                            $payable_days=$total_day_in_joined_month-$joined_date->format('d');
                            $day_salary_rate=$monthly_salary/$total_day_in_joined_month;
                            $this_month_income=$day_salary_rate*$payable_days;
                        }
                    }else{  //Last Month
                        $is_salary_paid=SalaryPaymentDetail::where('user_id',$user->id)->whereMonth('date',$m)->whereYear('date',$y)->first();
                        if($is_salary_paid){
                            $this_month_income=$is_salary_paid->gross_salary_payable;
                        }else{
                            $first_day_of_fiscal_year_end=Carbon::createFromDate($y, $m,1);
                            $total_day_in_last_month=cal_days_in_month(CAL_GREGORIAN, $m, $y);
                            $payable_days=$fiscal_year_end->format('d');
                            $day_salary_rate=$monthly_salary/$total_day_in_last_month;
                            $this_month_income=$day_salary_rate*$payable_days;
                        }
                    }
                    // dd($total_day_in_joined_month);
                    // echo "First or Last";
                }else{ //Full Salary
                    $is_salary_paid=SalaryPaymentDetail::where('user_id',$user->id)->whereMonth('date',$m)->whereYear('date',$y)->first();
                    if($is_salary_paid){
                        $this_month_income=$is_salary_paid->gross_salary_payable;
                    }else{ //Calculate salary from joined date to end of that month
                        $this_month_income=$monthly_salary;
                    }
                }
                $yearly_income+=$this_month_income;
                $yearly_income_breakdown[$y."-".$m]=  $this_month_income;
            }
        }
        $res=[
            'income'=>$yearly_income,
            'breakdown'=>$yearly_income_breakdown,
        ];

                // dd($res);
        return $res;
    }

    public static function calculateTax($income_tax,$yearly_income, $user){
        $taxes=[];
        foreach($income_tax->slab as $slab){
            $taxes[]=[
                'amount'=>$slab->amount,
                'percent'=>$slab->percent,
                'taxable_amount'=>0,
                'remaining_amount'=>0,
                'tds'=>0,
            ];
        }
        $total_income=$yearly_income;

        $count=count($taxes);
        foreach($taxes as $key=>$tax){
            if($total_income<=$tax['amount']){
                $taxes[$key]['taxable_amount']=$total_income;
                $taxes[$key]['remaining_amount']=0;
                break;
            }else{
                if($key+1==$count){
                    $taxes[$key]['taxable_amount']=$total_income;
                    $taxes[$key]['remaining_amount']=0;
                }else{
                    $taxes[$key]['taxable_amount']=$tax['amount'];
                    $taxes[$key]['remaining_amount']=$total_income-$tax['amount'];
                    $total_income-=$tax['amount'];
                }
            }
        }
        // dump($taxes);
        //Actual Calculation
        $annual_tds=0;

        foreach($taxes as $key=>$tax){
                $this_tds=($tax['percent']/100)*$tax['taxable_amount'];
                $annual_tds+=$this_tds;
                $taxes[$key]['tds']=$this_tds;
        }
        //Actual Calculation
        $this_fiscal_year_start=Setting::where('key','fiscal-year-start')->first()->value;
        $this_fiscal_year_end=Setting::where('key','fiscal-year-end')->first()->value;

        $y=date('Y')-1;
        $fiscal_year_start=Carbon::parse($y.'-'.$this_fiscal_year_start);
        $fiscal_year_end=Carbon::parse(date('Y').'-'.$this_fiscal_year_end);

        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($fiscal_year_start, $interval, $fiscal_year_end);
        $paid_tds=0;
        $payable_month=12;
        foreach($period as $dt) {
            $month=$dt->format( "m" );
            $year=$dt->format( "Y" );
            $is_salary_paid=SalaryPaymentDetail::where('user_id',$user->id)->whereMonth('date',$month)->whereYear('date',$year)->first();
            if($is_salary_paid){
                $payable_month-=1;
                $paid_tds+=$is_salary_paid->tds;
            }
        }
        return ($annual_tds-$paid_tds)/$payable_month;
    }

    public function paySalary(Request $request){
        if($request->has('year') && $request->has('month')){
            $date = Carbon::createFromDate(request()->year, request()->month, date('d'));
            $month=request()->month;
            $year =request()->year;
            $is_salary_paid=SalaryPaid::whereMonth('date',$month)->whereYear('date',$year)->first();
            $is_real=false;
            if($is_salary_paid){
                $is_real=true;
                toastr()->warning('Already Done', 'Oops!!');
                return redirect()->back();
            }else{
                $is_real=false;
                $new_salary_paid=SalaryPaid::create([
                    'date'=>$date,
                    'paid_at'=>Carbon::today()
                ]);

                $firstDay = Carbon::createFromDate($year, $month,1);
                $midDay = Carbon::createFromDate($year, $month,1)->add(14,'days');
                $lastDay = Carbon::createFromDate($year, $month,1)->endofMonth();
                $users=User::with('current_salary')
                            ->where('department_id','!=',1)
                            ->get();
                $data=[];
                foreach($users as $user){
                    if($user->current_salary){
                        $monthly_salary=$user->current_salary->salary;
                        $yearly_income=self::getYearlyIncome($user)['income'];
                        $income_tax=IncomeTax::with('slab')->where('is_married', $user->is_married)
                                               ->where('gender', $user->gender==0?1:0)
                                               ->first();
                        $tax_amount=self::calculateTax($income_tax, $yearly_income, $user);
                        $total_working_days=0;
                        $total_worked_days=0;

                        $paid_leave=0;
                        $holiday=0;

                        $unpaid_leave=0;
                        //Here
                            $joined_month=$user->joined->format('m');
                            $joined_year=$user->joined->format('Y');
                            $allow=false;
                            $is_joined_this_month=false;
                            if($joined_year<=$year){
                                if($joined_year<$year){
                                    $allow=true;
                                }else{
                                    if($joined_month<=$month){
                                        $allow=true;
                                        if($joined_month=$month){
                                            $is_joined_this_month=true;

                                        }
                                    }
                                }
                            }
                        //HEre
                        if($allow){
                            $period = CarbonPeriod::create($firstDay, $lastDay);
                            if($is_joined_this_month){
                                $period = CarbonPeriod::create($user->joined, $lastDay);
                            }

                            foreach($period as $key=>$date){

                                $attendance=Attendance::where('user_id',$user->id)
                                                        ->whereDate('date',$date)
                                                        ->first();
                                if($attendance){
                                    if($attendance->is_holiday){
                                      $holiday+=1;
                                    }elseif($attendance->is_leave){
                                        $total_working_days+=1;
                                        if($attendance->leave->is_paid){
                                            $paid_leave+=$attendance->leave_day;
                                            if($attendance->clockin!=null){
                                                $total_worked_days+=0.5;
                                            }

                                        }else{
                                            $unpaid_leave+=$attendance->leave_day;

                                        }

                                    }elseif($attendance->is_absent){
                                        $total_working_days+=1;

                                    }else{
                                        $total_working_days+=1;
                                        $total_worked_days+=1;
                                    }
                                }else{
                                    $total_working_days+=1;
                                }

                            }
                            $total_payable_days=$total_worked_days+$paid_leave;

                            $total_payable_days=$total_worked_days+$paid_leave;
                            $per=($total_payable_days*100)/$total_working_days;

                            if($is_joined_this_month){
                                $day_in_month= cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                $day_rate=$monthly_salary/$day_in_month;
                                $gross_salary_payable=$day_rate*($total_payable_days+$holiday);
                            }else{
                                $gross_salary_payable=($per*$monthly_salary)/100;
                            }
                            $incentive=0;
                            $total_payable=$gross_salary_payable+$incentive;
                            $data[]=[
                                'user_id'=>$user->id,
                                'name'=>$user->name,
                                'joined'=>$user->joined->format('Y-m-d'),
                                'tds'=>$tax_amount,
                                'expected_yearly_income'=>$yearly_income,
                                'salary'=>$monthly_salary,
                                'work_days'=>$total_working_days,
                                'present_days'=>$total_worked_days,
                                'paid_leave'=>$paid_leave,
                                'unpaid_leave'=>$unpaid_leave,
                                'payable_days'=>$total_payable_days,
                                'gross_salary_payable'=>$gross_salary_payable,
                                'incentives'=>$incentive,
                                'total_payable'=>$total_payable,
                                'net_payable'=>$total_payable-$tax_amount
                            ];
                        }

                    }
                }
                foreach($data as $salary){
                    SalaryPaymentDetail::create([
                        'user_id'=>$salary['user_id'],
                        'salary_paid_id'=>$new_salary_paid->id,
                        'date'=>$date,
                        'expected_yearly_income'=>$salary['expected_yearly_income'],
                        'salary'=>$salary['salary'],
                        'total_days'=>$salary['work_days'],
                        'present_days'=>$salary['present_days'],
                        'paid_leave'=>$salary['paid_leave'],
                        'unpaid_leave'=>$salary['unpaid_leave'],
                        'payable_days'=>$salary['payable_days'],
                        'gross_salary_payable'=>$salary['gross_salary_payable'],
                        'total_payable'=>$salary['total_payable'],
                        'tds'=>$salary['tds'],
                        'net_payable'=>$salary['net_payable']
                    ]);
                }
            }
        }
                //For next
                if($month==12){
                    $next=[
                        'year'=>$year+1,
                        'month'=>1
                    ];
                }else{
                    $next=[
                        'year'=>$year,
                        'month'=>$month+1
                    ];
                }

                //For Prev
                if($month==1){
                    $prev=[
                        'year'=>$year-1,
                        'month'=>12
                    ];
                }else{
                    $prev=[
                        'year'=>$year,
                        'month'=>$month-1
                    ];
                }

                //For Prev
                $current=[
                    'year'=>$year,
                    'month'=>$month
                ];

                if($year==date('Y') && $month==date('m')){
                    $next['show']=false;
                }else{
                    $next['show']=true;
                }
        // dd('done');


        return view('reports.salary-sheet',compact('data')) ->with('current',$current)
            ->with('prev',$prev)
            ->with('next',$next)
            ->with('is_real',$is_real);
    }
}
