<?php

namespace Soda\Routing;

use Soda\Core\Base;
use Soda\Core\Registry;
use Soda\Routing\Exception\ActionException;
use Soda\Routing\Exception\ControllerException;

class Router extends Base
{
    /**
     * @getter
     * @setter
     */
    protected $url;
    
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

    protected function pass($controller, $action, $parameters)
    {
        $name = ucfirst($controller);
        $this->controller = $controller;
        $this->action = $action;

        try {
            $instance = new $name([
                'parameters' => $parameters,
            ]);

            Registry::set('controller', $instance);
        } catch(\Exception $e) {
            throw new ControllerException("Controller {$name} not found!");
        }

        if (!method_exists($instance, $action)) {
            throw new ActionException("Action {$action} not found!");
        }

        // Todo: run middlewares

        call_user_func_array([
            $instance,
            $action,
        ], is_array($parameters) ? $parameters : []);

        // Todo: things after action

        Registry::erase('controller');
    }

    public function dispatch()
    {
        $url = $this->url;
        $parameters = [];
        $controller = 'example';
        $action = 'index';

        foreach ($this->routes as $route) {
            if ($route->matches($url)) {
                $controller = $route->controller;
                $action = $route->action;
                $parameters = $route->parameters;

                $this->pass($controller, $action, $parameters);

                return;
            }
        }

        $parts = explode('/', trim($url, '/'));
        
        if (count($parts) > 0) {
            $controller = $parts[0];
            
            if (count($parts) > 1) {
                $action = $parts[1];
                $parameters = array_slice($parts, 2);
            }
        }

        $this->pass($controller, $action, $parameters);
    }
}
