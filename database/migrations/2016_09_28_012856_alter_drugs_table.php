<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDrugsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropForeign(['drug_type_id']);
            $table->dropForeign(['clinic_id']);
            $table->dropUnique(['clinic_id', 'name', 'drug_type_id', 'manufacturer']);

            $table->string('ingredient')->nullable();

            $table->unique(['clinic_id', 'name', 'ingredient', 'drug_type_id', 'manufacturer']);
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('restrict');
            $table->foreign('drug_type_id')->references('id')->on('drug_types')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropForeign(['drug_type_id']);
            $table->dropForeign(['clinic_id']);

            $table->dropUnique(['clinic_id', 'name', 'ingredient', 'drug_type_id', 'manufacturer']);

            $table->unique(['clinic_id', 'name', 'drug_type_id', 'manufacturer']);
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('restrict');
            $table->foreign('drug_type_id')->references('id')->on('drug_types')->onDelete('restrict');
            $table->dropColumn('ingredient');
        });
    }
}
