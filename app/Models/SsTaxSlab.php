<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SsTaxSlab extends Model
{
    protected $fillable = [
        'income_tax_id', 'position','amount','percent'
    ];
    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->created_by = Auth::user()->id;
        });
    }
}
