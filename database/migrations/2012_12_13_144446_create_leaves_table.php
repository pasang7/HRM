<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('leave_type_id')->unsigned()->index();
            $table->boolean('leave_type_full');            
            $table->integer('shift_id');            
            $table->text('description');
            $table->date('from');
            $table->date('to');
            $table->boolean('status')->default(false);
            $table->boolean('is_rejected')->default(false);
            $table->boolean('is_reviewed')->default(false);
            $table->boolean('is_accepted')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->boolean('reviewed_by')->nullable();
            $table->text('reviewed_date')->nullable();
            $table->boolean('approved_by')->nullable();
            $table->text('approved_date')->nullable();
            $table->integer('created_by');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaves');
    }
}
