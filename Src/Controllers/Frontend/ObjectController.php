<?php

namespace MvcCore\Rental\Controllers\Frontend;


use MvcCore\Rental\Models\ObjectModel;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Models\UnBookedObject;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Models\Category;
use MvcCore\Rental\Models\Location;
use MvcCore\Rental\Models\Color;
use MvcCore\Rental\Models\Label;
use MvcCore\Rental\Models\Currency;
use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Models\Rental;
use MvcCore\Rental\Models\Description;
use MvcCore\Rental\Services\UploadingService;
use JTL\Session\Frontend;
use MvcCore\Rental\Controllers\Repository\getObjectByFilter;
use PhpParser\Node\Expr\Cast\Object_;

class ObjectController
{
    protected $imagePath ; 

    public static $mergedCollection = [];
    public static $rentals = [];
    /**
     * * view all objects for frontend
     * @param Request $request
     * @return mixed
     */
    public function searchAvailableObjects(Request $request)
    {
        $data = $request->all();

        if (!isset($data['governorate_id']) && !isset($data['city_id'])) {
            $objects = ObjectModel::where('category_id', $data['category_id'])
            ->where('country_id', $data['country_id'])
            ->where('booked', false)->with(['country', 'category', 'currency', 'descriptions', 'governrate', 'city', 'labels', 'color', 'images'])
            ->get();
        $objects = $this->foreachHelper($objects);

        $rentals = Rental::where('category_id', $data['category_id'])
            ->where('pickup_date', '<=', $data['drop_of_date'])
            ->where('dropoff_date', '>=', $data['pick_up_date'])
            ->where('country_id',$data['country_id'])
            ->with(['country', 'category', 'currency', 'descriptions', 'governrate', 'city', 'labels', 'color', 'images'])
            ->get();

        $rentals = $this->foreachHelper($rentals);
        $objects = $objects->toArray();
        $rentals = $rentals->toArray();
        $finalResult = array_merge($objects, $rentals);
        return response()->json($finalResult, 200);
        }

        elseif (!isset($data['city_id'])) {
            $objects = ObjectModel::where('category_id', $data['category_id'])
            ->where('country_id', $data['country_id'])
            ->where('governrate_id', $data['governorate_id'])
            ->where('booked', false)->with(['country', 'category', 'currency', 'descriptions', 'governrate', 'city', 'labels', 'color', 'images'])
            ->get();
        $objects = $this->foreachHelper($objects);

        $rentals = Rental::where('category_id', $data['category_id'])
            ->where('pickup_date', '<=', $data['drop_of_date'])
            ->where('dropoff_date', '>=', $data['pick_up_date'])
            ->where('country_id',$data['country_id'])
            ->where('governrate_id' , $data['governorate_id'])
            ->with(['country', 'category', 'currency', 'descriptions', 'governrate', 'city', 'labels', 'color', 'images'])
            ->get();

        $rentals = $this->foreachHelper($rentals);
        $objects = $objects->toArray();
        $rentals = $rentals->toArray();
        $finalResult = array_merge($objects, $rentals);
        return response()->json($finalResult, 200);
        }
        else {
            $objects = ObjectModel::where('category_id', $data['category_id'])
            ->where('country_id', $data['country_id'])
            ->where('governrate_id', $data['governorate_id'])
            ->where('city_id', $data['city_id'])
            ->where('booked', false)->with(['country', 'category', 'currency', 'descriptions', 'governrate', 'city', 'labels', 'color', 'images'])
            ->get();
        $objects = $this->foreachHelper($objects);

        $rentals = Rental::where('category_id', $data['category_id'])
            ->where('pickup_date', '<=', $data['drop_of_date'])
            ->where('dropoff_date', '>=', $data['pick_up_date'])
            ->where('country_id',$data['country_id'])
            ->where('governrate_id' , $data['governorate_id'])
            ->where('city_id' , $data['city_id'])->with(['country', 'category', 'currency', 'descriptions', 'governrate', 'city', 'labels', 'color', 'images'])
            ->get();

        $rentals = $this->foreachHelper($rentals);
        $objects = $objects->toArray();
        $rentals = $rentals->toArray();
        $finalResult = array_merge($objects, $rentals);
        return response()->json($finalResult, 200);
        }
    }


