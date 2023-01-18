<?php

namespace GlobalFunctions;
use MvcCore\Rental\Helpers\Redirect;
use JTL\Session\AbstractSession;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Support\Http\Session;



class GlobalHelper
{
    static function redirect()
    {
        return new static();
    }

    function route(string $route)
    {
        Redirect::homeWith($route);
    }

    static function view($route)
    {
        return new static();
    }

    function with( array $params)
    {

    }

    // session 
    static function session()
    {
        return new static;
    }

    function set($key , $value)
    {
            (new Session)->add_items([$key => $value]);
    }
    function get(string $sessionKey)
    {
            (new Session)->get_items($sessionKey);
    }


    public function remove(string ...$items): bool
    {
        foreach ($items as $item) {
            unset($_SESSION[$item]);
        }
        return true;
    }

    public function clear(): bool
    {
        $_SESSION = [];
        return true;
    }


    static function response()
    {
        return new static;
    }


    function json($params,$statusCode=200)
    {
        Response::json($params,$statusCode);
    }
}