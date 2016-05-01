<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_drugs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prescription_id')->unsigned();
            $table->integer('drug_id')->unsigned();
            $table->integer('dosage_id')->unsigned();
            $table->integer('frequency_id')->unsigned();
            $table->integer('period_id')->unsigned();
            $table->float('quantity')->default(0);
            $table->timestamps();

            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('restrict');
            $table->foreign('drug_id')->references('id')->on('drugs')->onDelete('restrict');
            $table->foreign('dosage_id')->references('id')->on('dosages')->onDelete('restrict');
            $table->foreign('frequency_id')->references('id')->on('frequencies')->onDelete('restrict');
            $table->foreign('period_id')->references('id')->on('periods')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prescription_drugs');
    }
}
