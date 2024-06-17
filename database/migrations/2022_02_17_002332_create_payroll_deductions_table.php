<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_deductions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')->nullable();
            $table->text('short_name')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('calculation_method', ['percent', 'amount'])->nullable();
            $table->double('percent_rate')->nullable();
            $table->double('fixed_amount')->nullable();
            $table->enum('status', ['active', 'in_active'])->default('active');
            $table->enum('is_assign', ['yes', 'no'])->default('no');
            $table->enum('assign_status', ['all', 'partial','none'])->default('none');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_deductions');
    }
}
