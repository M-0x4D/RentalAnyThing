<?php

namespace MvcCore\Rental\Models;

use Illuminate\Database\Eloquent\Model;

    class Admin extends Model 
    {

        protected $table = 'tadminlogin';
        public $timestamps = false;
        protected $fillable = ['kAdminlogin','cMail'];


    }