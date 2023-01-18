<?php

namespace MvcCore\Rental\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Label extends Model
{
    use HasFactory;
    protected $table = 'labels';
    public $timestamps = true;
    protected $fillable = array('name', 'object_id', 'type', 'value');

    public function object()
    {
        return $this->belongsTo(ObjectModel::class);
    }

}