<?php

namespace MvcCore\Rental\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MvcCore\Rental\Models\ObjectModel;

class Image extends Model
{
    use HasFactory;
    protected $table    = 'images';

    protected $primaryKey  = 'id';

    protected $fillable = [
        'imagePath',
        'object_id',
        'is_main'
    ];


    public function object()
    {
        return $this->belongsTo(ObjectModel::class, 'object_id');
    }
}
