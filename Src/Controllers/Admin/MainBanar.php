<?php

namespace MvcCore\Rental\Controllers\Admin;

use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Models\MainBanarModel;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Helpers\Response;
use JTL\Shop;
use MvcCore\Rental\Controllers\Admin\Crud;
use MvcCore\Rental\Controllers\Admin\ICrud;



class MainBanar implements ICrud
{

    public function index()
    {

        $imagePath = MainBanarModel::get()->pluck('imagePath')->first();
        $banarId = MainBanarModel::get()->pluck('id')->first();
        if (isset($imagePath)) {
            $filePath = new UploadingService;
            $uploads = $filePath->get_path('objects');
            $path = $uploads . $imagePath;
            $banar = ['path' => $path, 'banarId' => $banarId];
            $smarty = Shop::Smarty();
            $smarty->assign('banar', $banar);
        }
    }


    public function create(Request $request)
    {
        $data = $request->all();
        $file = $data['banner'];
        $fileUpload = new UploadingService;
        $fileName = $fileUpload->uploadFile($file, 'objects');
        $images = MainBanarModel::get();
        if ($images->isNotEmpty()) {
            return Response::json('Banar image already exists', 404);
        } else {
            MainBanarModel::create([
                'imagePath' => $fileName
            ]);
            return Response::json('Record is created successfully', 201);
        }
    }



    public function update(Request $request)
    {
        $data = $request->all();
        $file = $data['banner'];
        $fileUpload = new UploadingService;
        $fileName = $fileUpload->uploadFile($file, 'objects');
        MainBanarModel::where('id', $data['id'])->update([
            'imagePath' => $fileName
        ]);
        return Response::json('Record is updates successfully', 206);
    }

    public function destroy(Request $request)
    {
        MainBanarModel::where('id' ,$request->all()['id'] )->delete();
        // Debugger::die_and_dump($imagePath);
        // $filePath = new UploadingService;
        // $uploads = $filePath->get_path('objects');
        // $path = $uploads . $imagePath;
        // $filePath->deleteFile($path , 'objects');
        return Response::json('Record is deleted successfully', 204);

    }
}
