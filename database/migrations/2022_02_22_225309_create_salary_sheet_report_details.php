<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarySheetReportDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_sheet_report_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('salary_sheet_report_id');
            $table->unsignedBigInteger('user_id');
            $table->text('user_retire_date');
            $table->double('monthly_salary');
            $table->double('annual_salary');
            $table->double('gratuity');
            $table->double('grossSalary');
            $table->double('cit');
            $table->double('totDep');
            $table->double('allowable_deduction');
            $table->double('total_deduction');
            $table->double('taxable_salary');
            $table->double('social_security_tax');
            $table->double('annual_rem_tax');
            $table->double('rebate');
            $table->double('total_annual_tax');
            $table->double('monthly_tds');
            $table->double('annually_employee_pf');
            $table->double('annually_employer_pf');
            $table->double('monthly_employee_pf');
            $table->double('monthly_employer_pf');
            $table->double('payable_salary');
            $table->double('citMonthly');
            $table->double('net_salary');
            $table->double('work_days');
            $table->double('present_days');
            $table->double('paid_leave');
            $table->double('unpaid_leave');
            $table->double('payable_days');
            $table->double('total_payable_days');
            $table->foreign('salary_sheet_report_id')->references('id')->on('salary_sheet_reports')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('salary_sheet_report_details');
    }
}
