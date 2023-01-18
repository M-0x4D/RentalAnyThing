<?php

namespace MvcCore\Rental\Support;

class Plugin
{

    private static $plugin;


    function set_plugin($plugin)
    {
        self::$plugin = $plugin;
    }

    function get_plugin()
    {

        return self::$plugin;
    }
}