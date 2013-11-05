<?php

namespace Scandio\lmvc\utils\string;

/**
 * Static library for string functions
 */
class StringUtils
{
    /**
     * Converts a camel cased string to a lower cased string with a delimiter
     *
     * @param string $camelCasedString the input string as a camelCasedString
     * @param string $delimiter optional the delimiter the default is "-"
     * @return string the result is a camel-cased-string instead of a camelCasedString
     */
    public static function camelCaseTo($camelCasedString, $delimiter = '-')
    {
        return strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/', $delimiter . "$1", $camelCasedString));
    }

    /**
     * Converts a delimited string to a camel cased string
     *
     * @param string $otherString the input string a delimited-string
     * @param string $delimiter optional the delimiter the default is "-"
     * @return string the result is a delimitedString instead of a delimited-string
     */
    public static function camelCaseFrom($otherString, $delimiter = '-')
    {
        return lcfirst(implode('', array_map(function ($data) {
            return ucfirst($data);
        }, explode($delimiter, $otherString))));
    }

    public static function bytes($string)
    {
        $strlen_var = strlen($string);
        $d          = 0;

        for($c = 0; $c < $strlen_var; ++$c){
            $ord_var_c = ord($string{$c});
            switch(true){
                case(($ord_var_c >= 0x20) && ($ord_var_c <= 0x7F)):
                    // characters U-00000000 - U-0000007F (same as ASCII)
                    $d++;
                    break;
                case(($ord_var_c & 0xE0) == 0xC0):
                    // characters U-00000080 - U-000007FF, mask 110XXXXX
                    $d+=2;
                    break;
                case(($ord_var_c & 0xF0) == 0xE0):
                    // characters U-00000800 - U-0000FFFF, mask 1110XXXX
                    $d+=3;
                    break;
                case(($ord_var_c & 0xF8) == 0xF0):
                    // characters U-00010000 - U-001FFFFF, mask 11110XXX
                    $d+=4;
                    break;
                case(($ord_var_c & 0xFC) == 0xF8):
                    // characters U-00200000 - U-03FFFFFF, mask 111110XX
                    $d+=5;
                    break;
                case(($ord_var_c & 0xFE) == 0xFC):
                    // characters U-04000000 - U-7FFFFFFF, mask 1111110X
                    $d+=6;
                    break;
                default:
                    $d++;
            };
        };

        return $d;
    }
}