<?php

namespace App\Controllers;

use Soda\Controller\WebController;
use Soda\Http\Response;

class HomeController extends WebController
{
    public function index()
    {
        $content = resolve('viewEngine')->render('home.index');
        return new Response($content);
    }
}
