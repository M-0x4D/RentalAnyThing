<?php

namespace MvcCore\Rental\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;
    protected $table    = 'locations';

    protected $primaryKey  = 'id';

    protected $fillable = [
        'location_name',
    ];
}
