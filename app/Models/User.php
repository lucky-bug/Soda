<?php

namespace App\Models;

use Soda\Core\Base;

class User extends Base
{
    /**
     * @getter
     * @setter
     * @var string
     */
    protected $username;

    /**
     * @getter
     * @setter
     * @var string
     */
    protected $password;
}
