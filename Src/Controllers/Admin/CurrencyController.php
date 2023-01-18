<?php

namespace MvcCore\Rental\Controllers\Admin;

use MvcCore\Rental\Models\Currency;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Helpers\Response;
use JTL\Shop;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Controllers\Admin\ICrud;
use MvcCore\Rental\Models\Color;
use MvcCore\Rental\Models\ObjectModel;
use MvcCore\Rental\Models\Label;
use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Models\Rental;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Models\Description;



class CurrencyController implements ICrud
{
    function index()
    {

        $currencies = Currency::get();
        $smarty = Shop::Smarty();
        return $smarty->assign('currencies', $currencies);
    }

    function create(Request $request)
    {
        $data = $request->all();
        $currencyDublicated = Currency::where('name' , $data['currency_name'])->where('currency_code' , $data['currency_code'])->first();
        if (!$currencyDublicated) {
            Currency::create([
                'name' => $data['currency_name'],
                'currency_code' => $data['currency_code']
            ]);
        }
        else {
            return Response::json('this currency is exists', 404);
        }
        
        return Response::json('Record is created successfully', 201);
    }


    function update(Request $request)
    {
        $data = $request->all();
        $currencyDublicated = Currency::where('name' , $data['currency_name'])->where('currency_code' , $data['currency_code'])->first();
        if (!$currencyDublicated) {
            Currency::where('id', $data['currency_id'])->update([
                'name' => $data['currency_name'],
                'currency_code' => $data['currency_code']
    
            ]);
        return Response::json('Record is updated successfully' , 206);
        }
        else {
            return response()->json('this color is exists', 404);
        }

    }

    function destroy(Request $request)
    {
        $data = $request->all();
        $objects = ObjectModel::where('currency_id', $data['currency_id'])->get();
        $objects->map(function ($object) {
            $imagePath = Image::where('object_id', $object->id)->pluck('imagePath')->first();
            $fileService = new UploadingService();
            $fileService->deleteFile($imagePath, 'objects');
            Image::where('object_id', $object->id)->delete();
            Description::where('object_id', $object->id)->delete();
            Label::where('object_id', $object->id)->delete();
            Rental::where('object_id', $object->id)->delete();
        });
        ObjectModel::where('currency_id', $data['currency_id'])->delete();
        Currency::where('id', $data['currency_id'])->delete();
        return Response::json('Record is deleted successfully', 204);
    }
}
