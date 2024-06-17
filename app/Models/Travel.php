<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Travel extends Model
{
    protected $dates = [
        'from','to'
    ];
    protected $fillable = [
        'from', 'to', 'user_id', 'shift_id','program_name', 'place', 'purpose', 'travel_mode',
        'other_travel_mode','justification','accommodation_day','accommodation_per_diem','accommodation_total',
        'daily_allowance_day','daily_allowance_per_diem','daily_allowance_total','contingency_day','contingency_per_diem',
        'contingency_total','remarks','advance_taken','travel_plan','submitted_by','submitted_date','recommended_by','recommended_date',
        'approved_by','approved_date','is_accepted','is_rejected','is_reviewed','created_by','recommended_remarks','accepted_remarks'
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
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function recommendedUser(){
        return $this->belongsTo('App\Models\User', 'recommended_by');
    }
    public function approvedUser(){
        return $this->belongsTo('App\Models\User', 'approved_by');
    }
    public function shift(){
        return $this->belongsTo('App\Models\Shift','shift_id');
    }
}
