<?php

namespace Soda\Controller;

use Soda\Core\Base;
use Soda\Http\Request;

class WebController extends Base
{
    /**
     * @getter
     * @setter
     */
    protected $parameters;

    /**
     * @getter
     * @setter
     * @var Request
     */
    protected $request;
}
