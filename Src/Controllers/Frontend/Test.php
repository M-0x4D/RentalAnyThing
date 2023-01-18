<?php

namespace MvcCore\Rental\Controllers\Frontend;

use Illuminate\Support\Arr;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Models\Car;
use MvcCore\Rental\Models\FeatureCar;
use MvcCore\Rental\Models\CarModels;
use MvcCore\Rental\Models\Feature;
use MvcCore\Rental\Requests\getFeaturePriceRequest;
use MvcCore\Rental\Support\Facades\Filesystem\DirectoryComposer;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Models\ObjectModel;
use MvcCore\Rental\Support\DisplayData;
use MvcCore\Rental\Support\Facades\Localization\Lang;
use MvcCore\Rental\Database\Seeders\TokenParametersSeeder;
use JTL\Session\Frontend;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Response as FacadesResponse;
use MvcCore\Rental\Support\Http\Proxy;
use JTL\Session\AbstractSession;
use MvcCore\Rental\Support\Http\Session;
use MvcCore\Rental\Helpers\Redirect;
use MvcCore\Rental\Support\Mail\MailService;
use MvcCore\Rental\Models\Product;
use MvcCore\Rental\Models\Rental;
use MvcCore\Rental\Models\Category;
use MvcCore\Rental\Database\Initialization\Connection;
/**
 * 
 * test class
 */
class Test
{


    static function calculateSquares(array $num)
    {
        return  Response::json($num);
    }
    /**
     * 
     * test function 
     * 
     */
    public function fake(Request $request)
    {
        $data = $request->all();
        $pageNumber = $data['page_number'];
        Paginator::currentPageResolver(function () use ($pageNumber) {
            return $pageNumber;
        });
        $categories = Category::paginate(10);
        // $perPage = 10;
        // $data = $request->all();
        // $pageNumber = $data['page_number'];
        // $startAt = $perPage * ($pageNumber - 1);
        // $categories = Category::limit($startAt,$perPage)->get();

        return Response::json($categories);
    }
}
