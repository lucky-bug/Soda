<?php

namespace Soda\Core;

class Registry
{
    protected static $instances = [];

    public static function getAll()
    {
        return self::$instances;
    }

    public static function get($key, $default = null)
    {
        return self::$instances[$key] ?? $default;
    }

    public static function set($key, $value)
    {
        self::$instances[$key] = $value;
    }

    public static function erase($key)
    {
        unset(self::$instances[$key]);
    }
}
