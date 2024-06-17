<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('is_new_setup', ['yes', 'no'])->default('yes');
            $table->text('name')->nullable();
            $table->text('website')->nullable();
            $table->text('logo')->nullable();
            $table->text('address')->nullable();
            $table->text('phone')->nullable();
            $table->text('mobile')->nullable();
            $table->text('email')->nullable();
            $table->integer('min_leave_days_for_review')->default(0);
            $table->double('normal_overtime_rate')->default('1.5');
            $table->double('special_overtime_rate')->default('2')->nullable();
            $table->enum('pf_facility', ['yes', 'no'])->default('no');
            $table->enum('gratuity_facility', ['yes', 'no'])->default('no');
            $table->enum('ssf_facility', ['yes', 'no'])->default('no');
            $table->enum('payroll_calendar_type', ['nepali', 'english'])->default('english');
            $table->text('bank_name')->nullable();
            $table->text('bank_branch')->nullable();
            $table->text('bank_contact')->nullable();
            $table->bigInteger('day_in_month')->default('30');
            $table->bigInteger('month_in_year')->default('12');
            $table->bigInteger('working_hour')->default('8');
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
        Schema::dropIfExists('company_settings');
    }
}
