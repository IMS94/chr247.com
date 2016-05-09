<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Clinic::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'username' => $faker->unique()->userName,
        'password' => bcrypt(str_random(10)),
        'role_id' => rand(1, 3),
        'clinic_id' => \App\Clinic::first()->id,
    ];
});

$factory->define(App\Drug::class, function (Faker\Generator $faker) {
    $clinic = \App\Clinic::find(1);
    return [
        'name' => $faker->word,
        'manufacturer' => $faker->company,
        'quantity' => 0,
        'drug_type_id' => $clinic->drugTypes()->get()->first()->id,
        'created_by' => $clinic->users()->first()->id,
        'clinic_id' => $clinic->id,
    ];
});

$factory->define(App\Patient::class, function (Faker\Generator $faker) {
    $clinic = \App\Clinic::find(1);
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'address' => $faker->address,
        'dob' => $faker->date(),
        'created_by' => $clinic->users()->first()->id,
        'clinic_id' => $clinic->id
    ];
});