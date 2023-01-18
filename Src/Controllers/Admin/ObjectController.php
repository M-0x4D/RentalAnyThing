<?php

namespace MvcCore\Rental\Controllers\Admin;

use MvcCore\Rental\Controllers\Admin\Test as AdminTest;
use MvcCore\Rental\Models\ApiCredentials;
use MvcCore\Rental\Models\TokenParameter;
use MvcCore\Rental\Requests\ApiCredentialsStoreRequest;
use MvcCore\Rental\Requests\ApiCredentialsUpdateRequest;
use MvcCore\Rental\Validations\Alerts;
use Symfony\Component\Dotenv\Dotenv as DotenvDotenv;
use Symfony\Component\Dotenv\Dotenv;
use MvcCore\Rental\Controllers\Admin\Test;
use MvcCore\Rental\Support\Http\HttpRequest;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Support\Http\Server;
use JTL\Shop;
use MvcCore\Rental\Support\Facades\Configs\Configs;
use MvcCore\Rental\Helpers\GetPaypalMode;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Requests\ObjectStoreRequest;
use MvcCore\Rental\Requests\ObjectUpdateRequest;
use MvcCore\Rental\Requests\CategoryStoreRequest;
use MvcCore\Rental\Requests\CategoryUpdateRequest;
use MvcCore\Rental\Requests\LabelStoreRequest;
use MvcCore\Rental\Requests\LabelUpdateRequest;
use MvcCore\Rental\Requests\ImageStoreRequest;
use MvcCore\Rental\Requests\ImageUpdateRequest;
use MvcCore\Rental\Requests\LocationStoreRequest;
use MvcCore\Rental\Requests\LocationUpdateRequest;
use MvcCore\Rental\Requests\DescriptionStoreRequest;
use MvcCore\Rental\Requests\DescriptionUpdateRequest;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Models\Category;
use MvcCore\Rental\Models\Description;
use MvcCore\Rental\Models\Location;
use MvcCore\Rental\Models\UnBookedObject;
use MvcCore\Rental\Controllers\Admin\ValidateObject;
use MvcCore\Rental\Models\Color;
use MvcCore\Rental\Models\ObjectModel;
use MvcCore\Rental\Models\Label;
use MvcCore\Rental\Models\Country;
use MvcCore\Rental\Models\City;
use MvcCore\Rental\Models\Governrate;
use MvcCore\Rental\Models\Rental;
use MvcCore\Rental\Controllers\Admin\Crud;
use MvcCore\Rental\Controllers\Admin\ICrud;
use MvcCore\Rental\Models\Currency;

class ObjectController implements ICrud
{
    public function index()
    {

        $objects    = ObjectModel::with(['color' , 'governrate' , 'city' , 'country' , 'category' , 'descriptions' , 'labels' , 'currency' , 'images'])->get();
        foreach ($objects as $key => $object) {
            if (isset($object->name)) {
                $objectName = json_decode($object->name);
                $object->objectName = $objectName;
                unset($object->name);
            }
            if ($object->price) {
                $object->price = intval($object->price);
            }
            if (isset($object->price_includes)) {
                $object->priceIncludes = json_decode($object->price_includes);
                unset($object->price_includes);
            }
            if (isset($object->price_excludes)) {
                $object->priceExcludes = json_decode($object->price_excludes);
                unset($object->price_excludes);
            }
            if ($object->color) {
                $object->colorName = json_decode($object->color->color_name);
                unset($object->color);
            }
            if ($object->governrate) {
                $object->governrateName = json_decode($object->governrate->name);
            }
            if ($object->city) {
                $object->cityName = json_decode($object->city->name);
            }
            if ($object->country) {
                $object->countryName = json_decode($object->country->name);
            }
            if ($object->category) {
                $object->categoryName = json_decode($object->category->name);
                unset($object->category);
            }
            if ($object->descriptions) {
                foreach ($object->descriptions as $key => $description) {
                    $object->shortDescriptions = json_decode($description->short_description);
                    $object->longDescriptions = json_decode($description->long_description);
                }
                unset($object->descriptions);
            }
            foreach ($object->images as $key => $image) {
                $imagePath = $image->imagePath;
            $filePath = new UploadingService;
            $uploads = $filePath->get_path('objects');
            $object->image = $uploads . $imagePath;
            }
            unset($object->images);
        }

        $smarty = Shop::Smarty();
        return $smarty->assign('objects', $objects);
    }


