<?php

namespace MvcCore\Rental\Controllers\Frontend;

use MvcCore\Rental\Controllers\Repository\getCarsById;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Requests\getObjectDetailsRequest;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Session\AbstractSession;
use MvcCore\Rental\Helpers\Redirect;
use MvcCore\Rental\Support\Http\Server;
use MvcCore\Rental\Support\DisplayData;
use MvcCore\Rental\Support\Facades\Localization\Lang;
use MvcCore\Rental\Support\Debug\Debugger;
use JTL\Shop;
use MvcCore\Rental\Models\Car;



class CarsDetailsController
{
    public function carDetails(Request $request)
    {
        $link = new Server;
        $previousUrl = $link->previous_url();

        if (!!strpos($previousUrl, 'rental') === 0 || !!strpos($previousUrl, 'vermietung')  === 0) {
            Redirect::homeWith('/Home');
        }
        $lang = Lang::get();

        if ($lang === 'en') {
            Redirect::homeWith('/car-details');
        } else {
            Redirect::homeWith('/auto-details');
        }
    }

    public function objectDetailsSmarty()
    {
        $arr = explode("?redirect=pick-object&objectId=", $_SERVER['REQUEST_URI']) ? explode("?redirect=pick-object&objectId=", $_SERVER['REQUEST_URI']) : null;
        if (isset($arr[1]) && $arr[1] !== '' && is_numeric($arr[1]) &&  $arr[0] ===  '/car-details' || $arr[0] === '/auto-details') {

            $validator = new getObjectDetailsRequest;
            $validatedData = $validator->validate($arr);
            $objectId = +$validatedData['objectId'];

            $objectIds = Car::get()->pluck('id')->toArray();
            if (in_array($objectId, $objectIds)) {
                $getCar = new getCarsById;
                $cars = $getCar->get($objectId);
                $smarty = Shop::Smarty();
                $smarty->assign('auto_details', $cars);
            } else {
                Redirect::homeWith('/rental');
            }
        } elseif ($arr[0] ===  '/object-details' || $arr[0] === '/auto-details') {

            Redirect::homeWith('/rental');
        }
    }



    // function carDetailsSmartyV2(Request $request)
    // {
    //     $data = $request->all();
    //     if (isset($data)) {
    //         $validator = new getCarDetailsRequest;
    //         $validatedData = $validator->validate($data);

    //         $carId = +$validatedData['id'];
    //         $getCar = new getCarsById;
    //         $carDetails = $getCar->get($carId);
    //         $smarty = Shop::Smarty();
    //         $smarty->assign('auto_details', $carDetails);
    //     }

    // }
}
