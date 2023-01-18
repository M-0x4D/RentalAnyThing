<?php

namespace MvcCore\Rental\Helpers;

use MvcCore\Rental\Support\Facades\Configs\Configs;
use MvcCore\Rental\Support\Debug\Debugger;


class GetPaypalMode
{
    public static function getPaypalUrl()
    {

        $configs = new Configs();
        $paypalMode = isset($configs->get_configs()['PAYPAL_MODE']) ? $configs->get_configs()['PAYPAL_MODE'] : false ;
        $paypalBaseUrl = $configs->get_configs()[$paypalMode];
        return $paypalBaseUrl;
    }
}
