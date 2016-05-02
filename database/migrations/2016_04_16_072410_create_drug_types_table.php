<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('drug_type',100);
            $table->integer('clinic_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->unique(['drug_type','clinic_id']);

            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('drug_types');
    }
}
