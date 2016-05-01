<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prescription_id')->unsigned();
            $table->timestamps();
            $table->float('amount')->default(0);
            $table->boolean('paid')->default(false);
            $table->string('remarks',100)->default(null);

            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payments');
    }
}
