<?php

namespace Soda\Debug;

use Error;
use Exception;

class Debugger
{
    public function handleException(Exception $exception)
    {
        $class = get_class($exception);
        $message = $exception->getMessage();
        $trace = $exception->getTraceAsString();
        echo "<h3>{$class}</h3>";
        echo "<p>{$message}</p>";
        echo "<pre>{$trace}</pre>";
    }

    public function handleError(Error $error)
    {
        $class = get_class($error);
        $message = $error->getMessage();
        $trace = $error->getTraceAsString();
        echo "<h3>{$class}</h3>";
        echo "<p>{$message}</p>";
        echo "<pre>{$trace}</pre>";
    }
}
