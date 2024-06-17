<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Holiday extends Model
{
  
    protected $dates = [
        'start','end'
    ];
    protected $fillable = [
        'start','end','is_multiple','name'
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
