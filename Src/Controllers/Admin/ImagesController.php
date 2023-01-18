<?php

namespace MvcCore\Rental\Controllers\Admin;

use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Requests\ImageStoreRequest;
use MvcCore\Rental\Requests\ImageUpdateRequest;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Validations\Alerts;
use MvcCore\Rental\Middlewares\CheckApiCredentials;
use Illuminate\Database\Eloquent;
use MvcCore\Rental\Support\Http\Request;
use JTL\Shop;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Controllers\Admin\Crud;
use MvcCore\Rental\Controllers\Admin\ICrud;



class ImagesController implements ICrud
{
    public function index()
    {

        $Images    = Image::take(10)->get();

        $filePath = new UploadingService;
        $uploads = $filePath->get_path('cars');
        foreach ($Images as $image) {
            $modelName = json_decode($image->model_name);
                $image->modelNameEN = $modelName->en;
                $image->modelNameDE = $modelName->de;
        $image->carImage = $uploads. $image['imagePath'];
        }
        $smarty = Shop::Smarty();
        return $smarty->assign('Images', $Images);
    }


    public function create(Request $request)
    {

        $checkCredentials = new CheckApiCredentials;
        $checkCredentials->handle();
        
        $validator = new ImageStoreRequest;
        $validatedData = $validator->validate($request->all());
        try {

            if (isset($_FILES['image'])) {
                $file = $_FILES['image'];
                $fileUpload = new UploadingService;
                $fileName = $fileUpload->uploadFile($file, 'objects');
                
            }
            else {
                # code...
            }
        } catch (\Exception $e) {
            return Response::json($e);
        }

        Image::create(
            [
                'imagePath' => $fileName,
                'object_id' => $validatedData['object_id'],
            ]
        );
        return Response::json('Record is created successfully' , 201);
        
    }

    public function update(Request $request)
    {

        $validator = new ImageUpdateRequest;
        $validatedData = $validator->validate($request->all());

        $objectImage     = new Image;

        if ($_FILES['image']['error'] === 0) {
            $file = $_FILES['image'];
            $fileUpload = new UploadingService;
            $fileName = $fileUpload->uploadFile($file, 'cars');

            $objectImage->where('id' , $validatedData['ImageId'])->update(
                [
                    'imagePath' => $fileName,
                    'object_id' => $validatedData['object_id'],
                ]
                
            );
        return Response::json('Record is updated successfully' , 206);

        } else {
            $objectImage->where('id',$validatedData['ImageId'])->update(
                [
                    'object_id' => $validatedData['object_id'],
                ]
            );
        return Response::json('Failed to update this record' , 206);

        }


    }

    public function destroy(Request $request)
    {
        Image::where('id' , $request->all()['id'])->delete();
        // Alerts::show('success', 'Record is deleted successfully', 'Deleted:');
        return Response::json('Record is deleted successfully' , 204);

    }
}
