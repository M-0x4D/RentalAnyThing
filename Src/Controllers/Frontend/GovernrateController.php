<?php

namespace MvcCore\Rental\Controllers\Frontend;

use MvcCore\Rental\Models\Governrate;
use MvcCore\Rental\Models\City;
use MvcCore\Rental\Support\Http\Request;
use JTL\Shop;


class GovernrateController
{

    public function index()
    {
        $governrates = Governrate::get();
        $smarty = Shop::Smarty();
        $smarty->assign('governrates',$governrates);
    }


    public function returnCities(Request $request)
    {
        $data = $request->all();
        $cities = City::where('governrate_id', $data['governorate_id'])->get();
        foreach ($cities as $city) {
            $city->name = json_decode($city->name);
        }
        return response()->json($cities,200);
    }
}