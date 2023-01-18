<?php

namespace MvcCore\Rental\Support\Http;

use MvcCore\Rental\Support\Debug\Debugger;
use JTL\Session\Frontend;
use MvcCore\Rental\Models\User;


class Request
{
    private static array $data = [];

    private static array $routeParams = [];
    private static $userId = null;
    private static $user = null;

    public function __construct()
    {
        $customer          = Frontend::getCustomer();
        if (isset($customer->kKunde)) {
            self::$userId = $customer->kKunde;
        }
        if (!!$_GET) {
            foreach ($_GET as $key => $item) {
                self::$data[$key] = filter_input(INPUT_GET, $key,  FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if (!!$_POST) {

            foreach ($_POST as $key => $item) {

                if (is_array($item)) {

                    $re = "/[^A-Za-z0-9]+/";
                     
                    self::$data[$key] = array_map(fn ($cell) => preg_replace($re, "", $cell), $item);
                } else {

                    self::$data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
        if (!!$_FILES) {
            foreach ($_FILES as $key => $file) {
                self::$data[$key] = $file;
            }
        }

        $data =file_get_contents('php://input');

        if (!!$data) {
            $data = json_decode($data, true);
            if ((is_array($data)) && (count($data) > 0)) {
                foreach ($data as $key => $item) {
                    self::$data[$key] = filter_var($item,  FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }


    }


    public static function type()
    {
        if (isset($_POST['_method']) && $_POST['_method'] === 'PUT') {
            return strtoupper($_POST['_method']);
        }
        if (isset($_POST['_method']) && $_POST['_method'] === 'PATCH') {
            return strtoupper($_POST['_method']);
        }
        if (isset($_GET['_method']) && $_GET['_method'] === 'DELETE') {
            return strtoupper($_GET['_method']);
        }
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public static function uri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function all()
    {
        return self::$data;
    }

    public function set_route_params($params): self
    {
        foreach ($params as  &$param) {
            filter_var($param,  FILTER_SANITIZE_SPECIAL_CHARS);
        }
        unset($param);
        self::$routeParams = $params;
        return $this;
    }

    public function get_route_params(): array
    {
        return self::$routeParams;
    }

    public function unset(...$elements)
    {
        foreach ($elements as $element) {
            unset(self::$data[$element]);
        }
    }


    public function user()
    {
        self::$user = User::where('kKunde' , self::$userId)->first();
        return self::$user;
    }


    


    public function file($key)
    {
        return self::$data[$key];
    }

}
