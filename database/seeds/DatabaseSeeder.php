<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // Roles moved to the migrations.
        // $this->call(RolesTableSeeder::class);

        $this->call(ClinicsTableSeeder::class);
        $this->call(UserTableSeeder::class);

        $this->call(PatientTableSeeder::class);
        $this->call(DrugTypesTableSeeder::class);
        $this->call(DosagesSeeder::class);

        $this->call(PrescriptionSeeder::class);
    }
}


/**
 * Class ClinicsTableSeeder
 */
class ClinicsTableSeeder extends Seeder {
    public function run() {
        //create clinics
        $clinic = factory(App\Clinic::class, 1)->create(['email' => 'imesha@highflyer.lk', 'accepted' => true]);
        $user = factory(App\User::class)->make(['username' => 'imesha', 'name' => 'Imesha Sudasingha', 'role_id' => 1]);
        $clinic->users()->save($user);
        factory(App\Clinic::class, 1)->create();
    }
}


/**
 * Class DosagesSeeder
 */
class DosagesSeeder extends Seeder {
    public function run() {
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
class UserTableSeeder extends Seeder {
    public function run() {
        foreach (\App\Clinic::all() as $clinic) {
            //create users of the clinic
            factory(App\User::class, 3)->make()->each(function (App\User $user) use ($clinic) {
                $clinic->users()->save($user);
            });
        }
    }
}