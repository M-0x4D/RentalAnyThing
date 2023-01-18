<?php

namespace MvcCore\Rental\Middlewares;

use MvcCore\Rental\Support\Facades\Middleware\BaseMiddleware;
use MvcCore\Rental\Support\Facades\Localization\Lang;
use MvcCore\Rental\Support\Http\Header;

class ApiLocalization extends BaseMiddleware
{
    public function handle()
    {
        if (Header::has('Content-Lang')) {
            Lang::set(Header::get('Content-Lang') ?? null);
        }
    }
}
