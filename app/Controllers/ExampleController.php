<?php

namespace App\Controllers;

use Soda\Core\Controller;
use Soda\Http\Response;

class ExampleController extends Controller
{
    public function index()
    {
        return new Response('Index action from Example controller says ' . $this->parameters['id'] . '!');
    }
}