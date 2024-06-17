<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryPaidDetail extends Model
{
    protected $fillable = [
        'user_id', 
        'salary_paid_id', 
        'salary_paid_date',
        'user_retire_date',
        'monthly_salary',  
        'annual_salary',
        'gratuity',
        'grossSalary',
        'cit',
        'totDep',
        'allowable_deduction',
        'total_deduction',
        'taxable_salary',
        'social_security_tax',
        'annual_rem_tax',
        'rebate',
        'total_annual_tax',
        'monthly_tds',
        'annually_employee_pf',
        'annually_employer_pf',
        'monthly_employee_pf',
        'monthly_employer_pf',
        'payable_salary',
        'citMonthly',
        'net_salary',
        'work_days', 
        'present_days', 
        'paid_leave', 
        'unpaid_leave', 
        'payable_days',
        'total_payable_days',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
        
    }
}
