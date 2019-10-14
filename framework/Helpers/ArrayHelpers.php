<?php

namespace Soda\Helpers;

class ArrayHelpers
{
    private function __construct()
    {
        // do nothing
    }

    private function __clone()
    {
        // do nothing
    }

    public static function clean($array)
    {
        return array_filter($array, function ($item) {
            return !empty($item);
        });
    }

    public static function trim($array)
    {
        return array_map(function ($item) {
            return trim($item);
        }, $array);
    }

    public static function flatten($array, $return = [])
    {
        foreach ($array as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $return = self::flatten($value, $return);
            } else {
                $return[] = $value;
            }
        }
        
        return $return;
    }
}
