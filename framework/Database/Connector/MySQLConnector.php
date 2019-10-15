<?php

namespace Soda\Database\Connector;

use mysqli;
use mysqli_result;
use Soda\Core\Base;
use Soda\Database\Exception\DatabaseServiceException;
use Soda\Database\Query\MySQLQuery;

class MySQLConnector extends Base implements Connector
{
    /**
     * @var mysqli
     */
    protected $service;

    /**
     * @getter
     * @setter
     * @var string
     */
    protected $host;

    /**
     * @getter
     * @setter
     * @var int
     */
    protected $port;

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

    /**
     * @getter
     * @setter
     * @var string
     */
    protected $database;

    /**
     * @getter
     * @setter
     * @var bool
     */
    protected $connected;

    public function __construct($options = [])
    {
        $this->host = 'localhost';
        $this->port = 3306;
        $this->username = 'soda';
        $this->password = 'secret';
        $this->database = 'soda_db';
        $this->connected = false;
        parent::__construct($options);
    }

    public function initialize(): Connector
    {
        $this->connect();
        return $this;
    }

    protected function isValidService(): bool
    {
        $isEmpty = empty($this->service);
        $isInstance = $this->service instanceof mysqli;

        if ($this->connected && $isInstance && !$isEmpty) {
            return true;
        }

        return false;
    }

    public function connect(): Connector
    {
        if (!$this->isValidService()) {
            $this->service = new mysqli(
                $this->host,
                $this->username,
                $this->password,
                $this->database,
                $this->port
            );

            if ($this->service->connect_error) {
                throw new DatabaseServiceException('Unable to connect to service');
            }

            $this->connected = true;
        }

        return $this;
    }

    public function disconnect(): Connector
    {
        if ($this->isValidService()) {
            $this->connected = false;
            $this->service->close();
        }

        return $this;
    }

    public function execute(string $sql)
    {
        if (!$this->isValidService()) {
            throw new DatabaseServiceException('Not connected to a valid service!');
        }

        return $this->service->query($sql);
    }

    public function escape(string $value): string
    {
        if (!$this->isValidService()) {
            throw new DatabaseServiceException('Not connected to a valid service!');
        }

        return $this->service->real_escape_string($value);
    }

    public function getLastInsertId()
    {
        if (!$this->isValidService()) {
            throw new DatabaseServiceException('Not connected to a valid service!');
        }

        return $this->service->insert_id;
    }

    public function getAffectedRow(): int
    {
        if (!$this->isValidService()) {
            throw new DatabaseServiceException('Not connected to a valid service!');
        }

        return $this->service->affected_rows;
    }

    public function getLastError(): string
    {
        if (!$this->isValidService()) {
            throw new DatabaseServiceException('Not connected to a valid service!');
        }

        return $this->service->error;
    }
}
