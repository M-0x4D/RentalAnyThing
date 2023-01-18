<?php

namespace MvcCore\Rental\Models;

use Illuminate\Database\Eloquent\Model;

    class Product extends Model 
    {

        protected $table = 'tartikel';
        public $timestamps = false;
        protected $fillable = [
            'kHersteller', //
            'kLieferstatus', // 
            'kSteuerklasse', //
            'kEinheit', // 
            'kVersandklasse', // 
            'kEigenschaftKombi', // 
            'fMwSt',
            'kVaterArtikel', // 
            'kStueckliste', // 
            'kWarengruppe', // 
            'cSeo', // 
            'fLieferantenlagerbestand', // 
            'fLieferzeit', // 
            'fGewicht', // 
            'fArtikelgewicht', // 
            'cLagerBeachten', // 
            'cTeilbar', // 
            'fAbnahmeintervall', // 
            'nSort', // 
            'nIstVater', // 
            'kMassEinheit',
            'kVPEEinheit'
        ];


    }