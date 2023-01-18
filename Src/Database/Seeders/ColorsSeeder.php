<?php

namespace MvcCore\Rental\Database\Seeders;

use MvcCore\Rental\Models\Color;

class ColorsSeeder
{

    public function createColors()
    {
        $color     = new Color;
        $variables = [
            [
                'color_name' => '{"en":"Yellow","de":"Gelb"}',
            ],
            [
                'color_name' => '{"en":"Red","de":"Rot"}',
            ],
            [
                'color_name' => '{"en":"Blue","de":"Blau"}',
            ],
            [
                'color_name' => '{"en":"White","de":"Weiß"}',
            ],
            [
                'color_name' => '{"en":"Black","de":"Schwarz"}',
            ],
            [
                'color_name' => '{"en":"Green","de":"Grün"}',
            ],
            [
                'color_name' => '{"en":"Brown","de":"Braun"}',
            ],
            [
                'color_name' => '{"en":"Gray","de":"Grau"}',
            ],
            [
                'color_name' => '{"en":"Orange ","de":"Orange"}',
            ],
            [
                'color_name' => '{"en":"Purple ","de":"Lila"}',
            ],
            [
                'color_name' => '{"en":"Silver","de":"Silber"}',
            ],
        ];

        array_map(fn ($variable) => $color->create($variable), $variables);
    }
}
