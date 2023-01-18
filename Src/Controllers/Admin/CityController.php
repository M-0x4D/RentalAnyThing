<?php

namespace MvcCore\Rental\Controllers\Admin;


use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Controllers\Admin\ICrud;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Support\Http\Request;
use JTL\Shop;
use MvcCore\Rental\Models\City;
use MvcCore\Rental\Models\Governrate;

class CityController implements ICrud
{
    public function index()
    {
        $cities = City::take(10)->get();
        $smarty = Shop::Smarty();
        foreach ($cities as $city) {
            $city->cityName = json_decode($city->name);
        }
        return $smarty->assign('cities', $cities);
    }


    public function create(Request $request)
    {
        $data = $request->all();
        $cityName = ['en' => $data['city_name_en'], 'de' => $data['city_name_de']];
        $cityName = json_encode($cityName);
        $cityDublicated = City::where('name' , $cityName)->first();
        if (!$cityDublicated) {
            City::create([
                'name' => $cityName,
                'country_id' => $data['country_id'],
                'governrate_id' => $data['governrate_id'],
            ]);
        }
        else {
            return response()->json('this city is exists' , 404);
        }
        return response()->json('City created succefully', 201);
    }


    public function update(Request $request)
    {
        $data = $request->all();
        $cityName = ['en' => $data['city_name_en'], 'de' => $data['city_name_de']];
        $cityName = json_encode($cityName);
        $categoryDublicated = City::where('name' , $cityName)->first();
        if (!$categoryDublicated) {
            City::where('id' , $data['cityId'])->update([
                'name' => $cityName,
                'governrate_id' => $data['governrate_id'],
                'country_id' => $data['country_id']
            ]);
        return Response::json('Record is updated successfully' , 206);
        }
        else {
            return response()->json('this color is exists', 404);
        }
    }


    public function destroy(Request $request)
    {
        $data = $request->all();
        City::where('id' , $data['id'])->delete();
        return response()->json('City deleted succefully', 204);
    }


    function citiesForAdmin(Request $request)
    {
        $data = $request->all();
        $cities = City::where('country_id', $data['country_id'])
        ->where('governrate_id' , $data['governrate_id'])->get();
        foreach ($cities as $city) {
            $city->cityName = json_decode($city->name);
        }
        return response()->json($cities, 200);
    }
    
}
