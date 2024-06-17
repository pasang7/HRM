<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class SalaryPaid extends Model
{
    protected $fillable = [
       'salary_sheet_report_id', 'date', 'paid_at'
    ];
    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            if(Auth::user()){
                $model->created_by = Auth::user()->id;
            }else{
                $model->created_by = 1;
            }
        });
    }
    public function details(){
        return $this->hasMany('App\Models\SalaryPaidDetail','salary_paid_id','id');
        
    }
}
