<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcceptedLeave extends Model
{
    protected $dates = [
        'date'
    ];
    protected $fillable = [
        'date', 'leave_type_id', 'leave_id', 'user_id', 'accepted_by', 'is_paid'
    ];
    public function accepted_by(){
        return $this->belongsTo('App\Models\User','accepted_by');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function leave(){
        return $this->belongsTo('App\Models\Leave');
    }

    public function type(){
        return $this->belongsTo('App\Models\LeaveType','leave_type_id');
    }
}
