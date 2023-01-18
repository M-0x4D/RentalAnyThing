<?php

namespace MvcCore\Rental\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


    class Country extends Model 
    {

        protected $table = 'countries';
        public $timestamps = true;
        protected $fillable = ['name'];


        function governrates()
        {
        return $this->hasMany(Governrate::class , 'governrate_id');
        }

        static function isShippingAvailable()
        {

        }

        function isPermitRegistration()
        {
            
        }
    }