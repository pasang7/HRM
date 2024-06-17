<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentHoliday extends Model
{
    protected $fillable = [
        'department_id','day','day_name','active_from','change_id'
    ];
    public function change(){
        return $this->belongsTo('App\Models\Change');
    }
}
