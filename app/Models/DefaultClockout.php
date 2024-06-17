<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultClockout extends Model
{
    protected $fillable = ['date'];
    protected $dates = ['date'];
}
