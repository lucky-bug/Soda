<?php

define('ROOT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

require ROOT_PATH . 'vendor/autoload.php';

$app = new Soda\Core\Application('dev', true);
Soda\Core\Registry::set('app', $app);

$router = new Soda\Routing\Router();
Soda\Core\Registry::set('router', $router);

$debugger = new Soda\Debug\Debugger();
Soda\Core\Registry::set('debugger', $debugger);

class HomeController extends Soda\Core\Controller
{
    public function index()
    {
        throw new Soda\Core\Exception\CoreException("Some error");
        echo sprintf('Home Index %s', $this->parameters['id']);
    }
}

$route = new Soda\Routing\Routes\SimpleRoute([
    'pattern' => 'home/index/:id',
    'controller' => HomeController::class,
    'action' => 'index',
]);

$router->addRoute($route);
$router->url = 'home/index/366';

try {
    $router->dispatch();
} catch(\Exception $exception) {
    $debugger->handleException($exception);
}
