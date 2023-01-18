<?php

namespace MvcCore\Rental\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

    class CountryTable {

        public function up()
        {
            Capsule::schema()->create('countries', function ($table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        public function down()
        {
            Capsule::schema()->dropIfExists('countries');
        }
    }