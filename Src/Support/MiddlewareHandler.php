<?php

namespace MvcCore\Rental\Support;


class MiddlewareHandler
{
    const MIDDLEWARES_NAMESPACE = 'MvcCore\Rental\Middlewares';
    const METHOD = 'handle';

    public static function call(string $middleware)
    {
        if (is_string($middleware)) {
            $middleware = self::MIDDLEWARES_NAMESPACE .'\\'. $middleware;

            if (class_exists($middleware)) {
                 $middleware = new $middleware();
                if (method_exists($middleware, self::METHOD)) {
                    return call_user_func([$middleware, self::METHOD]);
                }
            }
        }
    }
}
