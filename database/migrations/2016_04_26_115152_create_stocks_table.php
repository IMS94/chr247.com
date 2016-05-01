<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('drug_id')->unsigned();
            $table->date('manufactured_date');
            $table->date('expiry_date');
            $table->date('received_date');
            $table->float('quantity')->default(0);
            $table->string('remarks')->nullable();
            $table->integer('created_by')->unsigned();
            $table->timestamps();

            $table->foreign("created_by")->references('id')->on('users')->onDelete('restrict');
            $table->foreign("drug_id")->references('id')->on('drugs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stocks');
    }
}
