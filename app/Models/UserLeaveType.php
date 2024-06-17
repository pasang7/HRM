<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class UserLeaveType extends Model
{
    protected $fillable = [
        'group_id','user_id','leave_type_id','days','is_active','created_by', 'remaining_leave', 'taken'
    ];
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function leave_type(){
        return $this->belongsTo('App\Models\LeaveType');
    }
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
}
