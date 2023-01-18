<?php

namespace MvcCore\Rental\Database\Seeders;

use MvcCore\Rental\Models\Car;
use MvcCore\Rental\Models\Feature;

class FeaturesSeeder
{

    public function createFeatures()
    {
        $feature     = new Feature;
        $variables = [
            [
                'feature_name' => '{"en":"Additional Driver","de":"Zusätzlicher Treiber"}',
                'feature_description' => '{"en":"Lorem ipsum dolor sit amet, consectetuer adipiscing elit.","de":"Deutsches Ipsum Dolor id latine genau complectitur pri, mea meliore denique Weltschmerz id."}',
            ],
            [
                'feature_name' => '{"en":"GPS","de":"GPS"}',
                'feature_description' => '{"en":"Lorem ipsum dolor sit amet, consectetuer adipiscing elit.","de":"Deutsches Ipsum Dolor id latine genau complectitur pri, mea meliore denique Weltschmerz id."}',
            ],
            [
                'feature_name' => '{"en":"Super Personal Accident Insurance","de":"Super-Privat-Unfallversicherung"}',
                'feature_description' => '{"en":"Lorem ipsum dolor sit amet, consectetuer adipiscing elit.","de":"Deutsches Ipsum Dolor id latine genau complectitur pri, mea meliore denique Weltschmerz id."}',
            ],
            [
                'feature_name' => '{"en":"Windscreen, Glass And Tires Protection","de":"Schutz für Windschutzscheibe, Glas und Reifen"}',
                'feature_description' => '{"en":"Lorem ipsum dolor sit amet, consectetuer adipiscing elit.","de":"Deutsches Ipsum Dolor id latine genau complectitur pri, mea meliore denique Weltschmerz id."}',
            ],
            [
                'feature_name' => '{"en":"Backup camera","de":"Rückfahrkamera"}',
                'feature_description' => '{"en":"Lorem ipsum dolor sit amet, consectetuer adipiscing elit.","de":"Deutsches Ipsum Dolor id latine genau complectitur pri, mea meliore denique Weltschmerz id."}',
            ],
            [
                'feature_name' => '{"en":"Blind spot monitoring","de":"Überwachung des toten Winkels"}',
                'feature_description' => '{"en":"Lorem ipsum dolor sit amet, consectetuer adipiscing elit.","de":"Deutsches Ipsum Dolor id latine genau complectitur pri, mea meliore denique Weltschmerz id."}',
            ], 
        ];

        array_map(fn ($variable) => $feature->create($variable), $variables);

/*         array_map(function ($variable) use ($feature) {
            $feature->create($variable);
            $lastId = $feature->select('id')->orderBy('id', 'DESC')->first();
            $id = $lastId[0]->id;
            $a = rand(1, 8);
            $b = rand(1, 8);
            $c = rand(1, 8);
            $d = rand(1, 8);

            $values = [
                'per_person' => true,
                'price' => 10
            ];

            if ($a != $b && $b != $c && $d != $c) {
                $sent_id = [$a, $b, $c, $d];
                $feature->attachWith('feature_car', $id, 'feature_id', $sent_id, 'car_id', $values);
            }
        }, $variables); */
    }
}
