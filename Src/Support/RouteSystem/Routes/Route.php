<?php

namespace MvcCore\Rental\Support;

use MvcCore\Rental\Exceptions\RouteNotFoundException;

class Route
{
    /**
     * plugin routes
     *
     * @var array
     */
    private static array $routes;

    /**
     * get request
     *
     * @param  $route
     * @param  $action
     * @return void
     */
    public static function get($route, $action)
    {
        self::register($route, 'get', $action);
    }

    /**
     * post request
     *
     * @param  $route
     * @param  $action
     * @return void
     */
    public static function post($route, $action)
    {
        self::register($route, 'post', $action);
    }

    /**
     * put request
     *
     * @param  $route
     * @param  $action
     * @return void
     */
    public static function put($route, $action)
    {
        self::register($route, 'put', $action);
    }

    /**
     * patch request
     *
     * @param  $route
     * @param  $action
     * @return void
     */
    public static function patch($route, $action)
    {
        self::register($route, 'patch', $action);
    }

    /**
     * delete request
     *
     * @param  $route
     * @param  $action
     * @return void
     */
    public static function delete($route, $action)
    {
        self::register($route, 'delete', $action);
    }

    /**
     * register routes
     *
     * @param string $route
     * @param string $Request
     * @param  $action
     * @return void
     */
    public static function register(string $route, string $Request, $action)
    {
        // ! routes[get|post][path] = controller@method
        self::$routes[$Request][$route] = $action;
    }

    /**
     * resolve routes
     *
     * @param [string] $route
     * @param [string] $Request
     * @return RouteHandler
     */
    public static function resolve(string $fetch, string $request, Object $smarty = null, int $plugin = null)
    {
        if (!!strpos($fetch, '?') === false) {
            return;
        }
        $fetch = explode('?', $fetch)[1] ?? null;
        if (!$fetch) {
            return;
        }

        if (strpos($fetch, 'return') === 0) {
            $fetch = explode('=', $fetch)[1];
            $route = explode('&', $fetch)[0];
            $action = self::$routes[$request][$route] ?? null;

            if (!$action) {
                throw new RouteNotFoundException();
            }
            return RouteHandler::call($action, $smarty, $plugin);
        }

        if (strpos($fetch, 'redirect') === 0) {
            $fetch = explode('=', $fetch)[1];
            $route = explode('&', $fetch)[0];

            $action = self::$routes[$request][$route] ?? null;
        
            if (!$action) {
                throw new RouteNotFoundException();
            }
            return RouteHandler::call($action, $smarty, $plugin);
        }

        if (!!strpos($fetch, '&') === true) {
            $fetch = explode('&', $fetch)[1];
        } else {
            $route = explode('=', $fetch)[1];
            if ((int)$plugin === (int)$route) {
                return;
            }
        }
        $route = explode('=', $fetch)[1];

        $action = self::$routes[$request][$route] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }
        return RouteHandler::call($action, $smarty, $plugin);
    }

    public static function execute($controllerMethod, Object $smarty = null, int $plugin = null)
    {
        return RouteHandler::call($controllerMethod, $smarty, $plugin);
    }

    public static function group(array $middlewares, callable $callback)
    {
        foreach ($middlewares as $middleware) {
            MiddlewareHandler::call($middleware);
        };
        return call_user_func($callback);
    }

    public static function  routes_list(): array
    {
        return self::$routes;
    }
}
