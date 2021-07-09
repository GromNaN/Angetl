<?php

namespace Angetl\Utils;

class Encoding
{
    /**
     * Detect if the string is encoded in UTF-8.
     *
     * @param string $string The tested string.
     * @access public
     * @return boolean True if the string is in UTF-8, false otherwhise.
     * @link http://www.php.net/manual/en/function.mb-detect-encoding.php#68607
     */
    public static function isUtf8($string)
    {
        return preg_match('%(?:'
            . '[\xC2-\xDF][\x80-\xBF]'                // non-overlong 2-byte
            . '|\xE0[\xA0-\xBF][\x80-\xBF]'           // excluding overlongs
            . '|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}'    // straight 3-byte
            . '|\xED[\x80-\x9F][\x80-\xBF]'           // excluding surrogates
            . '|\xF0[\x90-\xBF][\x80-\xBF]{2}'        // planes 1-3
            . '|[\xF1-\xF3][\x80-\xBF]{3}'            // planes 4-15
            . '|\xF4[\x80-\x8F][\x80-\xBF]{2}'        // plane 16
            . ')+%xs', $string);
    }

    public static function toUtf8($string)
    {
        return utf8_encode($string);
    }
}
