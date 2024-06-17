<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCompanySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->enum('overtime', ['yes', 'no'])->default('no')->after('min_leave_days_for_review');
            $table->enum('bonus', ['yes', 'no'])->default('no')->after('working_hour')->nullable();
            $table->text('bonus_type')->after('bonus')->nullable();
            $table->float('customize_amount')->default(0)->after('bonus_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_settings', function (Blueprint $table) {
            //
        });
    }
}
