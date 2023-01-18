<?php

namespace MvcCore\Rental\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApiCredentials extends Model
{
    use HasFactory;
    protected $table    = 'api_credentials';

    protected $primaryKey  = 'id';

    protected $fillable = [
        'business_account',
        'client_id',
        'secret_key'
    ];
}
