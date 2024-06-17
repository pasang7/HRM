<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCitColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('has_cit', ['yes', 'no'])->default('no')->after('pf_no');
            $table->string('cit_no')->nullable()->after('has_cit');
            $table->string('cit_percent')->nullable()->after('cit_no');
            $table->string('cit_amount')->nullable()->after('cit_percent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
