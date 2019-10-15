<?php

define('ROOT_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR);

define('APP_DIR', ROOT_DIR . 'app' . DIRECTORY_SEPARATOR);
define('CONTROLLERS_DIR', APP_DIR . 'Controllers' . DIRECTORY_SEPARATOR);
define('VIEWS_DIR', APP_DIR . 'Views' . DIRECTORY_SEPARATOR);

define('CONFIG_DIR', ROOT_DIR . 'config' . DIRECTORY_SEPARATOR);
define('ROUTES_DIR', ROOT_DIR . 'routes' . DIRECTORY_SEPARATOR);

require ROOT_DIR . 'vendor/autoload.php';

function resolve(string $key, $default = null) {
    return Soda\Core\Registry::get($key, $default);
}

function getSession(string $key, $default = null) {
    $session = resolve('session');
    
    return $session->get($key, $default);
}

function setSession(string $key, $value) {
    $session = resolve('session');

    return $session->set($key, $value);
}

try {
    $app = new Soda\Core\Application('dev', true);
    Soda\Core\Registry::set('app', $app);

    $router = new Soda\Routing\Router();
    Soda\Core\Registry::set('router', $router);

    $debugger = new Soda\Debug\Debugger();
    Soda\Core\Registry::set('debugger', $debugger);

    $session = new Soda\Http\Session();
    Soda\Core\Registry::set('session', $session);

    $viewEngine = new Soda\View\SimpleViewEngine();
    Soda\Core\Registry::set('viewEngine', $viewEngine);

    $request = Soda\Http\Request::fromGlobals();
    Soda\Core\Registry::set('request', $request);

    if (file_exists(ROUTES_DIR . 'web.php')) {
        $webRoutes = include(ROUTES_DIR . 'web.php');
        
        foreach ($webRoutes as $route) {
            $router->addRoute(new Soda\Routing\Routes\SimpleRoute($route));
        }
    }

    $router->request = $request;

    $response = $router->dispatch();
    $response->send();
} catch (\Exception $exception) {
    $debugger->handleException($exception);
} catch (\Error $error) {
    $debugger->handleError($error);
}
