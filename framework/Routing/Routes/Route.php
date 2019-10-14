<?php

namespace Soda\Routing\Routes;

use Soda\Core\Base;

class Route extends Base
{
    /**
     * @getter
     * @setter
     */
    protected $pattern;
    
    /**
     * @getter
     * @setter
     */
    protected $controller;
    
    /**
     * @getter
     * @setter
     */
    protected $action;
    
    /**
     * @getter
     * @setter
     */
    protected $parameters = [];
}
