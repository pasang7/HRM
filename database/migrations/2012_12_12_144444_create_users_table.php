<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->string('employee_id');
            $table->enum('is_head', ['yes','no'])->default('no');
            $table->integer('gender');
            $table->unsignedBigInteger('role');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('designation');

            $table->boolean('is_married')->default(false);
            $table->bigInteger('province');
            $table->bigInteger('district');
            $table->text('municipality_vdc')->nullable();
            $table->text('address')->nullable();
            $table->bigInteger('temp_province')->nullable();
            $table->bigInteger('temp_district')->nullable();
            $table->text('temp_municipality_vdc')->nullable();
            $table->text('temp_address')->nullable();

            $table->string('phone')->nullable();
            $table->string('phone_2')->nullable();

            $table->unsignedBigInteger('blood_group');
            $table->unsignedBigInteger('religion');

            $table->string('email')->unique();
            $table->string('email_2')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            $table->string('pin');
            $table->date('dob');
            $table->date('interview_date');
            $table->date('joined');
            $table->text('profile_image')->nullable();
            $table->text('citizenship')->nullable();
            $table->text('cv')->nullable();
            $table->enum('allow_overtime', ['yes','no'])->default('yes');

            $table->enum('has_pan', ['yes','no'])->default('no');
            $table->string('pan_no')->nullable();
            $table->enum('has_ssf', ['yes','no'])->default('no');
            $table->string('ssf_no')->nullable();
            $table->enum('has_pf', ['yes','no'])->default('no');
            $table->string('pf_no')->nullable();

            $table->enum('salary_slip', ['show','hide'])->default('show');
            $table->enum('tax_calculate', ['yes','no'])->default('yes');
            
            $table->integer('first_approval_id')->nullable();
            $table->integer('sec_approval_id')->nullable();

            
            $table->integer('created_by');
            $table->boolean('is_deleted')->default(false);

            $table->rememberToken();
            $table->timestamps();
            
            $table->foreign('role')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('designation')->references('id')->on('designations')->onDelete('cascade');
            $table->foreign('blood_group')->references('id')->on('blood_groups')->onDelete('cascade');
            $table->foreign('religion')->references('id')->on('religions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
