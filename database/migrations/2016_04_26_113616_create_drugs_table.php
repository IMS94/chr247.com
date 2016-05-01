<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drugs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clinic_id')->unsigned();
            $table->string('name');
            $table->integer('drug_type_id')->unsigned();
            $table->string('manufacturer');
            $table->float('quantity')->default(0);
            $table->integer('created_by')->unsigned();
            $table->timestamps();

            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('restrict');
            $table->foreign("created_by")->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('drugs');
    }
}
