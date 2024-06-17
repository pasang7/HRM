<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Shift extends Model
{
    protected $fillable = [
        'department_id', 'clockin', 'clockout', 'status'
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

}
