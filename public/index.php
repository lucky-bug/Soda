<?php

define('ROOT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('CONFIG_PATH', ROOT_PATH . 'config' . DIRECTORY_SEPARATOR);
define('ROUTES_PATH', ROOT_PATH . 'routes' . DIRECTORY_SEPARATOR);

require ROOT_PATH . 'vendor/autoload.php';

try {
    $app = new \Soda\Core\Application('dev', true);
    \Soda\Core\Registry::set('app', $app);

    $router = new \Soda\Routing\Router();
    \Soda\Core\Registry::set('router', $router);

    $debugger = new \Soda\Debug\Debugger();
    \Soda\Core\Registry::set('debugger', $debugger);

    $session = new \Soda\Http\Session([]);
    \Soda\Core\Registry::set('session', $session);

    $request = \Soda\Http\Request::fromGlobals();
    \Soda\Core\Registry::set('request', $request);

    if (file_exists(ROUTES_PATH . 'web.php')) {
        $webRoutes = include(ROUTES_PATH . 'web.php');
        
        foreach ($webRoutes as $route) {
            $router->addRoute(new \Soda\Routing\Routes\SimpleRoute($route));
        }
    }

    $router->url = $request->getUrl();

    $response = $router->dispatch();
    $response->send();
} catch (\Exception $exception) {
    $debugger->handleException($exception);
} catch (\Error $error) {
    $debugger->handleError($error);
}
