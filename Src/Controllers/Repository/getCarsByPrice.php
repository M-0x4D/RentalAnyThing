<?php

namespace MvcCore\Rental\Controllers\Repository;

use MvcCore\Rental\Models\Car;
use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Support\Facades\Localization\Lang;
use MvcCore\Rental\Support\Debug\Debugger;


class getCarsByPrice
{

    public function get($orderType)
    {
        $car     = new Car;
        $cars    = $car->select(
            'cars.*',
            'cars.construction_year',
            'car_models.model_name',
            'colors.color_name',
            'locations.location_name',
        )->join('colors', 'cars.color_id', 'colors.id')
            ->join('car_models', 'car_model_id', 'car_models.id')
            ->join('locations', 'cars.location_id', 'locations.id')
            ->orderBy('price_per_day', $orderType)->get();

        $filePath = new UploadingService;
        $uploads = $filePath->get_path('cars');

        foreach ($cars as $key => $car) {

            $lang = Lang::get();

            $status = json_decode($car->car_status);
            $car->car_status = $status->$lang;

            $modelName = json_decode($car->model_name);
            $car->model_name = $modelName->$lang;

            if ($car->power_type === "PowerHorse") {
                $car->power_type = "PS";
            } else {
                $car->power_type = "KW";
            }

            $colorName = json_decode($car->color_name);
            $car->color_name = $colorName->$lang;

            $location = json_decode($car->location_name);
            $car->location_name = $location->$lang;

            $price_includes = json_decode($car->price_includes);
            $car->price_includes = $price_includes->$lang;

            $price_excludes = json_decode($car->price_excludes);
            $car->price_excludes = $price_excludes->$lang;

            $carImage     = new Image;
            $carImages    = $carImage->select('imagePath', 'car_id')->where('car_id', $car->id)->get();
            if ($carImages->isNotEmpty()) {
                $carImages->map(function ($__carImage) use ($uploads, $car) {

                    $imagePath = $__carImage->imagePath;

                    $car->image_path = $uploads . $imagePath;
                });
            }

        }
        return $cars;
    }
}
