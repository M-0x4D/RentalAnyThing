<?php

namespace MvcCore\Rental\Models;

use Illuminate\Database\Eloquent\Model;

    class CartTable extends Model 
    {

        protected $table = 'twarenkorb';
        public $timestamps = true;
        protected $fillable = ['kWarenkorb' , 'kKunde', 'kLieferadresse' , 'kZahlungsInfo'];


    }