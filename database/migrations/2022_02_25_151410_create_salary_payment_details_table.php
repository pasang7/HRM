<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_payment_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('salary_paid_id');
            $table->date('date');
            $table->decimal('expected_yearly_income', 13, 2);
            $table->decimal('salary', 13, 2);
            $table->decimal('total_days', 8, 2);
            $table->decimal('present_days', 8, 2);
            $table->decimal('paid_leave', 8, 2);
            $table->decimal('unpaid_leave', 8, 2);
            $table->decimal('payable_days', 8, 2);
            $table->decimal('gross_salary_payable', 8, 2);
            $table->decimal('total_payable', 8, 2);
            $table->decimal('tds', 8, 2);
            $table->decimal('net_payable', 8, 2);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('salary_paid_id')->references('id')->on('salary_paids')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_payment_details');
    }
}
