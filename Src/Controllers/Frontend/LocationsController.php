<?php

namespace MvcCore\Rental\Controllers\Frontend;

use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Models\Car;
use MvcCore\Rental\Models\Location;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Support\Facades\Localization\Lang;
use MvcCore\Rental\Support\Http\Request;
use JTL\Shop;
use MvcCore\Rental\Models\ObjectModel;

class LocationsController
{
    public function locations()
    {
        $locations    = Location::all();
        $lang = Lang::get();

        $locations->map(function ($location) use ($lang) {

            $locationName = json_decode($location->location_name);
            $location->location_name = $locationName->$lang;
            unset($location->create_at);
            unset($location->updated_at);
            return $location;
        });


        $smarty = Shop::Smarty();

        $smarty->assign('locations', $locations);
    }

    public function fetch_more_locations(Request $request)
    {
        $locations    =  Location::all();

        $lang = Lang::get();

        $locations->map(function ($location) use ($lang) {

            $locationName = json_decode($location->location_name);
            $location->location_name = $locationName->$lang;
            unset($location->create_at);
            unset($location->updated_at);
            return $location;
        });

        return Response::json([
            'locations' => $locations,
        ], 200);
    }
}
