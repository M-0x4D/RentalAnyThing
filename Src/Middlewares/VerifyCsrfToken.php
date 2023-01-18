<?php

namespace MvcCore\Rental\Middlewares;

use MvcCore\Rental\Support\Facades\Authentication\CsrfAuthentication;
use MvcCore\Rental\Support\Facades\Middleware\BaseMiddleware;
use MvcCore\Rental\Support\Facades\Localization\Translate;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Support\Http\Header;
use MvcCore\Rental\Helpers\Response;

class VerifyCsrfToken extends BaseMiddleware
{
    public function handle()
    {
        if ((Request::type() === 'POST') || (Request::type() === 'PUT') || (Request::type() === 'DELETE')) {

            if ((Header::has('Jtl-Token') === false) || (empty(Header::get('Jtl-Token')))) {
                return Response::json([
                    'message' => Translate::translate('messages', 'unauthenticated'),
                ], 403);
            }
            if (!CsrfAuthentication::validate_token(Header::get('Jtl-Token'))) {
                return Response::json([
                    'message' => Translate::translate('messages', 'unauthenticated'),
                ], 403);
            }
        }
    }
}
