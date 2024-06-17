<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Change extends Model
{
    protected $fillable = [        
        'user_id','department_id', 'from', 'to'
    ];
    public function defaultHolidays(){
        return $this->hasMany('App\Models\DepartmentHoliday');
    }

    public function userHolidays(){
        return $this->hasMany('App\Models\UserHoliday');
    }
}
