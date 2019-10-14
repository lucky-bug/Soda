<?php

namespace Soda\Routing\Routes;

use Soda\Core\Base;

abstract class Route extends Base
{
    /**
     * @getter
     * @setter
     */
    protected $pattern = 'example/example';

    /**
     * @getter
     * @setter
     */
    protected $method = 'GET';
    
    /**
     * @getter
     * @setter
     */
    protected $controller = 'example';
    
    /**
     * @getter
     * @setter
     */
    protected $action = 'example';
    
    /**
     * @getter
     * @setter
     */
    protected $parameters = [];
}
