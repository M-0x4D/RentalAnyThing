<?php

namespace MvcCore\Rental\Database\Seeders;

use MvcCore\Rental\Models\Location;

class LocationsSeeder
{

    public function createLocations()
    {
        $location     = new Location;
        $variables = [
            [
                'location_name' => '{"en":"Ahaus Truck, Ahaus","de":"Ahaus Truck, Ahaus"}',
            ],
            [
                'location_name' => '{"en":"Stuttgart Airport, Stuttgart","de":"Stuttgart Airport, Stuttgart"}',
            ],
            [
                'location_name' => '{"en":"WERFTSTRASSE 240 248, Kiel","de":"WERFTSTRASSE 240 248, Kiel"}',
            ],
            [
                'location_name' => '{"en":"Pforzheim Truck, Pforzheim","de":"Pforzheim Truck, Pforzheim"}',
            ],
            [
                'location_name' => '{"en":"Hamburg Airport, Hamburg","de":"Hamburg Airport, Hamburg"}',
            ],
            [
                'location_name' => '{"en":"Dresden Airport, Dresden","de":"Dresden Airport, Dresden"}',
            ],
            [
                'location_name' => '{"en":"Kempten Truck, Kempten","de":"Kempten Truck, Kempten"}',
            ],
            [
                'location_name' => '{"en":"Bautzen Truck, Bautzen","de":"Bautzen Truck, Bautzen"}',
            ],
            [
                'location_name' => '{"en":"Berlin Tegel Airport, Berlin","de":"Berlin Tegel Airport, Berlin"}',
            ],
            [
                'location_name' => '{"en":"Denninger Str 116, München","de":"Denninger Str 116, München"}',
            ],
            [
                'location_name' => '{"en":"Albrechtstr 103, Berlin","de":"Albrechtstr 103, Berlin"}',
            ],
            [
                'location_name' => '{"en":"Evingerstr 35, Dortmund","de":"Evingerstr 35, Dortmund"}',
            ],
            [
                'location_name' => '{"en":"Mombacher strasse 80, Mainz","de":"Mombacher strasse 80, Mainz"}',
            ],
            [
                'location_name' => '{"en":"Alexanderstrasse 46, Stuttgart","de":"Alexanderstrasse 46, Stuttgart"}',
            ],
        ];

        array_map(fn ($variable) => $location->create($variable), $variables);
    }
}
