<?php

namespace Soda\Routing;

use Soda\Core\Base;
use Soda\Core\Registry;
use Soda\Helpers\ArrayHelpers;
use Soda\Http\Response;
use Soda\Routing\Exception\ActionException;
use Soda\Routing\Exception\ControllerException;

class Router extends Base
{
    /**
     * @getter
     * @setter
     */
    protected $request;

    /**
     * @getter
     * @setter
     */
    protected $extension;

    /**
     * @getter
     */
    protected $controller;

    /**
     * @getter
     */
    protected $action;

    protected $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function addRoute($route)
    {
        $this->routes[] = $route;

        return $this;
    }

    public function removeRoute($route)
    {
        foreach ($this->routes as $i => $stored) {
            if ($stored == $route) {
                unset($this->routes[$i]);
            }
        }

        return $this;
    }

    public function getRoutes()
    {
        $list = [];

        foreach ($this->routes as $route) {
            $list[$route->pattern] = get_class($route);
        }

        return $list;
    }

    protected function pass($controller, $action, $parameters): Response
    {
        $name = ucfirst($controller);
        $this->controller = $controller;
        $this->action = $action;

        if (!class_exists($name)) {
            throw new ControllerException("Controller {$name} not found!");
        }

        $instance = new $name([
            'parameters' => $parameters,
            'request' => Registry::get('request'),
        ]);

        Registry::set('controller', $instance);

        if (!method_exists($instance, $action)) {
            throw new ActionException("Action {$action} not found!");
        }

        // Todo: run middlewares

        $response = call_user_func_array([$instance, $action], is_array($parameters) ? $parameters : []);
        Registry::set('response', $response);

        // Todo: things after action

        Registry::erase('controller');
        
        return $response;
    }

    public function dispatch(): Response
    {
        $url = $this->request->url;
        $parameters = [];
        $controller = 'home';
        $action = 'index';

        foreach ($this->routes as $route) {
            if ($route->matches($url, $this->request->getMethod())) {
                $controller = $route->controller;
                $action = $route->action;
                $parameters = $route->parameters;

                return $this->pass($controller, $action, $parameters);
            }
        }

        $parts = ArrayHelpers::clean(
            ArrayHelpers::trim(
                explode('/', trim($url, '/'))
            )
        );

        if (count($parts) > 0) {
            $controller = $parts[0];

            if (count($parts) > 1) {
                $action = $parts[1];
                $parameters = array_slice($parts, 2);
            }
        }

        return $this->pass(
            'App\\Controllers\\' . ucfirst($controller) . 'Controller',
            strtolower($this->request->method) . ucfirst($action),
            $parameters
        );
    }
}
