<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalarySheetReport extends Model
{
    protected $fillable=[
        'year', 'month'
    ];

    public function details(){
        return $this->hasMany('App\Models\SalarySheetReportDetail','salary_sheet_report_id','id');
        
    }
}
