<?php

namespace App\Controllers;

use Soda\Controller\WebController;
use Soda\Http\Response;

class TasksController extends WebController
{
    public function index()
    {
        $content = resolve('viewEngine')->render('tasks.index');
        return new Response($content);
    }
}
