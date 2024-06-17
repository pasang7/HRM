<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryPaymentDetail extends Model
{
    // $table->integer('user_id');
    // $table->integer('salary_paid_id');
    // $table->date('date');
    // $table->decimal('expected_yearly_income', 13, 2);
    // $table->decimal('salary', 13, 2);
    // $table->decimal('total_days', 8, 2);
    // $table->decimal('present_days', 8, 2);
    // $table->decimal('paid_leave', 8, 2);
    // $table->decimal('unpaid_leave', 8, 2);
    // $table->decimal('payable_days', 8, 2);
    // $table->decimal('gross_salary_payable', 8, 2);
    // $table->decimal('total_payable', 8, 2);
    // $table->decimal('tds', 8, 2);
    // $table->decimal('net_payable', 8, 2);

    protected $fillable = [
        'user_id', 
        'salary_paid_id', 
        'date', 
        'expected_yearly_income', 
        'salary', 
        'total_days', 
        'present_days', 
        'paid_leave', 
        'unpaid_leave', 
        'payable_days',
        'gross_salary_payable',
        'total_payable',
        'tds',
        'net_payable'
    ];
    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
        
    }
}
