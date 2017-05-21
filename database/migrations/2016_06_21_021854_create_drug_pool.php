<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugPool extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::dropIfExists('drug_pool');

        Schema::create('drug_pool', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ingredient')->nullable();
            $table->string('trade_name')->nullable();
            $table->string('manufacturer')->nullable();
            $table->unique(['ingredient', 'trade_name', 'manufacturer']);
        });

        //Add the drugs to the drug pool.
        $drugFile = \Storage::disk('global_public')->get('lib/orangebook_products.tsv');
        $lines = explode("\n", $drugFile);
        $drugCount = count($lines);
        $drugs = array();
        $recordLimit = 15000;
        for ($x = 1; $x <= $drugCount; $x++) {
            // For every 'recordLimit' times, the records are inserted to the database.
            // And the drugs array is cleared
            if (count($drugs) > $recordLimit || $x == $drugCount) {
                try {
                    DB::table('drug_pool')->insert($drugs);
                    $drugs = array();
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                }

                if ($x == $drugCount) {
                    break;
                }
            }

            $drugDetails = explode("|", $lines[$x]);
            if (!isset($drugDetails[3]) || !isset($drugDetails[4])) {
                continue;
            }
            $drug = ['ingredient' => ucwords(strtolower($drugDetails[0])),
                'trade_name' => ucwords(strtolower($drugDetails[3])),
                'manufacturer' => ucwords(strtolower($drugDetails[4]))];
            if (!in_array($drug, $drugs)) {
                $drugs[] = $drug;
            }
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('drug_pool');
    }
}
