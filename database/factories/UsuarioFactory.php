<?php

use Faker\Generator as Faker;

$factory->define(App\Usuario::class, function (Faker $faker) {
    return [
        'name' => 'Mock Usuario Test',
        'email' => 'test@email.com.br',
        'cpf' => $faker->cpf,
        'logradouro' =>$faker->streetAddress,
        'bairro' =>$faker->cityPrefix,
        'cep' =>$faker->postcode,
        'cidade' =>$faker->city,
        'estado' =>$faker->stateAbbr
    ];
});
