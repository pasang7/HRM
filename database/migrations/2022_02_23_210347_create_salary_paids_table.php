<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryPaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_paids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('salary_sheet_report_id');
            $table->date('date');
            $table->date('paid_at');
            $table->integer('created_by');
            $table->timestamps();
            $table->foreign('salary_sheet_report_id')->references('id')->on('salary_sheet_reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_paids');
    }
}
