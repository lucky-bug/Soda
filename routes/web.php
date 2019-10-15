<?php

return [
    [
        'pattern' => 'home/index',
        'method' => 'GET',
        'controller' => \App\Controllers\HomeController::class,
        'action' => 'index',
        'parameters' => [],
    ],
    [
        'pattern' => 'tasks/index',
        'method' => 'GET',
        'controller' => \App\Controllers\TasksController::class,
        'action' => 'index',
        'parameters' => [],
    ],
    [
        'pattern' => 'tasks/create',
        'method' => 'POST',
        'controller' => \App\Controllers\TasksController::class,
        'action' => 'create',
        'parameters' => [],
    ],
];
