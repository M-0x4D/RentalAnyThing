<?php

namespace MvcCore\Rental\Controllers\Repository;

use MvcCore\Rental\Models\Car;
use MvcCore\Rental\Models\confirmPaymentLink;
use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Models\Rental;
use MvcCore\Rental\Models\OrderLink;
use MvcCore\Rental\Services\UploadingService;
use Carbon\Carbon;
use MvcCore\Rental\Support\DisplayData;
use MvcCore\Rental\Support\Facades\Localization\Lang;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Helpers\Response;



class getRentalsByDate
{

        public function get($orderType, $customerId)
        {

                $reserved = new Rental;
                $rentals = $reserved->select(
                        'customer_id',
                        'car_id',
                        'pickup_location_id',
                        'pickup_date',
                        'dropoff_location_id',
                        'dropoff_date',
                        'total_amount',
                        'currency',
                        'order_id',
                        'rental_status'
                )->where('customer_id', $customerId)
                        ->orderBy('pickup_date', $orderType)
                        ->get();

                $rentals->map(function($rental){

                        $pickup_date = Carbon::parse($rental->pickup_date);
                        $dropoff_date = Carbon::parse($rental->dropoff_date);
                        $rental->duration = $pickup_date->diffInDays($dropoff_date, false);

                        //  $orderLink = new OrderLink;
                        //  $link = $orderLink->select(
                        //          'order_id',
                        //          'order_link',
                        //          'link_name',
                        //  )->where('link_name', 'approve')
                        //          ->where('order_id', $rental->order_id)
                        //          ->get();

                        $confimLinks = ConfirmPaymentLink::where('order_id' , $rental->order_id)->get();

                        $confimLinks->map(function($confimLink) use($rental){

                                $rental->paymentUrl = $confimLink['link'];
                                return $confimLink;
                        });
                        
 
                         $cars = Car::select(
                                 'cars.*',
                                 'car_models.model_name',
                                 'colors.color_name',
                                 'locations.location_name',
                                 )->join('colors', 'cars.color_id', 'colors.id')
                                 ->join('car_models', 'car_model_id', 'car_models.id')
                                 ->join('locations', 'cars.location_id', 'locations.id')
                                 ->where('cars.id', $rental->car_id)
                                 ->get();
 
                         $filePath = new UploadingService;
                         $uploads = $filePath->get_path('cars');
                        $cars->map(function($__car) use ($rental , $uploads){

                                $lang = Lang::get();
 
                                 $status = json_decode($__car->car_status);
                                 $rental->car_status = $status->$lang;
 
                                 $modelName = json_decode($__car->model_name);
                                 $rental->model_name = $modelName->$lang;
 
                                 if ($rental->power_type === "PowerHorse") {
                                         $rental->power_type = "PS";
                                 } else {
                                         $rental->power_type = "KW";
                                 }
 
                                 $colorName = json_decode($__car->color_name);
                                 $rental->color_name = $colorName->$lang;
 
                                 $location = json_decode($__car->location_name);
                                 $rental->location_name = $location->$lang;
 
                                 $carImage     = new Image;
                                 $carImages    = $carImage->select('imagePath', 'car_id')->where('car_id', $__car->id)->get();
                                if ($carImages->isNotEmpty()) {
                                        # code...
                                        $carImages->map(function ($__carImage) use ($uploads, $rental) {
                        
                                            $imagePath = $__carImage->imagePath;
                        
                                            $rental->image_path = $uploads . $imagePath;
                                        });
                                    }
 
                                 $rental->construction_year = $__car->construction_year;
                                 $rental->seats = $__car->seats;
                                 $rental->transmission_type = $__car->transmission_type;
                                 $rental->size = $__car->size;
                                 $rental->bags = $__car->bags;
                                 $rental->air_conditioner = $__car->air_conditioner;
                                 $rental->price_per_day = $__car->price_per_day;
                                 $rental->currency = $__car->currency;
                                 $rental->air_conditioner = $__car->air_conditioner;
                                return $__car;
                        });

                        return $rental;

                });

                return $rentals;
        }
}
