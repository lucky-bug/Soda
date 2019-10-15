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

function eraseSession(string $key) {
    $session = resolve('session');

    return $session->erase($key);
}

function renewSession(bool $deleteOld) {
    $session = resolve('session');

    return $session->renew($deleteOld);
}

function url(string $url, array $query = [], bool $sendOld = false) {
    /**
     * @var Soda\Http\Request $request
     */
    $request = resolve('request');
    if ($request->get(Soda\Http\Request::QUERY_URL_PARAM)) {
        $query[Soda\Http\Request::QUERY_URL_PARAM] = $url;
        $url = '/';
    }

    $url = '/' . trim($url, '/');

    if ($sendOld) {
        $query = array_merge($_GET, $query);
    }

    if (count($query) == 0) {
        return $url;
    }

    $queryString = implode('&', array_map(
        function($value, $key) {
            if(is_array($value)){
                return $key.'[]='.implode('&'.$key.'[]=', $value);
            }else{
                return $key.'='.$value;
            }
        },
        $query,
        array_keys($query)
    ));

    return $url . '?' . $queryString;
}

function authenticated() {
    return getSession('user') != null;
}

function getAuthUser() {
    return getSession('user');
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

    $router->setRequest($request);

    $response = $router->dispatch();
    $response->send();
} catch (\Exception $exception) {
    $debugger->handleException($exception);
} catch (\Error $error) {
    $debugger->handleError($error);
}
