<?php

namespace MvcCore\Rental\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class TokenParameter extends Model
{
    use HasFactory;
    protected $table    = 'token_parameters';

    protected $primaryKey  = 'id';

    protected $fillable = [
        'token_name',
        'token_type',
        'token_expiration',
    ];
}
