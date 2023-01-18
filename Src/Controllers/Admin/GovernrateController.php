<?php

namespace MvcCore\Rental\Controllers\Admin;


use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Controllers\Admin\ICrud;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Support\Http\Request;
use JTL\Shop;
use MvcCore\Rental\Models\Governrate;
use MvcCore\Rental\Models\City;

class GovernrateController implements ICrud
{
    public function index()
    {
        $governrates = Governrate::get();
        foreach ($governrates as $governrate) {
            $governrate->governrateName = json_decode($governrate->name);
            $governrate->countryName = json_decode($governrate->country->name);
        }
        $smarty = Shop::Smarty();
        return $smarty->assign('governrates', $governrates);
    }


    public function create(Request $request)
    {
        $data = $request->all();
        $governrateName = ['en' => $data['province_name_en'], 'de' => $data['province_name_de']];
        $governrateName = json_encode($governrateName);
        $governrateDublicated = Governrate::where('name' , $governrateName)->first();
        if (!$governrateDublicated) {
            Governrate::create([
                'name' => $governrateName,
                'country_id' => $data['country_id']
            ]);
        }
        else {
            return response()->json('this governrates is exists', 404);
        }
        
        return response()->json('Governrate created succefully', 201);
    }


    public function update(Request $request)
    {
        $data = $request->all();
        $governrateName = ['en' => $data['province_name_en'], 'de' => $data['province_name_de']];
        $governrateName = json_encode($governrateName);
        $categoryDublicated = Governrate::where('name' , $governrateName)->first();
        if (!$categoryDublicated) {
            Governrate::where('id' , $data['provinceId'] )->update([
                'name' => $governrateName,
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
        $gov = Governrate::where('id' , $data['id'])->first();
        Governrate::where('id' , $data['id'])->delete();
        City::where('governrate_id' , $gov->id)->delete();
        return response()->json('Governrate deleted succefully', 204);
    }


    function governratesForAdmin(Request $request)
    {
        $data = $request->all();
        $govs = Governrate::where('country_id', $data['id'])->get();
        foreach ($govs as $governrate) {
            $governrate->governrateName = json_decode($governrate->name);
        }
        return response()->json($govs, 200);
    }
}
