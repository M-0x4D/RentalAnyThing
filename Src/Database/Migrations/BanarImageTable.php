<?php

namespace MvcCore\Rental\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class BanarImageTable  
{
    public function up()
    {
        Capsule::schema()->create('banar_image', function ($table) {
            $table->id();
            $table->string('imagePath');
            $table->timestamps();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('banar_image');
    }
}
