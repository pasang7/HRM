<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Leave extends Model
{
    protected $dates = [
        'from','to'
    ];
    protected $fillable = [
        'from', 'to', 'user_id', 'leave_type_id','leave_type_full', 'description',
        'status', 'is_paid','is_reviewed','is_accepted','is_rejected','shift_id', 'reviewed_by', 'reviewed_date', 'approved_by', 'approved_date'
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
    public function shift(){
        return $this->belongsTo('App\Models\Shift','shift_id');
    }
    public function type(){
        return $this->belongsTo('App\Models\LeaveType','leave_type_id');
    }
    public function reviewedUser(){
        return $this->belongsTo('App\Models\User', 'reviewed_by');
    }
    public function approveUser(){
        return $this->belongsTo('App\Models\User', 'approved_by');
    }


}
