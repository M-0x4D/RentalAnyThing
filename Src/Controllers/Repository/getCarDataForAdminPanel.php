<?php

namespace MvcCore\Rental\Controllers\Repository;

use MvcCore\Rental\Models\Car;

class getCarDataForAdminPanel
{

    
    public function get($carId, $smarty)
    {
        $carObject = new Car();

        $cars    = Car::select(
            'cars.*',
            'car_models.model_name',
            'colors.color_name',
            'locations.location_name',
        )->join('colors', 'cars.color_id', 'colors.id')
            ->join('car_models', 'car_model_id', 'car_models.id')
            ->join('locations', 'cars.location_id', 'locations.id')
            ->where('cars.id', $carId)
            ->get();

        $cars = array_map(function ($car) use ($carObject, $smarty) {

            $status = json_decode($car->car_status);
            $car->statusEN = $status->en;
            $car->statusDE = $status->de;

            $modelName = json_decode($car->model_name);
            $car->modelNameEN = $modelName->en;
            $car->modelNameDE = $modelName->de;

            $colorName = json_decode($car->color_name);
            $car->colorNameEN = $colorName->en;
            $car->colorNameDE = $colorName->de;

            $location = json_decode($car->location_name);
            $car->locationEN = $location->en;
            $car->locationDE = $location->de;

            $price_includes = json_decode($car->price_includes);
            $car->price_includesEN = $price_includes->en;
            $car->price_includesDE = $price_includes->de;


            $price_excludes = json_decode($car->price_excludes);
            $car->price_excludesEN = $price_excludes->en;
            $car->price_excludesDE = $price_excludes->de;

            unset($car->car_status);
            unset($car->model_name);
            unset($car->color_name);
            unset($car->location_name);

            $carFeatures = $carObject->select(
                'cars.id',
                'features.id AS featureId',
                'features.feature_name',
                'features.feature_description',
                'feature_car.per_person',
                'feature_car.price'
            )->with('features')->where('cars.id', $car->id)->get();

            $modifiedFeatures = array_map(function ($feature) use ($smarty) {

                $name = json_decode($feature->feature_name);
                $feature->featureNameEN = $name->en;

                unset($feature->feature_name);
                unset($feature->feature_description);

                return $feature;
            }, $carFeatures);

            $car->carFeatures = $modifiedFeatures;

            $smarty->assign('carFeatures', $modifiedFeatures);
            return $car;
        }, $cars);
        return $cars;
    }
}
