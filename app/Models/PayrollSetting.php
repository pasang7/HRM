<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollSetting extends Model
{
    protected $fillable = [
        'day_in_month','month_in_year'
    ];
}
