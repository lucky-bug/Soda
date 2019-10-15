<?php

namespace Soda\Database;

use Soda\Core\Base;
use Soda\Core\Exception\ArgumentException;
use Soda\Database\Connector\MySQLConnector;

class DatabaseFactory extends Base
{
    /**
     * @getter
     * @setter
     */
    protected $type;

    /**
     * @getter
     * @setter
     */
    protected $options;

    public function initialize()
    {
        if (!$this->type) {
            throw new ArgumentException('Invalid type!');
        }

        switch($this->type) {
            case 'mysql':
                return new MySQLConnector($this->options);
            default:
                throw new ArgumentException('Invalid type');
        }
    }
}
