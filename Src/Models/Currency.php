<?php

namespace MvcCore\Rental\Models;
use Illuminate\Database\Eloquent\Model;
use MvcCore\Rental\Models\ObjectModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory;
    protected $table    = 'currencies';

    protected $primaryKey  = 'id';

    protected $fillable = [
        'name',
        'currency_code'
    ];

    public function objects()
    {
       return $this->hasMany(ObjectModel::class , 'currency_id');
    }

}
