<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Salary extends Model
{
    // $table->integer('user_id');
    // $table->decimal('salary', 8, 2);
    // $table->boolean('is_active')->default(true);
    // $table->integer('created_by');
    protected $fillable = [
        'salary', 'is_active', 'user_id','from','to','is_upgraded'
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
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
