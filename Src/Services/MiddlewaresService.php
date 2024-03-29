<?php

namespace MvcCore\Rental\Services;

use MvcCore\Rental\Support\Facades\Middleware\RegisterMiddlewares;

class MiddlewaresService
{
    private const MIDDLEWARES_NAMESPACE = 'MvcCore\Rental\Middlewares\\';

    public static function load(): void
    {
        $registerMiddlewares = new RegisterMiddlewares();

        $registerMiddlewares->register([
            'Ajax' => self::MIDDLEWARES_NAMESPACE . 'VerifyAjaxRequest',
            'Localization' => self::MIDDLEWARES_NAMESPACE . 'ApiLocalization',
            'CsrfAuthentication' => self::MIDDLEWARES_NAMESPACE . 'VerifyCsrfToken',
            'CurrencyFilter' => self::MIDDLEWARES_NAMESPACE . 'CurrencyFilter',
            'CheckApiCredentials' => self::MIDDLEWARES_NAMESPACE . 'CheckApiCredentials'
        ]);
    }
} 
