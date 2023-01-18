<?php

namespace MvcCore\Rental\Controllers\Frontend;

use MvcCore\Rental\Models\City;
use MvcCore\Rental\Support\Http\Request;
use JTL\Shop;


class CityController
{

    public function index()
    {
        $cities = Country::get();
        $smarty = Shop::Smarty();
        $smarty->assign('cities',$cities);
    }
}