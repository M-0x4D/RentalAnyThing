<?php

namespace MvcCore\Rental\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MvcCore\Rental\Models\ObjectModel;

class Description extends Model
{
    use HasFactory;
    protected $table    = 'descriptions';

    protected $primaryKey  = 'id';

    protected $fillable = [
        'short_description',
        'long_description' ,
        'object_id'
    ];


    public function object()
    {

        return $this->belongsTo(ObjectModel::class , 'object_id');
    }
}
