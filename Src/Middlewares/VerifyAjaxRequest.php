<?php

namespace MvcCore\Rental\Middlewares;

use MvcCore\Rental\Support\Facades\Middleware\BaseMiddleware;
use MvcCore\Rental\Support\Facades\Localization\Translate;
use MvcCore\Rental\Support\Http\Header;
use MvcCore\Rental\Support\Http\Server;
use MvcCore\Rental\Helpers\Response;

class VerifyAjaxRequest extends BaseMiddleware
{
    public function handle()
    {
        if (!!stripos(Server::previous_url(), 'paypal')) {
            return;
        }
        if (!(Header::has('Accept') && Header::get('Accept') === 'application/json')) {
            return Response::json([
                'message' => Translate::translate('messages', 'unauthenticated'),
            ], 403);
        }
    }
}
