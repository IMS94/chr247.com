<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueuePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queue_patients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('queue_id')->unsigned();
            $table->integer('patient_id')->unsigned();
            $table->boolean('inProgress')->default(false);
            $table->boolean('completed')->default(false);
            $table->timestamps();

            $table->foreign('queue_id')->references('id')->on('queues')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('queue_patients');
    }
}
