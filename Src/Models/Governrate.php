<?php

namespace MvcCore\Rental\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

    class Governrate extends Model 
    {
    use HasFactory;

        protected $table = 'governrates';
        public $timestamps = true;
        protected $fillable = ['name' , 'country_id'];


       function country()
       {
        return $this->belongsTo(Country::class);
       }

       function cities()
       {
        return $this->hasMany(City::class);
       }
    }