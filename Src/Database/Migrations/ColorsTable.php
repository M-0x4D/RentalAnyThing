<?php

namespace MvcCore\Rental\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class ColorsTable
{
    public function up()
    {
		Capsule::schema()->create('colors', function ($table) {
        $table->id();
        $table->string('color_name');
        $table->timestamps();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('colors');
    }
}
