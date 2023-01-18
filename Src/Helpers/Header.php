<?php

namespace MvcCore\Rental\Helpers;

class Header
{
    public static function checkHeaderContain(String $key, String $content)
    {
        $headers = getallheaders();
        $header = array_key_exists($key, $headers) ? $headers[$key] : '';
        return $header === $content ? true : false;
    }

    public static function checkHeaderHas(String $key)
    {
        $headers = getallheaders();
        return  array_key_exists($key, $headers);
    }

    public static function setHeader(String $key, String $content)
    {
        header("$key: $content");
    }
}
