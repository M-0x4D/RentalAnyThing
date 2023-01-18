<?php

namespace MvcCore\Rental\Database\Migrations;
use Illuminate\Database\Capsule\Manager as Capsule;


class CurrenciesTable {

	public function up()
	{
		Capsule::schema()->create('currencies', function ($table) {
            $table->id();
			$table->string('name');
			$table->string('currency_code');
            $table->timestamps();
        });
	}

	public function down()
	{
        Capsule::schema()->dropIfExists('currencies');
	}
}