<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Country;
use Faker\Generator as Faker;

$factory->define(Country::class, function (Faker $faker) {
    $continents = App\Continent::pluck('id')->toArray();
    return [
        'country_name' => $faker->unique()->country,
        'country_alias' => $faker->unique()->countryCode,
        'continent_id' => $faker->randomElement($continents)
    ];
});
