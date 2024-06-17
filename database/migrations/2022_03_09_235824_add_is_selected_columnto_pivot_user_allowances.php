<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSelectedColumntoPivotUserAllowances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pivot_user_allowances', function (Blueprint $table) {
            $table->boolean('is_selected')->default(0)->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pivot_user_allowances', function (Blueprint $table) {
            //
        });
    }
}
