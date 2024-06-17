<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PayrollDeduction extends Model
{
    protected $fillable = [
        'name','short_name','remarks','calculation_method','percent_rate','status','is_assign','assign_status'
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
        return $this->belongsToMany('App\Models\User', 'pivot_user_allowances', 'user_id', 'income_id');
    }
}
