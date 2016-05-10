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
        'name' => $faker->company.' Clinic',
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
        'password' => bcrypt('1234'),
        'role_id' => rand(1, 3)
    ];
});



$factory->define(App\DrugType::class, function (Faker\Generator $faker) {
    $types=['Pills','Litres','Tablets','Milli Litres','Units','Bottles'];
    return [
        'drug_type' =>$types[rand(0,count($types)-1)]
    ];
});


$factory->define(App\Drug::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'manufacturer' => $faker->company,
        'quantity' => 0
    ];
});

$factory->define(App\Patient::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'address' => $faker->address,
        'dob' => $faker->date(),
        'phone'=>$faker->phoneNumber
    ];
});

$factory->define(App\Stock::class, function (Faker\Generator $faker) {
    return [
        'manufactured_date' => $faker->dateTimeThisDecade()->format('Y-m-d'),
        'received_date' => $faker->dateTimeThisMonth()->format('Y-m-d'),
        'expiry_date' => date('Y-m-d',time()+$faker->randomNumber()),
        'quantity'=>$faker->numberBetween(100,2000),
        'remarks'=>$faker->realText(),
    ];
});