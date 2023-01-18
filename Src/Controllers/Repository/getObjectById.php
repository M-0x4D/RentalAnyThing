<?php

namespace MvcCore\Rental\Controllers\Repository;

use Illuminate\Support\Facades\Response as FacadesResponse;
use MvcCore\Rental\Models\Car;
use MvcCore\Rental\Models\FeatureCar;
use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Support\Facades\Localization\Lang;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Models\Category;
use MvcCore\Rental\Models\Location;
use MvcCore\Rental\Models\Color;
use MvcCore\Rental\Models\Currency;
use MvcCore\Rental\Models\Description;
use MvcCore\Rental\Models\Label;
use MvcCore\Rental\Models\ObjectModel;

class getObjectById
{

   protected $imagePath;
    public function get($id)
    {

        $filePath = new UploadingService;
        $uploads = $filePath->get_path('objects');
        $objectDetails =  ObjectModel::where('id', $id)->with(['country', 'category', 'currency', 'descriptions', 'governrate', 'city', 'labels', 'color', 'images'])->first();
        if (isset($objectDetails->name)) {
            $objectDetails->name = json_decode($objectDetails->name);
        }
        if (isset($objectDetails->price_includes)) {
            $objectDetails->price_includes = json_decode($objectDetails->price_includes);
        }
        if (isset($objectDetails->price_excludes)) {
            $objectDetails->price_excludes = json_decode($objectDetails->price_excludes);
        }
        if ($objectDetails->price) {
            $objectDetails->price = intval($objectDetails->price);
        }

        if (isset($objectDetails->category->name)) {
            $objectDetails->categoryName = json_decode($objectDetails->category->name);
        }
        if (isset($objectDetails->city->name)) {
            $objectDetails->cityName = json_decode($objectDetails->city->name);
        }
        if (isset($objectDetails->color->color_name)) {
            $objectDetails->colorName = json_decode($objectDetails->color->color_name);
        }
        if (isset($objectDetails->country->name)) {
            $objectDetails->countryName = json_decode($objectDetails->country->name);
        }
        if (isset($objectDetails->descriptions)) {
            foreach ($objectDetails->descriptions as $key => $description) {
                if (isset($description->long_description)) {
                    $objectDetails->long_description = json_decode($description->long_description);
                }
                if (isset($description->short_description)) {
                    $objectDetails->short_description = json_decode($description->short_description);
                }
            }
            unset($objectDetails->descriptions);
        }
        if (isset($objectDetails->governrate->name)) {
            $objectDetails->governrateName = json_decode($objectDetails->governrate->name);
        }
        if (!count($objectDetails->images) == 0) {
            $filePath = new UploadingService;
            $uploads = $filePath->get_path('objects');
            foreach ($objectDetails->images as $key => $image) {
                $imagePath = $uploads . $image->imagePath;
            }
            $objectDetails->imagePath = $imagePath;
            unset($objectDetails->images);
        }else
        {
            $objectDetails->imagePath = null;   
        }
        return $objectDetails;
    }
}
