<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shift_id');
            $table->date('date');
            $table->text('remarks')->nullable();
            //Holiday
            $table->boolean('is_holiday')->default(0);
            $table->boolean('holiday_type')->nullable();
            $table->unsignedBigInteger('holiday_id')->nullable();
            //Late
            $table->boolean('is_late')->default(0);
            //Absent
            $table->boolean('is_absent')->default(0);
            //Leave
            $table->boolean('is_leave')->default(0);
            $table->unsignedBigInteger('leave_type_id')->nullable();
            $table->decimal('leave_day', 8, 2)->nullable();
            $table->unsignedBigInteger('leave_id')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->time('clockin')->nullable();
            $table->time('clockout')->nullable();
            $table->string('clockin_verification')->nullable();
            $table->string('clockout_verification')->nullable();
            $table->boolean('default_clockout')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');
            $table->foreign('holiday_id')->references('id')->on('holidays')->onDelete('cascade');
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');
            $table->foreign('leave_id')->references('id')->on('leaves')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
