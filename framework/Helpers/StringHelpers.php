<?php

namespace Soda\Helpers;

class StringHelpers
{
    private static $delimiter = '#';

    private function __construct()
    {
        // do nothing
    }

    private function __clone()
    {
        // do nothing
    }

    private static function normalize($pattern)
    {
        return self::$delimiter . trim($pattern, self::$delimiter) . self::$delimiter;
    }

    public static function getDelimiter()
    {
        return self::$delimiter;
    }

    public static function setDelimiter($delimiter)
    {
        self::$delimiter = $delimiter;
    }

    public static function match($string, $pattern)
    {
        preg_match_all(self::normalize($pattern), $string, $matches, PREG_PATTERN_ORDER);

        if (!empty($matches[1])) {
            return $matches[1];
        }

        if (!empty($matches[0])) {
            return $matches[0];
        }

        return [];
    }

    public static function split($string, $pattern, $limit = null)
    {
        $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE;

        return preg_split(self::normalize($pattern), $string, $limit, $flags);
    }
}
