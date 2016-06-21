<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiseasePool extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::dropIfExists('disease_pool');

        Schema::create('disease_pool', function (Blueprint $table) {
            $table->increments('id');
            $table->string('disease', 100)->unique();
            $table->string('synonyms')->nullable();
        });

        $diseasesFile = Storage::disk('global_public')->get('lib/CTD_diseases.tsv');
        $lines = explode("\n", $diseasesFile);
        $diseases = array();
        $diseasesCount = count($lines);
        $recordLimit=10000; 
	for ($x = 0; $x <= $diseasesCount; $x++) {
            //insert diseases to the table every 'recordLimit' times
            if (count($diseases) > $recordLimit || $x == $diseasesCount) {
                try {
                    DB::table('disease_pool')->insert($diseases);
                    $diseases = array();
                } catch (Exception $e) {
                    Log::info($e->getMessage());
                    Log::info($x);
                }

                if ($x == $diseasesCount) {
                    break;
                }
            }
            $disease = explode("\t", $lines[$x]);
            $diseases[] = ['disease' => $disease[0], 'synonyms' => isset($disease[7]) ? $disease[7] : null];
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('disease_pool');
    }
}
