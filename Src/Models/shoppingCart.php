<?php

namespace MvcCore\Rental\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class shoppingCart extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table    = 'twarenkorbperspos';

    protected $primaryKey  = 'kWarenkorbPersPos';

    protected $fillable = [
        'kWarenkorbPers', //
        'kArtikel', // product_id
        'cArtikelName',  // 
        'fAnzahl', // 
        'dHinzugefuegt', // 
        'cUnique', // 
        'cResponsibility', // 
        'kKonfigitem', // 
        'nPosTyp', // 
    ];

}