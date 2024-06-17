<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'date','user_id', 'project_id', 'title', 'time', 'description', 'remark','files'
    ];
    protected $dates=['date'];
    public function project(){
        return $this->belongsTo('App\Models\Project');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
