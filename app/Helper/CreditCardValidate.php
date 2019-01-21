<?php

namespace App\Helper;

/**
 * https://forum.imasters.com.br/topic/520149-validar-cart%C3%A3o-de-cr%C3%A9dito/
 */
class CreditCardValidate
{
    /**
     * [luhn_check description]
     * @param  string $number
     * @return boolean
     */
    public static function luhnCheck($number)
    {
        // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
        $number = preg_replace('/\D/', '', $number);

        // Set the string length and parity
        $number_length = strlen($number);
        $parity = $number_length % 2;

        // Loop through each digit and do the maths
        $total = 0;
        for ($i = 0; $i < $number_length; $i++) {
            $digit = $number[$i];

            // Multiply alternate digits by two
            if ($i % 2 == $parity) {
                $digit *= 2;

                // If the sum is two digits, add them together (in effect)
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            // Total up the digits
            $total += $digit;
        }

        // If the total mod 10 equals 0, the number is valid
        return ($total % 10 == 0) ? true : false;
    }

    /**
     * [validateByCC description]
     * @param  string $cc_num
     * @param  string $type
     * @return boolean
     */
    public static function validateByCC($cc_num, $type)
    {
        switch ($type) {
            //American Express
            case "American":
                $pattern = "/^([34|37]{2})([0-9]{13})$/";
                $denum = "American Express";

                if (preg_match($pattern, $cc_num)) {
                    return true;
                }

                return false;

            //Diner's Club
            case "Dinners":
                $pattern = "/^([30|36|38]{2})([0-9]{12})$/";
                $denum = "Diner's Club";

                if (preg_match($pattern, $cc_num)) {
                    return true;
                }

                return false;

            //Discover Card
            case "Discover":
                $pattern = "/^([6011]{4})([0-9]{12})$/";
                $denum = "Discover";

                if (preg_match($pattern, $cc_num)) {
                    return true;
                }

                return false;

            //Mastercard
            case "Master":
                $pattern = "/^([51|52|53|54|55]{2})([0-9]{14})$/";
                $denum = "Master Card";

                if (preg_match($pattern, $cc_num)) {
                    return true;
                }

                return false;

            //Visa
            case "Visa":
                $pattern = "/^([4]{1})([0-9]{12,15})$/";
                $denum = "Visa";

                if (preg_match($pattern, $cc_num)) {
                    return true;
                }

                return false;

            //Hipercad
            case "Hiper":
                $pattern = "/^(3841\d{10}(\d{3})?)|(3841\d{15})$/";
                $denum = "Hiper";

                if (preg_match($pattern, $cc_num)) {
                    return true;
                }

                return false;

            //Elo
            case "Elo":
                $pattern = "/^([6362]{4})([0-9]{12})$/";
                $denum = "Elo";

                if (preg_match($pattern, $cc_num)) {
                    return true;
                }

                return false;

            default:
                return false;
        }
    }
}
