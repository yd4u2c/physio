<?php

namespace Faker\Calculator;

class Iban
{
    /**
     * Generates IBAN Checksum
     *
     * @param string $iban
     * @return string Checksum (numeric string)
     */
    public static function checksum($iban)
    {
        // Move first four digits to end and set checksum to '00'
        $checkString = substr($iban, 4) . substr($iban, 0, 2) . '00';

        // Replace all letters with their number equivalents
        $checkString = preg_replace_callback('/[A-Z]/', array('self','alphaToNumberCallback'), $checkString);

        // Perform mod 97 and subtract from 98
        $checksum = 98 - self::mod97($checkString);

        return str_pad($checksum, 2, '0', STR_PAD_LEFT);
    }

    /**
     * @param string $match
     *
     * @return int
     */
    private static function alphaToNumberCallback($match)
    {
        return self::alphaToNumber($match[0]);
    }

    /**
     * Converts letter to number
     *
     * @param string $char
     * @return int
     */
    public static function alphaToNumber($char)
 