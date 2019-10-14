<?php

namespace App\Controllers;

use Soda\Controller\WebController;
use Soda\Http\Response;

class HomeController extends WebController
{
    public function index()
    {
        return new Response('Welcome to Soda!');
    }
}
