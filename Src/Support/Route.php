<?php

namespace MvcCore\Rental\Support;

use MvcCore\Rental\Exceptions\RouteNotFoundException;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Support\Facades\Configs\ConfigurationsLoader;
use MvcCore\Rental\Support\Facades\Middleware\RegisterMiddlewares;
use MvcCore\Rental\Support\Http\Request;

class Route
{
    /**
     * plugin routes
     *
     * @var array
     */
    private static array $routes;
    private static array $routesWithName;





    /**
     * name of route
     * @param string $routeName
     */
    public function name($routeName)
    {
        // self::$routesName[] = [self::$route,$routeName];
    }


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
     * 
     */
    public static function post($route, $action)
    {
        self::register($route, 'post', $action);

        // self::$routesWithName += [$route , ''];
        // return new static;
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
    public static function register(string $endpoint, string $methodType, $action)
    {
        $methodType = strtoupper($methodType);
        // if (is_array($action)) {
        //     $controller = $action[0];
        //     $method = $action[1];
        //     self::$routes[$endpoint][$methodType][$controller] = $method;
        // }
        // ! routes[get|post][path] = controller@method
        self::$routes[$methodType][$endpoint] = $action;
    }



    /**
     * resolve routes
     *
     * @param [string] $route
     * @param [string] $Request
     * 
     */
    function finalResolve($endPoint , $methodType)
    {
        foreach (self::$routes as $key => $value) {
            if ($value === $endPoint) {
                
            }
        }

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
        if (!!strpos($fetch , 'return') === false) {
            return;
        }
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



    public static function resolveApi(string $route, string $requestType)
    {
        $route = explode('io.php', $route)[1];
        // $configurationLoader = new ConfigurationsLoader();
        
        //! io parameter in request
        // if ($request->all()['io'] !== $configurationLoader->get('ENTRY_POINT')) return;
        
        if (stripos($route, '?')) {
            $route = explode('?', $route)[0];
        }
        $action = self::$routes[$requestType][$route] ?? null;

        if (!$action) {
            $action = self::get_action($requestType, $route);
            if ($action === false) {
                throw new RouteNotFoundException();
            }
        }

        if ($route === '/csrf-token') {
            $middlewares = RegisterMiddlewares::get_route_middleware_to_call();
            foreach ($middlewares as $middleware) {
                $middleware = new $middleware();
                $middleware->handle();
            }
            return RouteHandler::call($action);
        }
        if ($route === '/licensekey') {
            $middlewares = RegisterMiddlewares::get_route_middleware_to_call();
            foreach ($middlewares as $middleware) {
                $middleware = new $middleware();
                $middleware->handle();
            }
            return RouteHandler::call($action);
        }
        $middlewares = RegisterMiddlewares::list_called_middlewares();
        foreach ($middlewares as $key => $middleware) {
            $middleware = new $middleware();
            $middlewareAction = $middleware->get_action($action);

            if ($middlewareAction === $action) {
                $middleware->handle();
            }
        }
        return RouteHandler::call($action);
    }

/***
 * 
 *  ! for routes parameter like --> localhost/test/{id}
 */
    public static function get_action(...$action)
    {
        [$requestType, $route] = $action;

        // get the request uri
        $uri = $route;

        // trim slashes from request uri
        $uri = trim($uri, '/');
        // get all routes for request type
        $routes = self::$routes[$requestType] ?? [];

        //route params 
        $routeParams = false;

        foreach ($routes as $route => $action) {
            // trim slashes for registered routes
            $route = trim($route, '/');
            $routeNames = [];

            if (!$route) {
                continue;
            }
            // find all route names from route  and save it in $routeNames 
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }
            // convert route name intor regex pattern
            $routeRegex = "@^" . preg_replace_callback(
                '/\{(\w+)(:[^}]+)?}/',
                fn ($match) => isset($match[2]) ? "({$match[2]})" : '(\w+)',
                $route
            ) . "$@";

            // test and match current route against $routeRegex
            if (preg_match_all($routeRegex, $uri, $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $routeParams = array_combine($routeNames, $values);
                $request = new Request();
                $request->set_route_params($routeParams);
                return $action;
            }
        }
        return false;
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
