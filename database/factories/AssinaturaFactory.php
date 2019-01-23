<?php

use Faker\Generator as Faker;

$factory->define(App\Assinatura::class, function (Faker $faker) {
    return [
        'codigo' => md5(date('dmYHi')),
        'cartao' => $faker->creditCardNumber,
        'vencimento' => $faker->creditCardExpirationDate,
        'cod_cartao' => rand(100, 999),
        'id_plano' => 1,
        'id_usuario' => function () {
            return factory(App\Usuario::class)->create()->id;
        }
    ];
});
