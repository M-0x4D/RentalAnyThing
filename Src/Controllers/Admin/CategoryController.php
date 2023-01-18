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
use MvcCore\Rental\Models\Category;
use MvcCore\Rental\Middlewares\CheckApiCredentials;
use MvcCore\Rental\Requests\CategoryStoreRequest;
use MvcCore\Rental\Requests\CategoryUpdateRequest;
use MvcCore\Rental\Controllers\Admin\Crud;
use MvcCore\Rental\Controllers\Admin\ICrud;
use MvcCore\Rental\Models\Color;
use MvcCore\Rental\Models\ObjectModel;
use MvcCore\Rental\Models\Label;
use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Models\Description;
use MvcCore\Rental\Models\Rental;

class CategoryController implements ICrud
{
    public function index()
    {
        $categories    = Category::get();
        foreach ($categories as $category) {
            $categoryName = json_decode($category->name);
            $category->categoryNameEN = $categoryName->en;
            $category->categoryNameDE = $categoryName->de;
        }
        $smarty = Shop::Smarty();
        return $smarty->assign('categories', $categories);
    }



    public function create(Request $request)
    {
        $checkCredentials = new CheckApiCredentials;
        $checkCredentials->handle();
        $validator = new CategoryStoreRequest;
        $validatedData = $validator->validate($request->all());
        $arrName = ['en' => $validatedData['categories_name_en'], 'de' => $validatedData['categories_name_de']];
        $jsonName = json_encode($arrName);
        $categoryDublicated = Category::where('name' , $jsonName)->first();
        if (!$categoryDublicated) {
            Category::create([
                'name' => $jsonName
            ]);
        return Response::json('Record is created successfully' , 201);
        }
        else {
            return response()->json('this category is exists', 404);
        }

    }


    public function update(Request $request)
    {
        $validator = new CategoryUpdateRequest;
        $validatedData = $validator->validate($request->all());
        $arrName = ['en' => $validatedData['category_name_en'], 'de' => $validatedData['category_name_de']];
        $jsonName = json_encode($arrName);
        $categoryDublicated = Category::where('name' , $jsonName)->first();
        if (!$categoryDublicated) {
            Category::where('id' , $validatedData['categoryId'])->update(
                [
                    'name' => $jsonName,
                ]
            );
        return Response::json('Record is updated successfully' , 206);
        }
        else {
            return response()->json('this category is exists', 404);
        }
    }



    public function destroy(Request $request)
    {
        $data = $request->all();
        $objects = ObjectModel::where('category_id', $data['id'])->get();
        $objects->map(function ($object) {
            $imagePath = Image::where('object_id', $object->id)->pluck('imagePath')->first();
            $fileService = new UploadingService();
            $fileService->deleteFile($imagePath, 'objects');
            Image::where('object_id', $object->id)->delete();
            Description::where('object_id', $object->id)->delete();
            Label::where('object_id', $object->id)->delete();
            Rental::where('object_id', $object->id)->delete();
        });
        ObjectModel::where('category_id', $data['id'])->delete();
        Category::where('id',$data['id'])->delete();
        return Response::json('Record is deleted successfully' , 204);
    }

}