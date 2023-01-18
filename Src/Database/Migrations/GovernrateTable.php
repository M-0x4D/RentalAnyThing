<?php

namespace MvcCore\Rental\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class GovernrateTable
{

    public function up()
    {
        Capsule::schema()->create('governrates', function ($table) {
            $table->id();
            $table->string('name');
            $table->integer('country_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('governrates');
    }
}
