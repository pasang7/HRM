<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHoliday extends Model
{
    protected $fillable = [
        'user_id','day','active_from','change_id'
    ];
    public function change(){
        return $this->belongsTo('App\Models\Change');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
