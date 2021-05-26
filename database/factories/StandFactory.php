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

$factory->define(App\Stand::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(3,true), 
        'level'=>$faker-> numberBetween(1,10),
        'type' =>$faker->randomElement(['Tesis','Revista','Libro']),
        'status'=> $faker->randomElement(['Habilitado', 'Deshabilitado']),
    ];
});

