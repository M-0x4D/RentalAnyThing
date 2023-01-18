<?php

namespace MvcCore\Rental\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class CategoriesTable {

	public function up()
	{
		Capsule::schema()->create('categories', function ($table) {
            $table->id();
			$table->string('name');
            $table->timestamps();
        });
	}

	public function down()
	{
        Capsule::schema()->dropIfExists('categories');
	}
}