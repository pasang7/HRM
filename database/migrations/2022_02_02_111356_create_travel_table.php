<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->integer('shift_id');
            $table->text('program_name');
            $table->date('from');
            $table->date('to');
            $table->text('place');
            $table->text('purpose');
            $table->text('travel_plan');
            $table->text('travel_mode')->nullable();
            $table->text('other_travel_mode')->nullable();
            $table->text('justification')->nullable();
            $table->float('accommodation_day');
            $table->double('accommodation_per_diem');
            $table->double('accommodation_total');
            $table->float('daily_allowance_day');
            $table->double('daily_allowance_per_diem');
            $table->double('daily_allowance_total');
            $table->float('contingency_day')->nullable();
            $table->double('contingency_per_diem')->nullable();
            $table->double('contingency_total')->nullable();
            $table->double('advance_taken')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('submitted_by');
            $table->text('submitted_date');
            $table->boolean('recommended_by')->nullable();
            $table->text('recommended_date')->nullable();
            $table->boolean('approved_by')->nullable();
            $table->text('approved_date')->nullable();
            $table->enum('is_read', ['yes', 'no'])->default('no');
            $table->boolean('is_rejected')->default(false);
            $table->boolean('is_reviewed')->default(false);
            $table->boolean('is_accepted')->default(false);
            $table->integer('created_by');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel');
    }
}
