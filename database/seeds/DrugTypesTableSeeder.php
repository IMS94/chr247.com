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

        foreach (\App\Clinic::all() as $clinic) {
            foreach ($clinic->users as $user) {

                //add drug types of the clinic
                factory(App\DrugType::class, 2)->make()->each(function (\App\DrugType $drugType) use ($clinic, $user) {
                    if ($clinic->quantityTypes()->where('drug_type', $drugType->drug_type)->count() == 0) {
                        $drugType->creator()->associate($user);
                        $drugType->clinic()->associate($clinic);
                        $drugType->save();

                        //adding drugs of the clinic
                        factory(App\Drug::class, 10)->make()->each(
                            function (App\Drug $drug) use ($clinic, $user, $drugType) {
                                $drug->creator()->associate($user);
                                $drug->clinic()->associate($clinic);
                                $drug->quantityType()->associate($drugType);
                                $drug->save();

                                //adding stocks of the drug
                                factory(App\Stock::class, rand(2, 10))->make()->each(
                                    function (App\Stock $stock) use ($drug, $user) {
                                        $stock->creator()->associate($user);
                                        $stock->drug()->associate($drug);
                                        $stock->save();

                                        $drug->quantity = $stock->quantity + $drug->quantity;
                                        $drug->update();
                                    }
                                );
                            }
                        );
                    }
                });
            }
        }

    }
}
