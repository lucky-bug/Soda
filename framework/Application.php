<?php

namespace Soda;

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
        echo "Application started!";

        return $this;
    }
}
