<?php

namespace MvcCore\Rental\Middlewares;

use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Support\Facades\Localization\Currency;
use MvcCore\Rental\Support\Facades\Middleware\BaseMiddleware;
use MvcCore\Rental\Support\Facades\Localization\Lang;
use MvcCore\Rental\Support\Http\Header;

class CurrencyFilter extends BaseMiddleware
{
    public function handle()
    {
        if (Header::has('Content-Currency')) {
            Currency::set(Header::get('Content-Currency'));
        }
    }
}
