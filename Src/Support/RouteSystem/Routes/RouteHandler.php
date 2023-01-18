<?php

namespace MvcCore\Rental\Support;

use MvcCore\Rental\Support\Http\Request;

class RouteHandler
{
    const CONTROLLERS_NAMESPACE = 'MvcCore\Rental\Controllers';

    public static function call($handler, ?Object $smarty = null, ?int $plugin = null)
    {
        $request = new Request(); 
        if (is_array($handler)) {
            [$class, $method] = $handler;
            $class = self::CONTROLLERS_NAMESPACE . '\\' . $class;
            if (class_exists($class)) {
                $class = new $class;
                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], [$request, $smarty, $plugin]);
                }
            }
        }
        if (is_string($handler)) {
            [$class, $method] = explode('@', $handler);
            $class = self::CONTROLLERS_NAMESPACE . '\\' . $class;
            if (class_exists($class)) {
                $class = new $class;
                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], [$request, $smarty, $plugin]);
                }
            }
        }
        if (is_callable($handler)) {
            return call_user_func_array($handler, [$request, $smarty, $plugin]);
        }
    }
}
