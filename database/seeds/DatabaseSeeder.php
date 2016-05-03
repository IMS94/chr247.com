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
        $this->call(ClinicsTableSeeder::class);
        $this->call(RolesTableSeeder::class);

        $this->call(UserTableSeeder::class);
        $this->call(DrugTypesTableSeeder::class);
        $this->call(DrugTableSeeder::class);
    }
}


class ClinicsTableSeeder extends Seeder
{
    public function run()
    {
        $clinic = new \App\Clinic();
        $clinic->name = "Admin's Clinic";
        $clinic->address = "154, Nugegoda, Sri Lanka";
        $clinic->phone = "+94112365896";
        $clinic->email = "admin#example.com";
        $clinic->save();

        factory(App\Clinic::class, 50)->create();
    }
}


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


class UserTableSeeder extends Seeder
{
    public function run()
    {
        $user = new \App\User();
        $user->name = "Admin";
        $user->username = "admin";
        $user->email = "admin@example.com";
        $user->password = bcrypt('1234');
        $role = \App\Role::where('role', 'Admin')->first();
        $user->role()->associate($role);
        $clinic = \App\Clinic::first();
        $clinic->users()->save($user);

        $user = new \App\User();
        $user->name = "Doctor";
        $user->username = "doctor";
        $user->email = "doctor@example.com";
        $user->password = bcrypt('1234');
        $role = \App\Role::where('role', 'Doctor')->first();
        $user->role()->associate($role);
        $clinic = \App\Clinic::first();
        $clinic->users()->save($user);

        $user = new \App\User();
        $user->name = "Nurse";
        $user->username = "nurse";
        $user->email = "nurse@example.com";
        $user->password = bcrypt('1234');
        $role = \App\Role::where('role', 'Nurse')->first();
        $user->role()->associate($role);
        $clinic = \App\Clinic::first();
        $clinic->users()->save($user);

        factory(App\User::class,50)->create();
    }
}
