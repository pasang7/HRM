<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeTax extends Model
{
    
    protected $fillable = [
        'name', 'is_married','gender'
    ];

    public function ssTaxslab(){
        return $this->hasMany('App\Models\SsTaxSlab')->orderBy('position','ASC');
    }
    public function slab(){
        return $this->hasMany('App\Models\TaxSlab')->orderBy('position','ASC');
    }
}
