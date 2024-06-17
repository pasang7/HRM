<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PayrollIncome extends Model
{
    protected $fillable = [
        'name','short_name','remarks','calculation_method','percent_rate','fixed_amount','status','is_assign','assign_status'
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
    public function users(){
        return $this->belongsToMany('App\Models\User', 'pivot_user_allowances', 'income_id', 'user_id')
        ->withPivot('percent_rate', 'amount');
    }
    public function getIncomeStatusAttribute(){
        if($this->is_active == 'yes'){
            return '<a href="javascript:void(0)" status="'.$this->is_active.'" onclick="changeStatus('.$this->id.')"><i class="fa fa-circle text-success"></i></a>';
        }else{
            return '<a href="javascript:void(0)"  status="'.$this->is_active.'" onclick="changeStatus('.$this->id.')"><i class="fa fa-circle text-danger"></i></a>';
        }
    }
}
