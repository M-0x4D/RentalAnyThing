<?php

namespace MvcCore\Rental\Controllers\Repository;

use MvcCore\Rental\Models\Car;
use MvcCore\Rental\Support\Debug\Debugger;
use JTL\Shop;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Models\FeatureCar;

class getCarsForAdminPanel
{

    public function get()
    {
        $cars = Car::with(['features', 'model', 'location', 'color'])->get();

        $cars->map(function ($car) {
            // $car['features']['featureCar'] = $carFeatures;


            $status = json_decode($car->car_status);
            $car->statusEN = $status->en;
            $car->statusDE = $status->de;

            $modelName = json_decode($car->model->model_name);
            $car->modelNameEN = $modelName->en;
            $car->modelNameDE = $modelName->de;

            $colorName = json_decode($car->color->color_name);
            $car->colorNameEN = $colorName->en;
            $car->colorNameDE = $colorName->de;

            $location = json_decode($car->location->location_name);
            $car->locationEN = $location->en;
            $car->locationDE = $location->de;

            $price_includes = json_decode($car->price_includes);
            $car->price_includesEN = $price_includes->en;
            $car->price_includesDE = $price_includes->de;

            $price_excludes = json_decode($car->price_excludes);
            $car->price_excludesEN = $price_excludes->en;
            $car->price_excludesDE = $price_excludes->de;


            if (!$car->features->isEmpty()) {
                $car->features->map(function ($feature) use ($car) {
                    $carFeatures = FeatureCar::where('feature_id', $feature->id)->where('car_id', $car->id)->get();
                    $carFeatures->map(function ($carFeature) use (&$feature) {

                        $feature->perPerson = $carFeature->per_person;
                        $feature->price = $carFeature->price;


                        if (isset($feature->feature_name)) {
                            $featureName = json_decode($feature->feature_name);
                            $feature->featureNameEN = $featureName->en;
                            $feature->featureNameDE = $featureName->de;
                        }
                        unset($feature->feature_name);


                        if (isset($feature->feature_description)) {
                            $featureDescription = json_decode($feature->feature_description);
                            $feature->featureDescriptionEN = $featureDescription->en;
                            $feature->featureDescriptionDE = $featureDescription->de;
                        }
                        unset($feature->feature_description);
                    });



                    return $feature;
                });
            } else {

                return '';
            }
            return $car;
        });

        return $cars;
    }
}
