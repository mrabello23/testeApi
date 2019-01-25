<?php

namespace App\Helper;

/**
 *
 */
class ApiRestCall
{
    /**
     * [postCall description]
     * @param string $url
     * @param mixed $dados
     * @return bool
     *
     * @throws Exception
     */
    public static function postCall($url, array $dados)
    {
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($dados));
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-Type: application/x-www-form-urlencoded; charset=UTF-8"]);

        $retorno = curl_exec($curl);
        $error = curl_error($curl);
        $error_code = curl_error($curl);
        curl_close($curl);

        if (!$retorno) {
            throw new \Exception("Error Processing Request: " . $error_code . ': ' . $error);
        }

        return $retorno;
    }

    /**
     * [getCall description]
     * @param string $url
     * @param mixed $dados
     * @return bool
     *
     * @throws Exception
     */
    public static function getCall($url, array $dados)
    {
        if (!empty($dados)) {
            $url.= '?' . http_build_query($dados);
        }

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, false);

        $retorno = curl_exec($curl);
        $error = curl_error($curl);
        $error_code = curl_error($curl);
        curl_close($curl);

        if (!$retorno) {
            throw new \Exception("Error Processing Request: " . $error_code . ': ' . $error);
        }

        return $retorno;
    }
}
