<?php

namespace MvcCore\Rental\Database\Migrations;

use MvcCore\Rental\Database\Initialization\Schema;
use MvcCore\Rental\Database\Initialization\Table;

class ManufacturersTable
{
    public function up()
    {
        $table =  new Table('manufacturers');
        $table->id();
        $table->string('manufacturer_name');
        $table->timestamps();
        $table->primaryKey('id');
        Schema::create($table);
    }

    public function down()
    {
        Schema::dropIfExistsdrop('manufacturers');
    }
}
