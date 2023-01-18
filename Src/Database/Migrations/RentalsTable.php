<?php

namespace MvcCore\Rental\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class RentalsTable
{
    public function up()
    {
		Capsule::schema()->create('rentals', function ($table) {
        $table->id();
        $table->string('customer_id');
        $table->string('object_id');
        $table->integer('country_id');
        $table->integer('category_id');
        $table->integer('governrate_id');
        $table->integer('city_id');                         
        $table->timestamp('pickup_date');
        $table->timestamp('dropoff_date');
        $table->float('total_amount', 8, 2);
        $table->integer('quantity');
        $table->integer('currency_id');
        $table->integer('order_id');
        $table->string('rental_status');
        $table->timestamps();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('rentals');
    }
}
