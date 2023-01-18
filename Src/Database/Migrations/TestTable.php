<?php

namespace MvcCore\Rental\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

    class TestTable {

        public function up()
        {
            Capsule::schema()->create('tests', function ($table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        public function down()
        {
            Capsule::schema()->dropIfExists('tests');
        }
    }