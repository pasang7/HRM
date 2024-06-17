<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $dates = [
        'date'
    ];
    protected $fillable = [
        'is_holiday','holiday_id','holiday_type','is_absent','is_late','is_travel',
        'is_leave','leave_id','is_paid','leave_type_id','leave_day','user_id','date',
        'clockin','clockin_verification','clockout','clockout_verification','shift_id','remarks', 'reviewed_by',
        'actual_time', 'status'
    ];
    //Holiday Type
    //01->user
    //10->department
    //11->custom
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function leave(){
        return $this->belongsTo('App\Models\AcceptedLeave','leave_id');
    }
    public function leave_type(){
        return $this->belongsTo('App\Models\LeaveType','leave_type_id');
    }
    public function holiday(){
        if($this->holiday_type==01){
            return $this->belongsTo('App\Models\UserHoliday','holiday_id','id');
        }
        else if($this->holiday_type==10){
            return $this->belongsTo('App\Models\DepartmentHoliday','holiday_id');
        }
    }
    public function setting(){
        return $this->belongsTo('App\Models\Setting');
    }
    public function shift(){
        return $this->belongsTo('App\Models\Shift');
    }
    public function absentedBy()
    {
        return $this->belongsTo('App\Models\User', 'reviewed_by');
    }
    public function wfhBy()
    {
        return $this->belongsTo('App\Models\User', 'reviewed_by');
    }
}
