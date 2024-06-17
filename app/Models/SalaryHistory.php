<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryHistory extends Model
{
    protected $fillable = [
        'user_id', 'old_salary', 'revised_salary', 'old_date', 'revised_date', 'revision_count'
    ];
    protected $casts = [
        'old_date' => 'date',
        'revised_date' => 'date',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}

