<?php

namespace MvcCore\Rental\Controllers\Frontend;

use MvcCore\Rental\Models\MainBanarModel;
use MvcCore\Rental\Support\Debug\Debugger;
use JTL\Shop;
use MvcCore\Rental\Services\UploadingService;



class MainBanar
{
    public function index()
    {
        $banar = MainBanarModel::get()->first();
        if (isset($banar)) {
            $path = $banar->imagePath;
            $filePath = new UploadingService;
            $uploads = $filePath->get_path('objects');
            $path = $uploads . $path;
            $smarty = Shop::Smarty();
            $smarty->assign('banner', $path);
        }
    }
}
