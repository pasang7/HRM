<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxSlabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_slabs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('income_tax_id');
            $table->integer('position');
            $table->integer('amount');
            $table->integer('percent');
            $table->integer('created_by');
            $table->timestamps();
            $table->foreign('income_tax_id')->references('id')->on('income_taxes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_slabs');
    }
}
