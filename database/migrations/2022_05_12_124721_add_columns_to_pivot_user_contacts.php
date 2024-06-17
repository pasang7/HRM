<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPivotUserContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pivot_user_contracts', function (Blueprint $table) {
            $table->text('start_date')->after('contract_id')->nullable();
            $table->text('expiry_date')->after('start_date')->nullable();
            $table->text('renew_date')->after('expiry_date')->nullable();
            $table->boolean('is_active')->after('renew_date')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pivot_user_contracts', function (Blueprint $table) {
            //
        });
    }
}
