<?php

namespace App\Helper;

/**
 *
 */
class Valida
{
    /**
     * [validaEntrada description]
     * @param  mixed $entrada
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public static function validaEntrada(array $entrada, array $dadosObrigatorios = [])
    {
        if (empty($entrada)) {
            throw new \InvalidArgumentException('Entrada de dados vazio.');
        }

        foreach ($entrada as $key => $value) {
            if (is_array($value)) {
                self::validaEntrada($value);
            }
            else {
                if (in_array($key, $dadosObrigatorios)
                    && (!$entrada[$key] || empty($entrada[$key]))
                ) {
                    throw new \InvalidArgumentException('Campo obrigatório não preenchido.');
                }

                $entrada[$key] = strip_tags(addslashes($value));
            }
        }

        return $entrada;
    }
}