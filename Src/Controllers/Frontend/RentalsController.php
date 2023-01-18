<?php

namespace MvcCore\Rental\Controllers\Frontend;

use Illuminate\Support\Facades\Response as FacadesResponse;
use MvcCore\Rental\Controllers\Repository\getRentalsByDate;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Requests\filterRentalsByDateRequest;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Support\DisplayData;
use MvcCore\Rental\Models\ConfirmPaymentLink;
use JTL\Shop;
use JTL\Session\Frontend;
use MvcCore\Rental\Models\Rental;
use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Models\OrderLink;
use JTL\Session\AbstractSession;
use MvcCore\Rental\Models\Category;
use MvcCore\Rental\Models\Color;
use MvcCore\Rental\Models\Currency;
use MvcCore\Rental\Models\Description;
use MvcCore\Rental\Models\Location;
use MvcCore\Rental\Models\Label;
use MvcCore\Rental\Models\ObjectModel;
use MvcCore\Rental\Services\UploadingService;


class RentalsController
{
    public function index()
    {
        $customer          = Frontend::getCustomer();
        $customerId = $customer->kKunde;
        if ($customerId) {
            $rentals = Rental::get();
            foreach ($rentals as $key => $rental) {
                // $objectForTest = ObjectModel::where('id', $rental->object_id)->first();
                $object = ObjectModel::where('id', $rental->object_id)->with(['country', 'category', 'currency', 'descriptions', 'governrate', 'city', 'labels', 'color', 'images'])->first();
                if ($rental->object_id === $object->id) {
                    $rental->price = intval($object->price);
                $rental->duration = $object->duration;
                $orderLink = OrderLink::where('object_id', $object->id)->where('link_name', 'approve')->pluck('order_link')->first();
                $rental->link = $orderLink;
                if (isset($object->name)) {
                    $rental->name = json_decode($object->name);
                }
                if (isset($object->quanityt)) {
                        $rental->quantity++;
                }
                if (isset($object->price_includes)) {
                    $rental->price_includes = json_decode($object->price_includes);
                }
                if (isset($object->price_excludes)) {
                    $rental->price_excludes = json_decode($object->price_excludes);
                }
                if ($object->price) {
                    $rental->price = intval($object->price);
                }

                if (isset($object->category->name)) {
                    $rental->categoryName = json_decode($object->category->name);
                }
                if (isset($object->city->name)) {
                    $rental->cityName = json_decode($object->city->name);
                }
                if (isset($object->color->color_name)) {
                    $rental->colorName = json_decode($object->color->color_name);
                }
                if (isset($object->country->name)) {
                    $rental->countryName = json_decode($object->country->name);
                }
                if (isset($object->currency->name)) {
                    $rental->currencyName = json_decode($object->currency->name);
                }
                if (isset($object->currency->currency_code)) {
                    $rental->currencyCode = json_decode($object->currency->currency_code);
                }
                if (isset($object->descriptions)) {
                    foreach ($object->descriptions as $key => $description) {
                        if (isset($description->long_description)) {
                            $rental->long_description = json_decode($description->long_description);
                        }
                        if (isset($description->short_description)) {
                            $rental->short_description = json_decode($description->short_description);
                        }
                    }
                    unset($object->descriptions);
                }
                if (isset($object->governrate->name)) {
                    $rental->governrateName = json_decode($object->governrate->name);
                }
                if (!count($object->images) == 0) {
                    $filePath = new UploadingService;
                    $uploads = $filePath->get_path('objects');
                    foreach ($object->images as $key => $image) {
                        $imagePath = $uploads . $image->imagePath;
                    }
                    $rental->imagePath = $imagePath;
                    unset($object->images);
                } else {
                    $rental->imagePath = null;
                }
                }


                else {
                    $rental->price = intval($object->price);
                $rental->duration = $object->duration;
                $orderLink = OrderLink::where('object_id', $object->id)->where('link_name', 'approve')->pluck('order_link')->first();
                $rental->link = $orderLink;
                if (isset($object->name)) {
                    $rental->name = json_decode($object->name);
                }
                if (isset($object->price_includes)) {
                    $rental->price_includes = json_decode($object->price_includes);
                }
                if (isset($object->price_excludes)) {
                    $rental->price_excludes = json_decode($object->price_excludes);
                }
                if ($object->price) {
                    $rental->price = intval($object->price);
                }

                if (isset($object->category->name)) {
                    $rental->categoryName = json_decode($object->category->name);
                }
                if (isset($object->city->name)) {
                    $rental->cityName = json_decode($object->city->name);
                }
                if (isset($object->color->color_name)) {
                    $rental->colorName = json_decode($object->color->color_name);
                }
                if (isset($object->country->name)) {
                    $rental->countryName = json_decode($object->country->name);
                }
                if (isset($object->currency->name)) {
                    $rental->currencyName = json_decode($object->currency->name);
                }
                if (isset($object->currency->currency_code)) {
                    $rental->currencyCode = json_decode($object->currency->currency_code);
                }
                if (isset($object->descriptions)) {
                    foreach ($object->descriptions as $key => $description) {
                        if (isset($description->long_description)) {
                            $rental->long_description = json_decode($description->long_description);
                        }
                        if (isset($description->short_description)) {
                            $rental->short_description = json_decode($description->short_description);
                        }
                    }
                    unset($object->descriptions);
                }
                if (isset($object->governrate->name)) {
                    $rental->governrateName = json_decode($object->governrate->name);
                }
                if (!count($object->images) == 0) {
                    $filePath = new UploadingService;
                    $uploads = $filePath->get_path('objects');
                    foreach ($object->images as $key => $image) {
                        $imagePath = $uploads . $image->imagePath;
                    }
                    $rental->imagePath = $imagePath;
                    unset($object->images);
                } else {
                    $rental->imagePath = null;
                }
                }
            }
            $smarty = Shop::Smarty();
            $smarty->assign('my_rentals', $rentals);
        }
    }




