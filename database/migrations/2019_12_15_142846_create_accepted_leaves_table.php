<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcceptedLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accepted_leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->unsignedBigInteger('leave_type_id');
            $table->unsignedBigInteger('leave_id');
            $table->integer('user_id');
            $table->integer('accepted_by');
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
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
        Schema::dropIfExists('accepted_leaves');
    }
}
