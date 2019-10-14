<?php

namespace Soda\Core;

class Application
{
    protected $environment;
    protected $debug;

    public function __construct($environment = 'prod', $debug = false)
    {
        $this->environment = $environment;
        $this->debug = $debug;
    }

    public function start()
    {
        echo 'Application started!';

        return $this;
    }

    public function resolve($class, $default = null)
    {
        return Registry::get($class, $default);
    }
}
