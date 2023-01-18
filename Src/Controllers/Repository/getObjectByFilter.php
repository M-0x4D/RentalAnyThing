<?php

namespace MvcCore\Rental\Controllers\Repository;

use MvcCore\Rental\Models\Car;
use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Models\ObjectModel;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Support\Facades\Localization\Lang;
use MvcCore\Rental\Helpers\Response;


class getObjectByFilter
{

    public function get(array $values, $countryId , $governrateId , $cityId, $categoryId)
    {
        if (isset($values['price']) && isset($values['duration'])) {
            if ($values['price']['0'] == 200) {
                $maximumValue = $values['price']['0'];
                $objects = ObjectModel::Where('price', '>=', $maximumValue)
                    ->where('country_id', $countryId)
                    ->where('governrate_id', $governrateId)
                    ->where('city_id', $cityId)
                    ->where('duration', $values['duration'])
                    ->where('category_id', $categoryId)
                    ->where('booked', false)->with('currency')->get();
                return $objects;
            } else {
                $objects = ObjectModel::where(function ($query) use ($values, $countryId , $governrateId , $cityId, $categoryId) {
                    $query->whereBetween('price', array($values['price']['0'], $values['price']['1']))
                    ->where('country_id', $countryId)
                    ->where('governrate_id', $governrateId)
                    ->where('city_id', $cityId)
                        ->where('duration', $values['duration'])
                        ->where('category_id', $categoryId)
                        ->where('booked', false);
                })->with('currency')->get();
                return $objects;
            }
        } elseif (count($values) === 1 && isset($values['duration'])) {
            $objects = ObjectModel::where('duration', $values['duration'])
                ->where('booked', false)
                ->where('country_id', $countryId)
                    ->where('governrate_id', $governrateId)
                    ->where('city_id', $cityId)
                ->where('category_id', $categoryId)->with('currency')->get();
            return $objects;
        } elseif (count($values) === 1 && isset($values['price'])) {
            if ($values['price']['0'] == 200) {
                $maximumValue = $values['price']['0'];
                $objects = ObjectModel::Where('price', '>=', $maximumValue)
                ->where('country_id', $countryId)
                ->where('governrate_id', $governrateId)
                ->where('city_id', $cityId)
                    ->where('category_id', $categoryId)
                    ->where('booked', false)->with('currency')->get();
                return $objects;
            } else {
                $objects = ObjectModel::where(function ($query) use ($values, $countryId , $governrateId , $cityId, $categoryId) {
                    $query->whereBetween('price', array($values['price']['0'], $values['price']['1']))
                    ->where('country_id', $countryId)
                    ->where('governrate_id', $governrateId)
                    ->where('city_id', $cityId)
                        ->where('category_id', $categoryId)
                        ->where('booked', false);
                })->with('currency')->get();
                return $objects;
            }
        } else {
            return 'wrong filter';
        }
    }





    public function getWithGov(array $values, $countryId , $governrateId, $categoryId)
    {
        if (isset($values['price']) && isset($values['duration'])) {
            if ($values['price']['0'] == 200) {
                $maximumValue = $values['price']['0'];
                $objects = ObjectModel::Where('price', '>=', $maximumValue)
                    ->where('country_id', $countryId)
                    ->where('governrate_id', $governrateId)
                    ->where('duration', $values['duration'])
                    ->where('category_id', $categoryId)
                    ->where('booked', false)->with('currency')->get();
                return $objects;
            } else {
                $objects = ObjectModel::where(function ($query) use ($values, $countryId , $governrateId , $categoryId) {
                    $query->whereBetween('price', array($values['price']['0'], $values['price']['1']))
                    ->where('country_id', $countryId)
                    ->where('governrate_id', $governrateId)
                        ->where('duration', $values['duration'])
                        ->where('category_id', $categoryId)
                        ->where('booked', false);
                })->with('currency')->get();
                return $objects;
            }
        } elseif (count($values) === 1 && isset($values['duration'])) {
            $objects = ObjectModel::where('duration', $values['duration'])
                ->where('booked', false)
                ->where('country_id', $countryId)
                    ->where('governrate_id', $governrateId)
                ->where('category_id', $categoryId)->with('currency')->get();
            return $objects;
        } elseif (count($values) === 1 && isset($values['price'])) {
            if ($values['price']['0'] == 200) {
                $maximumValue = $values['price']['0'];
                $objects = ObjectModel::Where('price', '>=', $maximumValue)
                ->where('country_id', $countryId)
                ->where('governrate_id', $governrateId)
                    ->where('category_id', $categoryId)
                    ->where('booked', false)->with('currency')->get();
                return $objects;
            } else {
                $objects = ObjectModel::where(function ($query) use ($values, $countryId , $governrateId, $categoryId) {
                    $query->whereBetween('price', array($values['price']['0'], $values['price']['1']))
                    ->where('country_id', $countryId)
                    ->where('governrate_id', $governrateId)
                        ->where('category_id', $categoryId)
                        ->where('booked', false);
                })->with('currency')->get();
                return $objects;
            }
        } else {
            return 'wrong filter';
        }
    }




    public function getWithoutGov(array $values, $countryId, $categoryId)
    {
        if (isset($values['price']) && isset($values['duration'])) {
            if ($values['price']['0'] == 200) {
                $maximumValue = $values['price']['0'];
                $objects = ObjectModel::Where('price', '>=', $maximumValue)
                    ->where('country_id', $countryId)

                    ->where('duration', $values['duration'])
                    ->where('category_id', $categoryId)
                    ->where('booked', false)->with('currency')->get();
                return $objects;
            } else {
                $objects = ObjectModel::where(function ($query) use ($values, $countryId , $categoryId) {
                    $query->whereBetween('price', array($values['price']['0'], $values['price']['1']))
                    ->where('country_id', $countryId)
                        ->where('duration', $values['duration'])
                        ->where('category_id', $categoryId)
                        ->where('booked', false);
                })->with('currency')->get();
                return $objects;
            }
        } elseif (count($values) === 1 && isset($values['duration'])) {
            $objects = ObjectModel::where('duration', $values['duration'])
                ->where('booked', false)
                ->where('country_id', $countryId)
                ->where('category_id', $categoryId)->with('currency')->get();
            return $objects;
        } elseif (count($values) === 1 && isset($values['price'])) {
            if ($values['price']['0'] == 200) {
                $maximumValue = $values['price']['0'];
                $objects = ObjectModel::Where('price', '>=', $maximumValue)
                ->where('country_id', $countryId)
                    ->where('category_id', $categoryId)
                    ->where('booked', false)->with('currency')->get();
                return $objects;
            } else {
                $objects = ObjectModel::where(function ($query) use ($values, $countryId, $categoryId) {
                    $query->whereBetween('price', array($values['price']['0'], $values['price']['1']))
                    ->where('country_id', $countryId)
                        ->where('category_id', $categoryId)
                        ->where('booked', false);
                })->with('currency')->get();
                return $objects;
            }
        } else {
            return 'wrong filter';
        }
    }
}
