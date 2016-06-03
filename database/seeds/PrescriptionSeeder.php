<?php

use Illuminate\Database\Seeder;

class PrescriptionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        foreach (\App\Clinic::all() as $clinic) {
            foreach ($clinic->users as $user) {

                //add 3 prescriptions per each patient if the user is not a nurse
                if (!$user->isNurse()) {
                    //get all the drugs and dosages
                    $drugs = $clinic->drugs;
                    $frequencies = $clinic->dosageFrequencies;
                    $periods = $clinic->dosagePeriods;
                    $dosages = $clinic->dosages;

                    foreach (\App\Patient::all() as $patient) {
                        /*
                         * Adding 3 prescriptions per each patient per each user.
                         */
                        $prescriptions = factory('App\Prescription', 3)->make()->each(
                            function (App\Prescription $prescription) use ($patient, $user) {
                                $prescription->patient()->associate($patient);
                                $prescription->creator()->associate($user);
                                $prescription->save();
                            }
                        );

                        /*
                         * Adding drugs to each prescription
                         */
                        foreach ($prescriptions as $prescription) {

                            /*
                             * Add 0-6 drugs per prescription.
                             */
                            $drugCount = rand(0, 6);
                            for ($x = 0; $x < $drugCount; $x++) {
                                $prescriptionDrug = new \App\PrescriptionDrug();
                                $prescriptionDrug->drug()->associate($drugs->random(1));
                                $prescriptionDrug->dosage()->associate($dosages->random(1));
                                $prescriptionDrug->frequency()->associate($frequencies->random(1));
                                $prescriptionDrug->period()->associate($periods->random(1));
                                $prescriptionDrug->prescription()->associate($prescription);
                                if ($prescription->issued) {
                                    $prescriptionDrug->quantity = rand(1, 50);
                                    $drug = $prescriptionDrug->drug;
                                    $drug->quantity = $drug->quantity - $prescriptionDrug->quantity;
                                    if ($drug->quantity < 0) {
                                        $drug->quantity = 0;
                                    }
                                    $drug->update();
                                }
                                $prescriptionDrug->save();
                            }

                            $drugCount = rand(0, 3);
                            for ($x = 0; $x < $drugCount; $x++) {
                                $pharmacyDrug = factory('App\PrescriptionPharmacyDrug', 1)->make();
                                $pharmacyDrug->prescription()->associate($prescription);
                                $pharmacyDrug->save();
                            }

                            if ($prescription->issued) {
                                $payment = new \App\Payment();
                                $payment->amount = rand(100, 1000);
                                $payment->remarks = "Paid in cash";
                                $prescription->payment()->save($payment);
                            }
                        }
                    }
                }


            }
        }

    }
}
