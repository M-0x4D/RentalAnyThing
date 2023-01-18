<?php

namespace MvcCore\Rental\Controllers\Admin;

use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Models\Feature;
use MvcCore\Rental\Requests\FeatureStoreRequest;
use MvcCore\Rental\Requests\FeatureUpdateRequest;
use MvcCore\Rental\Requests\getFeaturePriceRequest;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Validations\Alerts;
use MvcCore\Rental\Middlewares\CheckApiCredentials;
use Illuminate\Database\Eloquent;
use JTL\Shop;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Models\Car;
use MvcCore\Rental\Models\ObjectModel;

class FeaturesController
{
    public function index()
    {
        $features    = Feature::get();

        foreach ($features as $value) {
            $featureName = json_decode($value->feature_name);
            $value->featureNameEN = $featureName->en;
            $value->featureNameDE = $featureName->de;
            $description = json_decode($value->feature_description);
            $value->featureDescriptionEN = $description->en;
            $value->featureDescriptionDE = $description->de;
        }

        $smarty = Shop::Smarty();
        return $smarty->assign('features', $features);
    }


    public function create(Request $request)
    {

        $checkCredentials = new CheckApiCredentials;
        $checkCredentials->handle();

        $validator = new FeatureStoreRequest;
        $validatedData = $validator->validate($request->all());

        // encode multi language inputs

        $arrName = ['en' => $validatedData['feature_name_en'], 'de' => $validatedData['feature_name_de']];
        $jsonName = json_encode($arrName);
        $arrDescription = ['en' => $validatedData['feature_description_en'], 'de' => $validatedData['feature_description_de']];
        $jsonDescription = json_encode($arrDescription);


        $feature     = new Feature;
        $feature->create(
            [
                'feature_name' => $jsonName,
                'feature_description' => $jsonDescription,

            ]
        );
        // Alerts::show('success', 'Record is created successfully', 'Created:');
        return Response::json('Record is created successfully' , 201);

    }



    public function update(Request $request)
    {

        $validator = new FeatureUpdateRequest;
        $validatedData = $validator->validate($request->all());

        $arrName = ['en' => $validatedData['feature_name_en'], 'de' => $validatedData['feature_name_de']];
        $jsonName = json_encode($arrName);
        $arrDescription = ['en' => $validatedData['feature_description_en'], 'de' => $validatedData['feature_description_de']];
        $jsonDescription = json_encode($arrDescription);


        $feature     = new Feature;
        $feature->where('id', $validatedData['featureId'])->update(
            [
                'feature_name' => $jsonName,
                'feature_description' => $jsonDescription,
            ]

        );
        return Response::json('Record is updated successfully' , 206);

    }

 
    public function destroy(Request $request)
    {
        $data = $request->all();
        $object = new ObjectModel();
        $object->features()->detach($data['id']);
        Feature::where('id', $data['id'])->delete();
        return Response::json('Record is updated successfully' , 204);

    }
}
