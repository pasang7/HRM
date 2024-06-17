<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->integer('days');
            $table->boolean('carry_forward')->default(0);
            $table->enum('status', ['active', 'in_active'])->default('active');
            $table->enum('exclude_weekends', ['yes', 'no'])->default('yes');
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
        Schema::dropIfExists('leave_types');
    }
}
