<?php

namespace MvcCore\Rental\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class ObjectsTable
{
    public function up()
    {
		Capsule::schema()->create('objects', function ($table) {
        $table->id();
        $table->string('name');
        $table->integer('category_id');
        $table->integer('color_id');
        $table->integer('country_id');
        $table->integer('governrate_id');
        $table->integer('city_id');
        $table->float('price', 8, 2);
        $table->integer('quantity');
        $table->string('price_includes');
        $table->string('price_excludes');
        $table->enum('duration', [1,7,30,60]);
        $table->boolean("booked")->default(false);
        $table->integer('currency_id');
        $table->timestamps();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('objects');
    }
}
