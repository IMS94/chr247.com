<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clinic_id')->unsigned();
            $table->string('first_name',50);
            $table->string('last_name',50)->nullable();
            $table->text('address')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender',20);
            $table->string('nic',20)->nullable();
            $table->string('phone',30)->nullable();
            $table->string('blood_group',15)->nullable();
            $table->text('allergies')->nullable();
            $table->text('family_history')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('post_surgical_history')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->unique(['clinic_id','first_name','last_name','nic']);

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
        Schema::drop('patients');
    }
}
