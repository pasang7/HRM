<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Auth;
class Designation extends Model
{
    use HasSlug;
    protected $fillable = [
        'name', 'slug', 'is_active', 'created_by','is_superadmin'
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

    public function getDesignationStatusAttribute(){
        if($this->is_active == 'yes'){
            return '<a href="javascript:void(0)" status="'.$this->is_active.'" onclick="changeStatus('.$this->id.')" class="text-success">Active</a>';
        }else{
            return '<a href="javascript:void(0)"  status="'.$this->is_active.'" onclick="changeStatus('.$this->id.')" class="text-danger">Inactive</a>';
        }
    }

}
