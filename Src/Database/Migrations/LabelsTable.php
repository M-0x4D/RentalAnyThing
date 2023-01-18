<?php
namespace MvcCore\Rental\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class LabelsTable {

	public function up()
	{
		Capsule::schema()->create('labels', function ($table) {
        $table->id();
        $table->string('name');
        $table->integer('object_id');
        $table->enum('type' , ['integer' , 'string' , 'text']);
        $table->longText('value');
        $table->timestamps();
		});
	}

	public function down()
	{
		Capsule::schema()->dropIfExists('labels');
	}
}