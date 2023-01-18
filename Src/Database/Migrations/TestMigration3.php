<?php

namespace MvcCore\Rental\Database\Migrations;

use Carbon\Factory;
use Illuminate\Database\Capsule\Manager as Capsule;

class TestMigration3 {

    public function up()
    {
        Capsule::schema()->create('tests', function ($table) {
            $table->id();
            $table->string('test_cli');
            $table->timestamps();
        });

    }

    public function down()
    {
        Capsule::schema()->dropIfExists('test_for_cli');
    }
}