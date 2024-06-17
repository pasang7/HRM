<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class District extends Model
{
    protected $fillable = ['province_id','name','slug', 'is_active','created_by'];

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

   public function districts(){
       $this->hasMany(District::class);
   }
}
