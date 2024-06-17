<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_leave_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('leave_type_id');
            $table->integer('days');
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('user_leave_types');
    }
}
