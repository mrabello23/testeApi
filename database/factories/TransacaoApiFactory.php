<?php

use Faker\Generator as Faker;

$factory->define(App\TransacaoApi::class, function (Faker $faker) {
    return [
        'token' => md5(str_random(10)),
        'status' => 'AUTORIZADO'
    ];
});
