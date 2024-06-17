<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemarksToTravelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('travel', function (Blueprint $table) {
            $table->text('recommended_remarks')->nullable()->after('is_reviewed');
            $table->text('accepted_remarks')->nullable()->after('is_accepted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('travel', function (Blueprint $table) {
            //
        });
    }
}
