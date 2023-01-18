<?php

namespace MvcCore\Rental\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class CityTable
{

    public function up()
    {
        Capsule::schema()->create('cities', function ($table) {
            $table->id();
            $table->string('name');
            $table->integer('country_id');
            $table->integer('governrate_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('cities');
    }
}
