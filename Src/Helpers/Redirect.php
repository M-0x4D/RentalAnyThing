<?php

namespace MvcCore\Rental\Helpers;

class Redirect
{
    protected static $previous_url;
    protected static $home;

    public static function to($url)
    {
        header('Location:' . $url);
        exit;
    }

    public static function back()
    {
        self::$previous_url = $_SERVER['HTTP_REFERER'];
        header('Location:' . self::$previous_url);
        exit;
    }

    public static function homeWith($url)
    {
        $home = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $fullHost = $_SERVER['HTTP_HOST'];
        header("Location:" .$home . $fullHost . $url);
        exit;
    }
}