    public function create(Request $request)
    {

        // $checkCredentials = new CheckApiCredentials;
        // $checkCredentials->handle();
        $data = $request->all();
        $validatedData = ValidateObject::validateStoreObject($data);
        $arrObjectName = ['en' => $validatedData['object_name_en'], 'de' => $validatedData['object_name_de']];
        $objectName = json_encode($arrObjectName);
        $arrShortDescription = ['en' => $validatedData['short_description_en'], 'de' => $validatedData['short_description_de']];
        $shortDescription = json_encode($arrShortDescription);
        $arrLongDescription = ['en' => $validatedData['long_description_en'], 'de' => $validatedData['long_description_de']];
        $longDescription = json_encode($arrLongDescription);
        $categoryId = $validatedData['category_id'];
        $colorId = $validatedData['color_id'];
        $arrPriceIncludes = ['en' => $validatedData['price_includes_en'], 'de' => $validatedData['price_includes_de']];
        $jsonPriceIncludes = json_encode($arrPriceIncludes);
        $arrPriceExcludes = ['en' => $validatedData['price_excludes_en'], 'de' => $validatedData['price_excludes_de']];
        $jsonPriceExcludes = json_encode($arrPriceExcludes);

        $object = ObjectModel::create([
            'name' => $objectName,
            'category_id' => $categoryId,
            'color_id' => $colorId,
            'price' => intval($validatedData['price']),
            'duration' => $validatedData['duration'],
            'currency_id' => $validatedData['currency_id'],
            'price_includes' => $jsonPriceIncludes,
            'price_excludes' => $jsonPriceExcludes,
            'quantity' => $data['quantity'],
            'country_id' => $data['country_id'],
            'governrate_id' => $data['governrate_id'],
            'city_id' => $data['city_id'],
        ]);

        Description::create([
            'short_description' => $shortDescription,
            'long_description' => $longDescription,
            'object_id' => $object->id
        ]);


        if (!empty($validatedData['additional_features'])) {
            foreach ($validatedData['additional_features'] as $value) {
                Label::create([
                    'name' => $value['name'],
                    'type' => $value['type'],
                    'value' => $value['value'],
                    'object_id' => $object->id
                ]);
            }
        }

        try {
            $file = $validatedData['image'];
            $fileUpload = new UploadingService;
            $fileName = $fileUpload->uploadFile($file, 'objects');
            Image::create(
                [
                    'imagePath' => $fileName,
                    'object_id' => $object->id,
                ]
            );
        } catch (\Exception $e) {
            return Response::json($e);
        }

        return Response::json('Record is created successfully', 201);
    }




    public function update(Request $request)
    {

        $data = $request->all();
        $validatedData = ValidateObject::validateStoreObject($data);
        $arrObjectName = ['en' => $validatedData['object_name_en'], 'de' => $validatedData['object_name_de']];
        $objectName = json_encode($arrObjectName);
        $arrShortDescription = ['en' => $validatedData['short_description_en'], 'de' => $validatedData['short_description_de']];
        $shortDescription = json_encode($arrShortDescription);
        $arrLongDescription = ['en' => $validatedData['long_description_en'], 'de' => $validatedData['long_description_de']];
        $longDescription = json_encode($arrLongDescription);
        $categoryId = $validatedData['category_id'];
        $colorId = $validatedData['color_id'];
        $object = ObjectModel::find($validatedData['id']);
        $arrPriceIncludes = ['en' => $validatedData['price_includes_en'], 'de' => $validatedData['price_includes_de']];
        $jsonPriceIncludes = json_encode($arrPriceIncludes);
        $arrPriceExcludes = ['en' => $validatedData['price_excludes_en'], 'de' => $validatedData['price_excludes_de']];
        $jsonPriceExcludes = json_encode($arrPriceExcludes);

        Description::where('object_id', $validatedData['id'])->updateOrCreate([
            'short_description' => $shortDescription,
            'long_description' => $longDescription,
            'object_id' => $object->id
        ]);
        if (!empty($validatedData['additional_features'])) {
            foreach ($validatedData['additional_features'] as $value) {
                Label::where('object_id', $validatedData['id'])->updateOrCreate([
                    'name' => $value['name'], //$validatedData['custom_label_name'],
                    'type' => $value['type'], //$validatedData['custom_features_type'],
                    'value' => $value['value'], //$validatedData['add-feat-nam'],
                    'object_id' => $validatedData['id']
                ]);
            }
        } else {
            Label::where('object_id', $validatedData['id'])->delete();
        }
        ObjectModel::where('id', $validatedData['id'])->update(
            [
                'name' => $objectName,
                'category_id' => $categoryId,
                'color_id' => $colorId,
                'price' => $validatedData['price'],
                'duration' => $validatedData['duration'],
                'price_includes' => $jsonPriceIncludes,
                'price_excludes' => $jsonPriceExcludes,
                'country_id' => $data['country_id'],
                'governrate_id' => $data['governrate_id'],
                'city_id' => $data['city_id'],
            ]
        );

        try {
            $file = $validatedData['image'];
            $fileUpload = new UploadingService;
            $fileName = $fileUpload->uploadFile($file, 'objects');
            Image::where('object_id', $validatedData['id'])->update([
                'imagePath' => $fileName,
                'object_id' => $validatedData['id'],
            ]);
        } catch (\Exception $e) {
            return Response::json($e);
        }
        return Response::json('Record is updated successfully', 206);
    }


    public function destroy(Request $request)
    {
        $data = $request->all();
        $imagePath = Image::where('object_id', $data['id'])->pluck('imagePath')->first();
        $fileService = new UploadingService();
        $fileService->deleteFile($imagePath, 'objects');
        Image::where('object_id', $data['id'])->delete();
        Description::where('object_id', $data['id'])->delete();
        Label::where('object_id', $data['id'])->delete();
        Rental::where('object_id', $data['id'])->delete();
        ObjectModel::where('id', $data['id'])->delete();
        return Response::json('Record is deleted successfully', 204);
    }
}
