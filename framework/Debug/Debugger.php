<?php

namespace Soda\Debug;

use Error;
use Exception;
use Soda\Http\Response;

class Debugger
{
    public function handleException(Exception $exception)
    {
        $data = [
            'code' => $exception->getCode() > 0 ? $exception->getCode() : 500,
            'class' => get_class($exception),
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ];

        $response = new Response(resolve('viewEngine')->render('errors.index', $data), $data['code']);
        $response->send();
    }

    public function handleError(Error $error)
    {
        $data = [
            'code' => $error->getCode() > 0 ? $error->getCode() : 500,
            'class' => get_class($error),
            'message' => $error->getMessage(),
            'trace' => $error->getTraceAsString(),
        ];

        $response = new Response(resolve('viewEngine')->render('errors.index', $data), $data['code']);
        $response->send();
    }
}
