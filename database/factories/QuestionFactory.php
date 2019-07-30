<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Question;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Question::class, function (Faker $faker) {
    return [
        'question'    => $faker->name,
        'provenance'  => '(' . $faker->unique()->safeEmail . ')',
        'options'     => '*dfkd *dgkljk *dgjak *dddakj4',
        'answer'      => $faker->name,
        'is_verified' => $faker->randomElement([0, 1]),
    ];
});
