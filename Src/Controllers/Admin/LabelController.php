<?php

namespace MvcCore\Rental\Controllers\Admin;

use MvcCore\Rental\Controllers\Admin\Test as AdminTest;
use MvcCore\Rental\Models\ApiCredentials;
use MvcCore\Rental\Models\TokenParameter;
use MvcCore\Rental\Requests\ApiCredentialsStoreRequest;
use MvcCore\Rental\Requests\ApiCredentialsUpdateRequest;
use MvcCore\Rental\Validations\Alerts;
use Symfony\Component\Dotenv\Dotenv as DotenvDotenv;
use Symfony\Component\Dotenv\Dotenv;
use MvcCore\Rental\Controllers\Admin\Test;
use MvcCore\Rental\Support\Http\HttpRequest;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Support\Http\Server;
use JTL\Shop;
use MvcCore\Rental\Support\Facades\Configs\Configs;
use MvcCore\Rental\Helpers\GetPaypalMode;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Models\Label;
use MvcCore\Rental\Requests\LabelStoreRequest;
use MvcCore\Rental\Requests\LabelUpdateRequest;
use MvcCore\Rental\Controllers\Admin\Crud;
use MvcCore\Rental\Controllers\Admin\ICrud;




class LabelController implements ICrud
{
    public function index()
    {

        $labels    = Label::get();

        foreach ($labels as $object) {
            $featureName = json_decode($object->feature_name);
            $object->featureNameEN = $featureName->en;
            $object->featureNameDE = $featureName->de;
            $description = json_decode($object->feature_description);
            $object->featureDescriptionEN = $description->en;
            $object->featureDescriptionDE = $description->de;
        }

        $smarty = Shop::Smarty();
        return $smarty->assign('objects', $labels);
    }
    public function create(Request $request)
    {

        $checkCredentials = new CheckApiCredentials;
        $checkCredentials->handle();
        
        $validator = new LabelStoreRequest;
        $validatedData = $validator->validate($request->all());

        $arrName = ['en' => $validatedData['category_name_en'], 'de' => $validatedData['category_name_de']];
        $jsonName = json_encode($arrName);
        $arrObjectId = ['en' => $validatedData['object_id_en'], 'de' => $validatedData['object_id_de']];
        $jsonObjectId = json_encode($arrObjectId);
        $arrType = ['en' => $validatedData['type_en'], 'de' => $validatedData['type_de']];
        $jsonType = json_encode($arrType);
        $arrValue = ['en' => $validatedData['value_en'], 'de' => $validatedData['value_de']];
        $jsonValue = json_encode($arrValue);



        Label::create([
            'name' => $jsonName ,
            'object_id' => $jsonObjectId , 
            'type' => $jsonType,
            'value' => $jsonValue
        ]);
        return Response::json('Record is created successfully' , 201);
    }


    public function update(Request $request)
    {
        $validator = new LabelUpdateRequest;
        $validatedData = $validator->validate($request->all());
        $arrName = ['en' => $validatedData['category_name_en'], 'de' => $validatedData['category_name_de']];
        $jsonName = json_encode($arrName);
        $arrObjectId = ['en' => $validatedData['object_id_en'], 'de' => $validatedData['object_id_de']];
        $jsonObjectId = json_encode($arrObjectId);
        $arrType = ['en' => $validatedData['type_en'], 'de' => $validatedData['type_de']];
        $jsonType = json_encode($arrType);
        $arrValue = ['en' => $validatedData['value_en'], 'de' => $validatedData['value_de']];
        $jsonValue = json_encode($arrValue);

        Label::where('id' , $validatedData['labelId'])->update([
            'name' => $jsonName ,
            'object_id' => $jsonObjectId , 
            'type' => $jsonType,
            'value' => $jsonValue
        ]);

    }
    public function destroy(Request $request)
    {
        $data = $request->all();
        Label::where('id',$data['id'])->delete();
        return Response::json('Record is deleted successfully' , 204);

    }

}