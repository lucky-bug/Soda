<?php

namespace Soda\Http;

use Soda\Core\Base;

class Session extends Base
{
    public function __construct($options = [])
    {
        parent::__construct($options);
        session_start();
    }

    public function get(string $key, $default = null)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return $default;
    }

    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
        
        return $this;
    }

    public function erase(string $key)
    {
        unset($_SESSION[$key]);
        
        return $this;
    }

    public function renew(bool $deleteOld = false)
    {
        session_regenerate_id($deleteOld);

        return $this;
    }
    
    public function __destruct()
    {
        session_commit();
    }
}
