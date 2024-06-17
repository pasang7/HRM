<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCitFacilityToCompanySettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->enum('cit_facility', ['yes', 'no'])->default('no')->after('ssf_facility');
            $table->double('employee_pf_value')->default(0.1)->nullable()->after('cit_facility');
            $table->double('employer_pf_value')->default(0.2)->nullable()->after('employee_pf_value');
            $table->double('gratuity_value')->default(0.0833)->nullable()->after('employer_pf_value');
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
