<?php

namespace MvcCore\Rental\Models;

use Illuminate\Database\Eloquent\Model;
use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Models\Category;
use MvcCore\Rental\Models\Label;
use MvcCore\Rental\Models\Color;
use MvcCore\Rental\Models\Location;
use MvcCore\Rental\Models\Description;
use MvcCore\Rental\Models\Currency;
use MvcCore\Rental\Models\Country;
use MvcCore\Rental\Models\Governrate;
use MvcCore\Rental\Models\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ObjectModel extends Model
{

    use HasFactory;
    protected $table = 'objects';
    public $timestamps = true;
    protected $fillable = ['category_id', 'name', 'color_id', 'currency_id', 'price', 'price_includes', 'price_excludes', 'quantity',
'country_id' , 'governrate_id' , 'city_id' , 'duration'];

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
