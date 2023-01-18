<?php

namespace MvcCore\Rental\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class UnBookedObjectsTable
{
    public function up()
    {
		Capsule::schema()->create('unbooked_objects', function ($table) {
        $table->id();
        $table->foreignId('object_id')->references('objects');
        $table->foreignId('location_id')->references('locations');                          
        $table->foreignId('category_id')->references('categories');                     
        $table->timestamps();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('unbooked_objects');
    }
}