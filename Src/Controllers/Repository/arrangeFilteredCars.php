<?php

namespace MvcCore\Rental\Controllers\Repository;

use MvcCore\Rental\Models\Car;
use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Support\Facades\Localization\Lang;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Helpers\Response;


use Plugin\TecSeeProductsRentalBooking\vendor\Illuminate\Database\Eloquent;

class arrangeFilteredCars
{

    public function get(array $values, $orderType)
    {

        if (count($values) == 1) {

            if (isset($values['price_per_day'])) {

                if ($values['price_per_day']['0'] == 200) {
                    $maximumValue = $values['price_per_day']['0'];
                } else {
                    $maximumValue = 'NULL';
                }

                $cars = Car::select(
                    'cars.*' ,
                    'car_models.model_name',
                    'colors.color_name',
                    'locations.location_name',
                )->join('colors', 'cars.color_id', 'colors.id')
                    ->join('car_models', 'cars.car_model_id', 'car_models.id')
                    ->join('locations', 'cars.location_id', 'locations.id')
                    ->where(function ($query) use ($maximumValue, $values) {
                        $query->whereBetween('cars.price_per_day', array($values['price_per_day']['0'], $values['price_per_day']['1']))
                            ->orWhere('cars.price_per_day', '>=', $maximumValue);
                    })
                    ->orderBy('price_per_day', $orderType)
                    ->get();
            } else {

                foreach ($values as $key => $value) {
                    $cars = Car::select(
                        'cars.*',
                        'colors.color_name',
                        'locations.location_name',
                    )->join('colors', 'cars.color_id', 'colors.id')
                        ->join('car_models', 'car_model_id', 'car_models.id')
                        ->join('locations', 'cars.location_id', 'locations.id')
                        ->where($key, $value)
                        ->orderBy('price_per_day', $orderType)
                        ->get();
                }
            }
        } else if (count($values) == 2) {

            if (isset($values['price_per_day'])) {

                if ($values['price_per_day']['0'] == 200) {
                    $maximumValue = $values['price_per_day']['0'];
                } else {
                    $maximumValue = 'NULL';
                }
                foreach ($values as $key => $value) {
                    if ($key != 'price_per_day') {
                        $cars    = Car::select(
                            'cars.*',
                            'car_models.model_name',
                            'colors.color_name',
                           
                            'locations.location_name',
                        )->join('colors', 'cars.color_id', 'colors.id')
                            ->join('car_models', 'cars.car_model_id', 'car_models.id')
                            ->join('locations', 'cars.location_id', 'locations.id')
                            ->where(function ($query) use ($maximumValue, $values) {
                                $query->whereBetween('cars.price_per_day', array($values['price_per_day']['0'], $values['price_per_day']['1']))
                                    ->orWhere('cars.price_per_day', '>=', $maximumValue);
                            })
                            ->where($key, $value)
                            ->orderBy('price_per_day', $orderType)
                            ->get();
                    }
                }
            } else {

                // if 2 values and price is not included
                $keys = array_keys($values);
                $values = array_values($values);

                $firstKey = current($keys);
                $firstValue = current($values);

                $nextKey = next($keys);
                $nextValue = next($values);

                $cars    = Car::select(
                    'cars.*',
                    'car_models.model_name',
                    'colors.color_name',
                    'locations.location_name',
                )->join('colors', 'cars.color_id', 'colors.id')
                    ->join('car_models', 'cars.car_model_id', 'car_models.id')
                    ->join('locations', 'location_id', 'locations.id')
                    ->where($firstKey, $firstValue)
                    ->where($nextKey, $nextValue)
                    ->orderBy('price_per_day', $orderType)
                    ->get();
            }
        } else if (count($values) == 3) {

            if ($values['price_per_day']['0'] == 200) {
                $maximumValue = $values['price_per_day']['0'];
            } else {
                $maximumValue = 'NULL';
            }

            $cars    = Car::select(
                'cars.*',
                'colors.color_name',
                'locations.location_name',
            )->join('colors', 'cars.color_id', 'colors.id')
                ->join('car_models', 'cars.car_model_id', 'car_models.id')
                ->join('locations', 'cars.location_id', 'locations.id')
                ->where(function ($query) use ($maximumValue, $values) {
                    $query->whereBetween('cars.price_per_day', array($values['price_per_day']['0'], $values['price_per_day']['1']))
                        ->orWhere('cars.price_per_day', '>=', $maximumValue);
                })
                ->where('size', $values['size'])->where('transmission_type', $values['transmission_type'])
                ->orderBy('price_per_day', $orderType)
                ->get();
        }

        $filePath = new UploadingService;
        $uploads = $filePath->get_path('cars');

        $cars->map(function ($car) use ($uploads) {

            $lang = Lang::get();

            $status = json_decode($car->car_status);
            $car->car_status = $status->$lang;


            if ($car->power_type === "PowerHorse") {
                $car->power_type = "PS";
            } else {
                $car->power_type = "KW";
            }

            $modelName = json_decode($car->model_name);
            $car->model_name = $modelName->$lang;

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
                # code...
                $carImages->map(function ($__carImage) use ($uploads, $car) {

                    $imagePath = $__carImage->imagePath;

                    $car->image_path = $uploads . $imagePath;
                });
            }
        });

        return $cars;
    }
}
