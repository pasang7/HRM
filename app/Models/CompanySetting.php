<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = [
        'is_new_setup','fiscal_year_start','fiscal_year_end','name','website','logo','address','phone','mobile','email',
        'min_leave_days_for_review','overtime','normal_overtime_rate','special_overtime_rate',
        'pf_facility', 'cit_facility', 'employee_pf_value','employer_pf_value','gratuity_value',
        'gratuity_facility', 'ssf_facility','bank_name','bank_branch','bank_contact',
        'day_in_month','month_in_year','working_hour','bonus','bonus_type','customize_amount','main_header_color','sec_header_color',
        'max_allow_time'
    ];
}
