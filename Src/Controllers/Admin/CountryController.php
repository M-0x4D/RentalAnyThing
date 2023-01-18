<?php

namespace MvcCore\Rental\Controllers\Admin;


use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Controllers\Admin\ICrud;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Support\Http\Request;
use JTL\Shop;
use MvcCore\Rental\Models\Country;
use MvcCore\Rental\Models\Governrate;
use MvcCore\Rental\Models\City;

class CountryController implements ICrud
{
    public function index()
    {
        $countries = Country::get();
        foreach ($countries as $country) {
            $country->countryName = json_decode($country->name);
        }
        $smarty = Shop::Smarty();
        return $smarty->assign('countries', $countries);
    }


    public function create(Request $request)
    {
        $data = $request->all();
        $countryName = ['en' => $data['country_name_en'], 'de' => $data['country_name_en']];
        $countryName = json_encode($countryName);
        $countryDublicated = Country::where('name' , $countryName)->first();
        if (!$countryDublicated) {
            Country::create([
                'name' => $countryName
            ]);
        }
        else {
            return response()->json('this country is exists', 404);
        }
        
        return response()->json('country created succefully', 201);
    }


    public function update(Request $request)
    {
        $data = $request->all();
        $countryName = ['en' => $data['country_name_en'], 'de' => $data['country_name_de']];
        $countryName = json_encode($countryName);
        $categoryDublicated = Country::where('name' , $countryName)->first();
        if (!$categoryDublicated) {
            Country::where('id', $data['countryId'])->update([
                'name' => $countryName
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
        Country::where('id', $data['id'])->delete();
        $govs = Governrate::where('country_id', $data['id'])->get();
        Governrate::where('country_id', $data['id'])->delete();
        foreach ($govs as $gov) {
            City::where('governrate_id', $gov->id)->delete();
        }
        return response()->json('country deleted succefully', 204);
    }
}
