<?php

namespace MvcCore\Rental\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rental extends Model
{
    use HasFactory;
    protected $table    = 'rentals';

    protected $primaryKey  = 'id';

    protected $fillable = [
        'customer_id',
        'object_id',
        'pickup_date',
        'dropoff_date',
        'total_amount',
        'currency_id',
        'order_id',
        'rental_status',
        'updated_at',
        'category_id',
        'quantity',
        'country_id',
        'city_id',
        'governrate_id'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'object_id');
    }


    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function labels()
    {
        return $this->hasMany(Label::class, 'object_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function descriptions()
    {
        return $this->hasMany(Description::class, 'object_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    function country()
    {
        return $this->belongsTo(Country::class);
    }
    function governrate()
    {
        return $this->belongsTo(Governrate::class);
    }
    function city()
    {
        return $this->belongsTo(City::class);
    }



}