    public function filterRentalsByDate(Request $request)
    {
        $arr = [];
        $data = $request->all();
        $arrangedObjects = Rental::where('customer_id', $data['customerId'])
            ->orderBy('pickup_date', $data['filter'])->get();

        foreach ($arrangedObjects as $key => $arrangedObject) {
            $object = ObjectModel::where('id', $arrangedObject->object_id)->with(['country', 'category', 'currency', 'descriptions', 'governrate', 'city', 'labels', 'color', 'images'])->first();
            if (isset($object->name)) {
                $object->name = json_decode($object->name);
            }
            if (isset($object->price_includes)) {
                $object->price_includes = json_decode($object->price_includes);
            }
            if (isset($object->quantity)) {
                $object->quantity = json_decode($arrangedObject->quantity);
            }
            if (isset($object->price_excludes)) {
                $object->price_excludes = json_decode($object->price_excludes);
            }
            if ($object->price) {
                $object->price = intval($arrangedObject->total_amount);
            }

            if (isset($object->category->name)) {
                $object->categoryName = json_decode($object->category->name);
            }
            if (isset($object->city->name)) {
                $object->cityName = json_decode($object->city->name);
            }
            if (isset($object->color->color_name)) {
                $object->colorName = json_decode($object->color->color_name);
            }
            if (isset($object->country->name)) {
                $object->countryName = json_decode($object->country->name);
            }
            if (isset($object->currency->name)) {
                $object->currencyName = json_decode($object->currency->name);
            }
            if (isset($object->currency->currency_code)) {
                $object->currencyCode = json_decode($object->currency->currency_code);
            }
            if (isset($object->descriptions)) {
                foreach ($object->descriptions as $key => $description) {
                    if (isset($description->long_description)) {
                        $object->long_description = json_decode($description->long_description);
                    }
                    if (isset($description->short_description)) {
                        $object->short_description = json_decode($description->short_description);
                    }
                }
            }
            if (isset($object->governrate->name)) {
                $object->governrateName = json_decode($object->governrate->name);
            }
            if (!count($object->images) == 0) {
                $filePath = new UploadingService;
                $uploads = $filePath->get_path('objects');
                foreach ($object->images as $key => $image) {
                    $imagePath = $uploads . $image->imagePath;
                }
                $object->imagePath = $imagePath;
                unset($object->images);
            } else {
                $object->imagePath = null;
            }
            $object->pickup_date = $arrangedObject->pickup_date;
            $object->dropoff_date = $arrangedObject->dropoff_date;
            $object->rental_status = $arrangedObject->rental_status;
            $arr[] = $object;
        }
        return Response::json($arr, 200);
    }
}
