<?php
namespace MvcCore\Rental\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class DescriptionTable {

	public function up()
	{
		Capsule::schema()->create('descriptions', function ($table) {
        $table->id();
        $table->text('short_description');
        $table->longText('long_description');
        $table->integer('object_id');
        $table->timestamps();
		});
	}

	public function down()
	{
		Capsule::schema()->dropIfExists('descriptions');
	}
}