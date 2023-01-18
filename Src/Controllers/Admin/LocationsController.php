<?php

namespace MvcCore\Rental\Controllers\Admin;

use MvcCore\Rental\Models\Location;
use MvcCore\Rental\Models\Car;
use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Requests\LocationStoreRequest;
use MvcCore\Rental\Requests\LocationUpdateRequest;
use MvcCore\Rental\Validations\Alerts;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Middlewares\CheckApiCredentials;
use Illuminate\Database\Eloquent;
use JTL\Shop;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Controllers\Admin\Crud;
use MvcCore\Rental\Controllers\Admin\ICrud;
use PhpParser\Node\Expr\Cast\Object_;
use MvcCore\Rental\Models\Color;
use MvcCore\Rental\Models\ObjectModel;
use MvcCore\Rental\Models\Label;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Models\Category;
use MvcCore\Rental\Models\Description;
use MvcCore\Rental\Models\Rental;

class LocationsController implements ICrud
{
    public function index()
    {
        $location     = new Location;
        $locations    = Location::get();
        foreach ($locations as $location) {
            $locationName = json_decode($location->location_name);
            $location->locationNameEN = $locationName->en;
            $location->locationNameDE = $locationName->de;
        }
        $smarty = Shop::Smarty();
        return $smarty->assign('locations', $locations);
    }


    public function create(Request $request)
    {
        $checkCredentials = new CheckApiCredentials;
        $checkCredentials->handle();

        $validator = new LocationStoreRequest;
        $validatedData = $validator->validate($request->all());

        $arrLocationName =  ['en' => $validatedData['location_name_en'], 'de' => $validatedData['location_name_de']];
        $jsonLocationName = json_encode($arrLocationName);

        $location     = new Location;
        $location->create(
            [
                'location_name' => $jsonLocationName,
            ]
        );
        return Response::json('Record is created successfully', 201);
    }




    public function update(Request $request)
    {

        $validator = new LocationUpdateRequest;
        $validatedData = $validator->validate($request->all());

        $arrLocationName =  ['en' => $validatedData['location_name_en'], 'de' => $validatedData['location_name_de']];
        $jsonLocationName = json_encode($arrLocationName);

        $location     = new Location;
        $location->where('id', $validatedData['locationId'])->update(
            [
                'location_name' => $jsonLocationName,
            ]

        );

        return Response::json('Record is updated successfully', 206);
    }


    public function destroy(Request $request)
    {
        $data = $request->all();

        $objects = ObjectModel::where('location_id', $data['id'])->get();
        $objects->map(function ($object) {
            $imagePath = Image::where('object_id', $object->id)->pluck('imagePath')->first();
            $fileService = new UploadingService();
            $fileService->deleteFile($imagePath, 'objects');
            Image::where('object_id', $object->id)->delete();
            Description::where('object_id', $object->id)->delete();
            Label::where('object_id', $object->id)->delete();
            Rental::where('object_id', $object->id)->delete();
        });
        ObjectModel::where('location_id', $data['id'])->delete();
        Location::where('id', $data['id'])->delete();
        return Response::json('Record is deleted successfully', 204);
    }
}
