<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Arr;
use App\Models\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'birth_date' => $faker->date(),
        'gender' => Arr::random([1, 2]),
    ];
});
