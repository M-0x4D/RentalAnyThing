<?php

namespace MvcCore\Rental\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class MainBanarModel extends Model
{

    use HasFactory;
    protected $table = 'banar_image';
    protected $fillable = [
        'imagePath'
    ];

    protected $primaryKey = 'id';
    
}