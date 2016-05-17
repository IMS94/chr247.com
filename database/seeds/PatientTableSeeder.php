<?php

use Illuminate\Database\Seeder;

class PatientTableSeeder extends Seeder
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
                //add patients to the clinic
                factory(App\Patient::class, 10)->make()->each(function (\App\Patient $patient) use ($clinic, $user) {
                    $patient->creator()->associate($user);
                    $patient->clinic()->associate($clinic);
                    $patient->save();
                });
            }
        }
    }
}
