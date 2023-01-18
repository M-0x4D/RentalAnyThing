<?php

namespace MvcCore\Rental\Database\Seeders;

use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Models\MainBanarModel;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Support\Faker\Faker;
use MvcCore\Rental\Support\Filesystem\Storage;

use function PHPSTORM_META\map;

class BanarImageSeeder
{

    public function createBannerImage()
    {

        $imagePath = '63a2bd1737ca2.jpg';
        MainBanarModel::create([

            'imagePath' => $imagePath
        ]);
    }
}
