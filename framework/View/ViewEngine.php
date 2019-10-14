<?php

namespace Soda\View;

use Soda\Core\Base;

abstract class ViewEngine extends Base
{
    protected $viewsDir = VIEWS_DIR ?? '';
}
