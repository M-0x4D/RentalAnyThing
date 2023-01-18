<?php

namespace MvcCore\Rental\Database\Seeders;

use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Support\Faker\Faker;
use MvcCore\Rental\Support\Filesystem\Storage;

use function PHPSTORM_META\map;

class CarImagesSeeder
{

    public function createImages()
    {

        $faker = new Faker();
        $uName =  microtime();

        $faker->fakerImage->uploadImage("cars", "picture_one.jpg","https://i.ytimg.com/vi/R1-aTV05akU/maxresdefault.jpg");
        $faker->fakerImage->uploadImage("cars", "picture_two.jpg","https://mediapool.bmwgroup.com/cache/P9/201710/P90281760/P90281760-the-new-bmw-x3-m40i-phytonic-blue-10-2017-600px.jpg");
        $faker->fakerImage->uploadImage("cars", "picture_three.jpg","http://2.bp.blogspot.com/-prk4uuAkuUA/T_9_8IWhKBI/AAAAAAAAAwM/vj_MBGjAXs0/s1600/geely+5.jpg");
        $faker->fakerImage->uploadImage("cars", "picture_four.jpg","https://stimg2.cardekho.com/images/carNewsimages/userimages/650X420/27849/1632743809670/GeneralNews.jpg");
        $faker->fakerImage->uploadImage("cars", "picture_five.jpg","https://www.motorworldindia.com/wp-content/uploads/2017/06/VW-Polo-featured.jpg");
        $faker->fakerImage->uploadImage("cars", "picture_six.jpg","https://stimg.cardekho.com/images/car-images/930x620/Volkswagen/Volkswagen-Vento/7157/1567669183094/223_Lapiz-Blue_1f43c3.jpg?tr=w-420");
        $faker->fakerImage->uploadImage("cars", "picture_seven.jpg","https://arabgt.com/wp-content/uploads/2021/09/%D9%85%D8%B1%D8%B3%D9%8A%D8%AF%D8%B3-%D9%85%D8%A7%D9%8A%D8%A8%D8%A7%D8%AE-EQS-SUV-.jpg");
        $faker->fakerImage->uploadImage("cars", "picture_eight.jpg","https://www.almrsal.com/wp-content/uploads/2013/02/geely-emgrand-ec8-006.jpg");
        
        $image     = new Image;
        $variables = [
            [
                'imagePath' => 'picture_one.jpg',
                'car_id' => '1',
            ],
            [
                'imagePath' => 'picture_two.jpg',
                'car_id' => '2',
            ],
            [
                'imagePath' => 'picture_three.jpg',
                'car_id' => '3',
            ],
            [
                'imagePath' => 'picture_four.jpg',
                'car_id' => '4',
            ],
            [
                'imagePath' => 'picture_five.jpg',
                'car_id' => '5',
            ],
            [
                'imagePath' => 'picture_six.jpg',
                'car_id' => '6',
            ],
            [
                'imagePath' => 'picture_seven.jpg',
                'car_id' => '7',
            ],
            [
                'imagePath' => 'picture_eight.jpg',
                'car_id' => '8',
            ],
        ];

        array_map(fn ($variable) => $image->create($variable), $variables);
    }
}