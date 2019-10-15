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
    [
        'pattern' => 'tasks/delete',
        'method' => 'POST',
        'controller' => \App\Controllers\TasksController::class,
        'action' => 'delete',
        'parameters' => [],
    ],
    [
        'pattern' => 'tasks/edit/:id',
        'method' => 'GET',
        'controller' => \App\Controllers\TasksController::class,
        'action' => 'edit',
        'parameters' => [],
    ],
    [
        'pattern' => 'auth/login',
        'method' => 'POST',
        'controller' => \App\Controllers\AuthController::class,
        'action' => 'login',
        'parameters' => [],
    ],
    [
        'pattern' => 'auth/logout',
        'method' => 'GET',
        'controller' => \App\Controllers\AuthController::class,
        'action' => 'logout',
        'parameters' => [],
    ],
];
