<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->string('complaints',200)->default(null);
            $table->string('investigations',200)->default(null);
            $table->string('diagnosis',200)->default(null);
            $table->string('remarks',200)->default(null);
            $table->timestamps();
            $table->boolean('issued')->default(false);
            $table->timestamp('issued_at')->default(null);

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prescriptions');
    }
}
