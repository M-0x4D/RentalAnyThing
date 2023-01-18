<?php

namespace MvcCore\Rental\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderLink extends Model
{
    use HasFactory;
    protected $table    = 'order_links';

    protected $primaryKey  = 'id';

    protected $fillable = [
        'order_id',
        'order_status',
        'order_link',
        'link_name',
        'order_method',
        'customer_id',
        'object_id'
    ];
}
