<?php

namespace MvcCore\Rental\Helpers;

class ArrayToJson
{
    public static function arrayToJson(array $arrData) : string
    {

        // $jsonData = '';
        // foreach ($arrData as $key => $value) {
        //     $jsonData .= json_encode([$key => $value]);
        // }
        // $jsonData = str_replace('}{', ',', $jsonData);
       $jsonData =  json_encode($arrData);
        return $jsonData;
    }
}
