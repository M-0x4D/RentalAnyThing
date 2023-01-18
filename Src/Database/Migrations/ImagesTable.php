<?php

namespace MvcCore\Rental\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class ImagesTable  
{
    public function up()
    {
        Capsule::schema()->create('images', function ($table) {
            $table->id();
            $table->string('imagePath');
            $table->integer('object_id');
            $table->boolean("is_main")->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('images');
    }
}
