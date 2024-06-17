<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PivotUserAllowance extends Model
{
    protected $fillable = [
        'user_id', 'income_id', 'percent_rate', 'amount','is_selected'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function allowance(){
        return $this->belongsTo('App\Models\PayrollIncome');
    }
}
