<?php

namespace MvcCore\Rental\Database\Seeders;

use MvcCore\Rental\Models\Manufacturer;

class ManufacturersSeeder
{

    public function createManufacturers()
    {
        $manufacturer     = new Manufacturer;
        $variables = [
            [
                'manufacturer_name' => '{"en":"BMW","de":"BMW"}',
            ],
            [
                'manufacturer_name' => '{"en":"Geely","de":"Geely"}',
            ],
            [
                'manufacturer_name' => '{"en":"Hyundai","de":"Hyundai"}',
            ],
            [
                'manufacturer_name' => '{"en":"Ford","de":"Ford"}',
            ],
            [
                'manufacturer_name' => '{"en":"General Motors","de":"General Motors"}',
            ],
            [
                'manufacturer_name' => '{"en":"Volkswagen","de":"Volkswagen"}',
            ],
            [
                'manufacturer_name' => '{"en":"Delmar","de":"Delmar"}',
            ],
            [
                'manufacturer_name' => '{"en":"Toyota","de":"Toyota"}',
            ],
            [
                'manufacturer_name' => '{"en":"Nissan ","de":"Nissan"}',
            ],
            [
                'manufacturer_name' => '{"en":"Audi ","de":"Audi"}',
            ],
            [
                'manufacturer_name' => '{"en":"Aston Martin","de":"Aston Martin"}',
            ],
            [
                'manufacturer_name' => '{"en":"Porsche","de":"Porsche"}',
            ],
            [
                'manufacturer_name' => '{"en":"OPEL","de":"OPEL"}',
            ],
            [
                'manufacturer_name' => '{"en":"Bentley Motors","de":"Bentley Motors"}',
            ],
            [
                'manufacturer_name' => '{"en":"Range Rover","de":"Range Rover"}',
            ],
            [
                'manufacturer_name' => '{"en":"Maybach","de":"Maybach"}',
            ],
        ];

        array_map(fn ($variable) => $manufacturer->create($variable), $variables);
    }
}
