<?php

namespace App\Models;

use Soda\Core\Base;

class Task extends Base
{
    /**
     * @getter
     * @setter
     */
    protected $id;

    /**
     * @getter
     * @setter
     */
    protected $name;
    
    /**
     * @getter
     * @setter
     */
    protected $email;
    
    /**
     * @getter
     * @setter
     */
    protected $text;
}
