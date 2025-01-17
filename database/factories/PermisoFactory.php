<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Permiso;
use Faker\Generator as Faker;

$factory->define(Permiso::class, function (Faker $faker) {
    return [
        'Per_nombre' => $faker->word,
        'Per_slug' => $faker->word,
    ];
});
