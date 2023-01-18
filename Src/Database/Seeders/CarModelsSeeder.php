<?php

namespace MvcCore\Rental\Database\Seeders;

use MvcCore\Rental\Models\CarModels;

class CarModelsSeeder
{

    public function createModels()
    {
        $model     = new CarModels;
        $variables = [
            [
                'model_name' => '{"en":"BMW X3","de":"BMW X3"}',
                'manufacturer_id' => 1,
            ],
            [
                'model_name' => '{"en":"BMW M4","de":"BMW M4"}',
                'manufacturer_id' => 1,
            ],
            [
                'model_name' => '{"en":"BMW X6 M50i","de":"BMW X6 M50i"}',
                'manufacturer_id' => 1,
            ],
            [
                'model_name' => '{"en":"BMW X3","de":"BMW X3"}',
                'manufacturer_id' => 1,
            ],
            [
                'model_name' => '{"en":"Geely GE11","de":"Geely GE11"}',
                'manufacturer_id' => 2,
            ],
            [
                'model_name' => '{"en":"Geely Panda","de":"Geely Panda"}',
                'manufacturer_id' => 2,
            ],
            [
                'model_name' => '{"en":"Geely Emgrand EC8","de":"Geely Emgrand EC8"}',
                'manufacturer_id' => 2,
            ],
            [
                'model_name' => '{"en":"Volkswagen Taigun","de":"Volkswagen Taigun"}',
                'manufacturer_id' => 6,
            ],
            [
                'model_name' => '{"en":"Volkswagen Vento","de":"Volkswagen Vento"}',
                'manufacturer_id' => 6,
            ],
            [
                'model_name' => '{"en":"Volkswagen Virtus","de":"Volkswagen Virtus"}',
                'manufacturer_id' => 6,
            ],
            [
                'model_name' => '{"en":"Mercedes-Maybach EQS","de":"Mercedes-Maybach EQS"}',
                'manufacturer_id' => 16,
            ],
            [
                'model_name' => '{"en":"Mercedes-Maybach GLS","de":"Mercedes-Maybach GLS"}',
                'manufacturer_id' => 16,
            ],
        ];

        array_map(fn ($variable) => $model->create($variable), $variables);
    }
}
