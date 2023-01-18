<?php

namespace MvcCore\Rental\Models;

use Illuminate\Database\Eloquent\Model;

    class City extends Model 
    {

        protected $table = 'cities';
        public $timestamps = true;
        protected $fillable = ['name' , 'country_id' , 'governrate_id'];

        function governrate()
        {
        return $this->belongsTo(Governrate::class);
        }


    }