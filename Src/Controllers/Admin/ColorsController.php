<?php

namespace MvcCore\Rental\Controllers\Admin;

use MvcCore\Rental\Models\Color;
use MvcCore\Rental\Requests\ColorStoreRequest;
use MvcCore\Rental\Requests\ColorUpdateRequest;
use MvcCore\Rental\Validations\Alerts;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Middlewares\CheckApiCredentials;
use Illuminate\Database\Eloquent;
use JTL\Shop;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Models\Car;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Controllers\Admin\Crud;
use MvcCore\Rental\Controllers\Admin\ICrud;


class ColorsController implements ICrud
{
    public function index()
    {
        $colors    = Color::get();

        foreach ($colors as $color) {
            $colorName = json_decode($color->color_name);
            $color->colorNameEN = $colorName->en;
            $color->colorNameDE = $colorName->de;
        }
        

        $smarty = Shop::Smarty();
        return $smarty->assign('colors', $colors);
    }


    public function create(Request $request)
    {

        $checkCredentials = new CheckApiCredentials;
        $checkCredentials->handle();
        
        $validator = new ColorStoreRequest;
        $validatedData = $validator->validate($request->all());
        // encode multi language inputs
        $arrColorName = ['en' => $validatedData['color_name_en'], 'de' => $validatedData['color_name_de']];
        $jsonColorName = json_encode($arrColorName);
        $categoryDublicated = Color::where('color_name' , $jsonColorName)->first();
        if (!$categoryDublicated) {
            Color::create([
                'color_name' => $jsonColorName
            ]);
        return Response::json('Record is created successfully' , 201);
        }
        else {
            return response()->json('this color is exists', 404);
        }
        
    }

    public function destroy(Request $request)
    {
       
        $data = $request->all();
        Color::where('id',$data['id'])->delete();
        return Response::json('Record is deleted successfully' , 204);

    }



    public function update(Request $request)
    {

        $validator = new ColorUpdateRequest;
        $validatedData = $validator->validate($request->all());

        $arrColorName = ['en' => $validatedData['color_name_en'], 'de' => $validatedData['color_name_de']];

        $jsonColorName = json_encode($arrColorName);
        $categoryDublicated = Color::where('color_name' , $jsonColorName)->first();
        if (!$categoryDublicated) {
            Color::where('id' , $validatedData['colorId'])->update(
                [
                    'color_name' => $jsonColorName,
                ]
                
            );
        return Response::json('Record is updated successfully' , 206);
        }
        else {
            return response()->json('this color is exists', 404);
        }

    }
}
