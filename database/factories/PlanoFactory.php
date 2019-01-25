<?php

use Faker\Generator as Faker;

$factory->define(App\Plano::class, function (Faker $faker) {
    return [
        'nome' => 'PLANO 1',
        'valor' => 10,
        'descricao' => 'Descrição teste do Plano 1',
        'diferencial' => 'Dif 1, Dif 2'
    ];
});
