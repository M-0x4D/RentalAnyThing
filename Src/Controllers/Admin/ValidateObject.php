<?php
namespace MvcCore\Rental\Controllers\Admin;

use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Controllers;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Requests\ObjectStoreRequest;
use MvcCore\Rental\Requests\LabelStoreRequest;
use MvcCore\Rental\Requests\ImageStoreRequest;
use MvcCore\Rental\Requests\LocationStoreRequest;
use MvcCore\Rental\Requests\DescriptionStoreRequest;
use MvcCore\Rental\Requests\CategoryStoreRequest;


use MvcCore\Rental\Requests\ObjectUpdateRequest;
use MvcCore\Rental\Requests\LabelUpdateRequest;
use MvcCore\Rental\Requests\ImageUpdateRequest;
use MvcCore\Rental\Requests\LocationUpdateRequest;
use MvcCore\Rental\Requests\DescriptionUpdateRequest;
use MvcCore\Rental\Requests\CategoryUpdateRequest;


 class ValidateObject
{
    public static function validateStoreObject($data)
    {
        CategoryStoreRequest::validate($data);
        LocationStoreRequest::validate($data);
        ObjectStoreRequest::validate($data);
        DescriptionStoreRequest::validate($data);
        LabelStoreRequest::validate($data);
        ImageStoreRequest::validate($data);
        return $data;
    }

    public static function validateUpdateObject($data)
    {

        CategoryUpdateRequest::validate($data);
        LocationUpdateRequest::validate($data);
        ObjectUpdateRequest::validate($data);
        DescriptionUpdateRequest::validate($data);
        LabelUpdateRequest::validate($data);
        ImageUpdateRequest::validate($data);
        return $data;
    }

}