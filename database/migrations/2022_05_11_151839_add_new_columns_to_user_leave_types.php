<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToUserLeaveTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_leave_types', function (Blueprint $table) {
            $table->double('remaining_leave')->after('days')->nullable();
            $table->double('taken')->after('remaining_leave')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_leave_types', function (Blueprint $table) {
            //
        });
    }
}