    function filterByPrice(Request $request)
    {
        $data = $request->all();
        $intVals = [];
        if (isset($data['price'])) {
            $arr = explode(',', $data['price']);
            foreach ($arr as  $value) {
                $value = intval($value);
                array_push($intVals, $value);
            }
        }
        $variables = [

            'duration'  => isset($data['duration']) ? $data['duration'] : null,
            'price'  => $intVals,
        ];
        $realValues = [];
        foreach ($variables as $key => $value) {
            if ($value == null) continue;
            $realValues += [$key => $value];
        }

        $getObjectByFilter = new getObjectByFilter();
        if (isset($data['governorate_id']) && isset($data['city_id'])) {
            # code...
            $filteredObjects = $getObjectByFilter->get($realValues, $data['country_id'] , $data['governorate_id'],$data['city_id'], $data['category_id']);
        }
        elseif (isset($data['governorate_id'])) {
            $filteredObjects = $getObjectByFilter->getWithGov($realValues, $data['country_id'] , $data['governorate_id'], $data['category_id']);
        }
        else {
            $filteredObjects = $getObjectByFilter->getWithoutGov($realValues, $data['country_id'] , $data['category_id']);
            
        }
        foreach ($filteredObjects as $filteredObject) {
            if (isset($filteredObject->name)) {
                $filteredObject->name = json_decode($filteredObject->name);
            }
            if (isset($filteredObject->category->name)) {
                $filteredObject->categoryName = json_decode($filteredObject->category->name);
            }
            if (isset($filteredObject->city->name)) {
                $filteredObject->cityName = json_decode($filteredObject->city->name);
            }
            if (isset($filteredObject->color->color_name)) {
                $filteredObject->colorName = json_decode($filteredObject->color->color_name);
            }
            if (isset($filteredObject->country->name)) {
                $filteredObject->countryName = json_decode($filteredObject->country->name);
            }
            if (isset($filteredObject->descriptions)) {
                foreach ($filteredObject->descriptions as $key => $description) {
                    if (isset($description->long_description)) {
                        $filteredObject->long_description = json_decode($description->long_description);
                    }
                    if (isset($description->short_description)) {
                        $filteredObject->short_description = json_decode($description->short_description);
                    }
                }
            }
            if (isset($filteredObject->governrate->name)) {
                $filteredObject->governrateName = json_decode($filteredObject->governrate->name);
            }
            if (!count($filteredObject->images) == 0) {
                $filePath = new UploadingService;
                $uploads = $filePath->get_path('objects');
                foreach ($filteredObject->images as $key => $image) {
                    $imagePath = $uploads . $image->imagePath;
                }
                $filteredObject->imagePath = $imagePath;
                unset($filteredObject->images);
            }else
            {
                $filteredObject->imagePath = null;   
            }
        }
        return Response::json($filteredObjects, 200);
    }



    public function arrangeByPrice(Request $request)
    {
        $data = $request->all();
        $arr = $data['obj'];
        $objects = ObjectModel::orderBy('price', $data['filter'])->with('currency')->findMany($arr);
        foreach ($objects as $object) {
            if (isset($object->name)) {
                $object->name = json_decode($object->name);
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
            }else
            {
                $object->imagePath = null;   
            }
        }

        return Response::json($objects, 200);
    }



    function foreachHelper($arrayName)
    {
        foreach ($arrayName as $object) {
            if (isset($object->name)) {
                $object->name = json_decode($object->name);
            }
            if (isset($object->category->name)) {
                $object->categoryName = json_decode($object->category->name, true);
            }
            if (isset($object->city->name)) {
                $object->cityName = json_decode($object->city->name, true);
            }
            if (isset($object->color->color_name)) {
                $object->colorName = json_decode($object->color->color_name, true);
            }
            if (isset($object->country->name)) {
                $object->countryName = json_decode($object->country->name, true);
            }
            if (!empty($object->descriptions)) {
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
            if (!empty($object->images)) {
                $filePath = new UploadingService;
                $uploads = $filePath->get_path('objects');
                foreach ($object->images as $key => $image) {
                    $this->imagePath = $uploads . $image->imagePath;
                }
                $object->imagePath = $this->imagePath;
                // unset($object->images);
            }else {
                $object->imagePath = null;
            }
        }
    return $arrayName;
    }

}
