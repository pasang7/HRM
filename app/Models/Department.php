<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Auth;
class Department extends Model
{
    use HasSlug;
    protected $fillable = [
        'name', 'slug', 'status', 'is_default'
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

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

    public function employees(){
        return $this->hasMany('App\Models\User');
    }
    public function shifts(){
        return $this->hasMany('App\Models\Shift');
    }
    public function active_shifts(){
        return $this->hasMany('App\Models\Shift');
    }

    public function holidays(){
        return $this->hasMany('App\Models\DepartmentHoliday')->where('status',1);
    }
}
