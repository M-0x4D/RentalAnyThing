<?php

namespace MvcCore\Rental\Models;

use Illuminate\Database\Eloquent\Model;

    class CacheModel extends Model 
    {

        protected $table = 'cache_models';
        public $timestamps = true;
        protected $fillable = ['customer_id','object_id','pickup_date','dropoff_date','total_amount','currency_id','rental_status','order_id','quantity'];


    }