<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Task extends Model
{

    protected $dates=[
        'deadline'
    ];
    protected $fillable = [
        'user_id', 'assigned_by','deadline','task','priority','is_complete','is_removed'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {            
            $model->assigned_by = Auth::user()->id;            
        });
    }

    public function creator(){
        return $this->belongsTo('App\Models\User','assigned_by');
    }
    public function assignedUser(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
