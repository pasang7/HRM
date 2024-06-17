<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Auth;
class Project extends Model
{
    // $table->string('name');
    // $table->integer('department_id');
    // $table->string('slug');
    // $table->boolean('status')->default(0);
    // $table->integer('created_by');
    use HasSlug;
    protected $fillable = [
        'name', 'slug', 'department_id','status','deadline','is_other'
    ];
    protected $dates = [
        'deadline'
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
    public function department(){
        return $this->belongsTo('App\Models\Department');
    }
    public function reports(){
        return $this->hasMany('App\Models\Report','project_id','id');
    }
}
