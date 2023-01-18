<?php

namespace MvcCore\Rental\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table    = 'tbestellung';

    protected $primaryKey  = 'kBestellung';

    public $timestamps = false;
    protected $fillable = [
        'kWarenkorb', //Shopping cart (int)
        'kKunde', // id for client
        'kLieferadresse',  //Shipping address (int)
        'kRechnungsadresse', // Billing address (int)
        'kZahlungsart', //  Payment method type
        'kVersandart', // Shipping method type
        'kSprache', // language
        'kWaehrung', // Currency
        'fGuthaben', // Credit / balance double(12,4)
        'fGesamtsumme', // Total amount
        'cSession',
        'cVersandartName', // Shipping methodName
        'cZahlungsartName', // Payment methodName
        'cBestellNr', // order number
        'cVersandInfo', // Shipping info
        'nLongestMinDelivery', // int
        'nLongestMaxDelivery', // int
        'dVersandDatum', // Shipping date date
        'dBezahltDatum', // Paid date
        'dBewertungErinnerung', // Rating reminder datetime
        'cTracking',
        'cKommentar', // Comment
        'cLogistiker', // varchar
        'cTrackingURL', // varchar
        'cIP', // varchar
        'cAbgeholt', // Retrieved char 1 
        'cStatus', // char 2
        'dErstellt', // dateCreated  datetime
        'fWaehrungsFaktor', // CurrencyFactor float
        'cPUIZahlungsdaten', // PUI payment data medium text
    ];

}
