<?php

namespace Soda\Database\Connector;

interface Connector
{
    public function initialize(): self;
    public function connect(): self;
    public function disconnect(): self;
}
