<?php

namespace MvcCore\Rental\Models;
use Illuminate\Database\Eloquent\Model;
use MvcCore\Rental\Models\ObjectModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Color extends Model
{
    use HasFactory;
    protected $table    = 'colors';

    protected $primaryKey  = 'id';

    protected $fillable = [
        'color_name',
    ];


    public function objects()
    {
       return $this->hasMany(ObjectModel::class , 'object_id');
    }
}
