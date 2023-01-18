<?php

namespace MvcCore\Rental\Controllers\Repository;

use MvcCore\Rental\Models\Car;
use MvcCore\Rental\Models\FeatureCar;
use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Support\Facades\Localization\Lang;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Models\ObjectModel;

class getCarsById
{

    public function get($id)
    {
        $lang = Lang::get();
        $filePath = new UploadingService;
        $uploads = $filePath->get_path('objects');
        $objectDetails =  ObjectModel::where('id', $id)->with('location', 'labels', 'colors', 'desriptions' , 'images' , 'category')->first();

        $status = json_decode($objectDetails->car_status);
        if ((isset($status->$lang))) {
            $objectDetails->car_status = $status->$lang;
        }

        $price_includes = json_decode($objectDetails->price_includes);
        if ((isset($price_includes->$lang))) {
            $objectDetails->price_includes = $price_includes->$lang;
        }

        $price_excludes = json_decode($objectDetails->price_excludes);
        if ((isset($price_excludes->$lang))) {
            $objectDetails->price_excludes = $price_excludes->$lang;
        }


        // location
        $location = json_decode($objectDetails->location->location_name);
        if ((isset($location->$lang))) {
            $objectDetails->location->location_name = $location->$lang;
        }

        // model
        $modelName = json_decode($objectDetails->model->model_name);
        if (isset($modelName->$lang)) {

            $objectDetails->model->model_name = $modelName->$lang;
        }

        // color
        $colorName = json_decode($objectDetails->color->color_name);
        if ((isset($colorName->$lang))) {
            $objectDetails->color->color_name = $colorName->$lang;
        }

        $carImage     = new Image;
        $carImages    = $carImage->select('imagePath', 'car_id')->where('car_id', $objectDetails->id)->get();
        if ($carImages->isNotEmpty()) {
            # code...
            $carImages->map(function ($__carImage) use ($uploads, $objectDetails) {

                $imagePath = $__carImage->imagePath;

                $objectDetails->image_path = $uploads . $imagePath;
            });
        }

        if ($objectDetails->features->isNotEmpty()) {
            // $objectDetails->features->map(function (&$featureDetails) use ($lang) {

            //     if ($featureDetails->power_type == "PowerHorse") {
            //         $featureDetails->power_type = "PS";
            //     } else {
            //         $featureDetails->power_type = "KW";
            //     }
    
            //     $carFeatures = FeatureCar::where('feature_id', $featureDetails->id)->get();
            //     $carFeatures->map(function (&$carFeature) use ($featureDetails, $lang) {
    
            //         $name = json_decode($featureDetails->feature_name);
            //         if ((isset($name->$lang))) {
            //             $featureDetails->feature_name = $name->$lang;
            //         }
    
            //         $description = json_decode($featureDetails->feature_description);
            //         if ((isset($description->$lang))) {
            //             $featureDetails->feature_description = $description->$lang;
            //         }
    
            //         $featureDetails->perPerson = $carFeature->per_person;
            //         $featureDetails->price = $carFeature->price;
    
            //         return $carFeature;
            //     });
            //     return $featureDetails;
            // });
        }
        return $objectDetails;
    }
}
