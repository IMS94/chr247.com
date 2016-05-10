<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(ClinicsTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(DosagesSeeder::class);

//        $this->call(DrugTypesTableSeeder::class);
//        $this->call(DrugTableSeeder::class);
//        $this->call(PatientTableSeeder::class);

    }
}


/**
 * Class ClinicsTableSeeder
 */
class ClinicsTableSeeder extends Seeder
{
    public function run()
    {
        //create clinics
        factory(App\Clinic::class, 10)->create();
    }
}


/**
 * Class RolesTableSeeder
 */
class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $role = new \App\Role();
        $role->role = "Admin";
        $role->save();

        $role = new \App\Role();
        $role->role = "Doctor";
        $role->save();

        $role = new \App\Role();
        $role->role = "Nurse";
        $role->save();
    }
}


/**
 * Class DosagesSeeder
 */
class DosagesSeeder extends Seeder
{
    public function run()
    {
        foreach (\App\Clinic::all() as $clinic) {
            $user = $clinic->users()->first();

            $dosages = [
                '2 pills per time before dining', '1 pill per time before dining',
                '1 tablet per time', '2 tablets per time', 'Half tablets per time after dining',
                '2 table spoons per time'
            ];
            foreach ($dosages as $dosage) {
                $x = new \App\Dosage(['description' => $dosage]);
                $x->clinic()->associate($clinic);
                $x->creator()->associate($user);
                $x->save();
            }

            $frequencies = [
                '2 times per day', '3 times per day', 'At morning', 'At Night', 'At afternoon',
                'per 8 hours'
            ];
            foreach ($frequencies as $dosage) {
                $x = new \App\DosageFrequency(['description' => $dosage]);
                $x->clinic()->associate($clinic);
                $x->creator()->associate($user);
                $x->save();
            }

            $periods = [
                '3 months', '2 months', '1 month', '1 week', '2 weeks', '3 weeks', '40 days', '3 days'
            ];
            foreach ($periods as $dosage) {
                $x = new \App\DosagePeriod(['description' => $dosage]);
                $x->clinic()->associate($clinic);
                $x->creator()->associate($user);
                $x->save();
            }
        }
    }
}

/**
 * Class UserTableSeeder
 */
class UserTableSeeder extends Seeder
{
    public function run()
    {
        foreach (\App\Clinic::all() as $clinic) {
            //create users of the clinic
            factory(App\User::class, 3)->make()->each(function ($user) use ($clinic) {
                $clinic->users()->save($user);

                //add patients to the clinic
                factory(App\Patient::class, 10)->make()->each(function (\App\Patient $patient) use ($clinic, $user) {
                    $patient->creator()->associate($user);
                    $patient->clinic()->associate($clinic);
                    $patient->save();
                });

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
            });
        }
    }
}
