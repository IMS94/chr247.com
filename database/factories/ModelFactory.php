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
        'name'     => $faker->company . ' Clinic',
        'email'    => $faker->unique()->email,
        'address'  => $faker->address,
        'phone'    => $faker->phoneNumber,
        'timezone' => $faker->timezone,
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'     => $faker->name,
        'username' => $faker->unique()->userName,
        'password' => bcrypt('1234'),
        'role_id'  => rand(1, 3)
    ];
});


$factory->define(App\DrugType::class, function (Faker\Generator $faker) {
    $types = ['Pills', 'Litres', 'Tablets', 'Milli Litres', 'Units', 'Bottles'];
    return [
        'drug_type' => $types[rand(0, count($types) - 1)]
    ];
});


$factory->define(App\Drug::class, function (Faker\Generator $faker) {
    return [
        'name'         => $faker->word,
        'manufacturer' => $faker->company,
        'quantity'     => 0
    ];
});

$factory->define(App\Patient::class, function (Faker\Generator $faker) {
    $bloodGroups = ['A +', 'A -', 'B +', 'B -', 'AB +', 'AB -', 'O +', 'O -', 'N/A'];
    return [
        'first_name'  => $faker->firstName,
        'last_name'   => $faker->lastName,
        'address'     => $faker->address,
        'dob'         => $faker->date(),
        'phone'       => $faker->phoneNumber,
        'blood_group' => $bloodGroups[rand(0, count($bloodGroups) - 1)],
        'gender'      => rand(0, 1) == 0 ? "Male" : "Female",
    ];
});

$factory->define(App\Stock::class, function (Faker\Generator $faker) {
    return [
        'manufactured_date' => $faker->dateTimeThisDecade()->format('Y-m-d'),
        'received_date'     => $faker->dateTimeThisMonth()->format('Y-m-d'),
        'expiry_date'       => date('Y-m-d', time() + $faker->randomNumber(7)),
        'quantity'          => $faker->numberBetween(100, 1000),
        'remarks'           => $faker->realText(),
    ];
});

$factory->define(App\Prescription::class, function (Faker\Generator $faker) {
    $issued = rand(0, 1) == 1;
    $issuedAt = $issued ? $faker->dateTimeThisMonth()->format('Y-m-d H:i:s') : null;

    return [
        'complaints'     => $faker->realText(50),
        'investigations' => $faker->realText(50),
        'diagnosis'      => $faker->sentence,
        'remarks'        => $faker->realText(100),
        'issued_at'      => $issuedAt,
        'issued'         => $issued
    ];
});

$factory->define(App\PrescriptionDrug::class, function (Faker\Generator $faker) {
    return [];
});