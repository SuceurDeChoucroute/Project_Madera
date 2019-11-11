<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'city_id' => factory(App\Models\City::class)->create()->id,
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'street' => $faker->streetName,
        'street_number' => $faker->buildingNumber,
        'zipcode' => $faker->postcode,
        'email' => $faker->email,
        'phone' => $faker->e164PhoneNumber,
    ];
});
