<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->string('complaints', 150)->nullable()->default(null);
            $table->string('investigations', 150)->nullable()->default(null);
            $table->string('diagnosis', 150)->nullable()->default(null);
            $table->string('remarks', 150)->nullable()->default(null);
            $table->timestamps();
            $table->boolean('issued')->default(false);
            $table->timestamp('issued_at')->default(null);
            $table->integer('created_by')->unsigned();

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');
            $table->foreign("created_by")->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('prescriptions');
    }
}
