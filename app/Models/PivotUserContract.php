<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PivotUserContract extends Model
{
    protected $fillable = [
        'user_id', 'contract_id', 'start_date', 'expiry_date','renew_date','is_active'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function contract(){
        return $this->belongsTo(ContractType::class, 'contract_id');
    }

}
