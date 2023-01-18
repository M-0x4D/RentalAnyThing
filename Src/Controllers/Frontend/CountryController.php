<?php

namespace MvcCore\Rental\Controllers\Frontend;

use MvcCore\Rental\Models\Country;
use MvcCore\Rental\Support\Http\Request;
use JTL\Shop;
use MvcCore\Rental\Models\Governrate;

class CountryController
{

    public function index()
    {
        $countries = Country::get();
        foreach ($countries as $key => $country) {
            if (isset($country->name)) {
                $country->name = json_decode($country->name);
            }
        }
        $smarty = Shop::Smarty();
        $smarty->assign('countries', $countries);
    }


    public function returnGovernrates(Request $request)
    {
        $data = $request->all();
        $governrates = Governrate::where('country_id', $data['country_id'])->get();
        foreach ($governrates as $governrate) {
            $governrate->name = json_decode($governrate->name);
        }
        return response()->json($governrates,200);
    }
}
