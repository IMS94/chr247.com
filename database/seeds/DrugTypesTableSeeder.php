<?php

use Illuminate\Database\Seeder;

class DrugTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $drugType = new \App\DrugType();
        $drugType->drug_type = "Pills";
        $drugType->clinic()->associate(\App\Clinic::find(1));
        $drugType->creator()->associate(\App\User::find(1));
        $drugType->save();
    }
}
