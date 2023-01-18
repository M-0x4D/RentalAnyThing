<?php

namespace MvcCore\Rental\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

    class CreateTableTestMigration {

        public function up()
        {
            Capsule::schema()->create('test_for_cli', function ($table) {
                $table->id();
                $table->string('cli_test');
                $table->timestamps();
            });
        }

        public function down()
        {
            Capsule::schema()->dropIfExists('test_for_cli');
        }
    }