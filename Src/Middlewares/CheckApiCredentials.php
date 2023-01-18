<?php

namespace MvcCore\Rental\Middlewares;

use MvcCore\Rental\Models\ApiCredentials;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Helpers\Response;
class CheckApiCredentials
{
    public static function handle()
    {
        $request = new Request;
        $data = $request->all();

        if(count($data) > 3){
            $credential     = new ApiCredentials;

            $searchForCredentials    = $credential->select('client_id')->get();

            if (empty($searchForCredentials)) {
                return Response::json([
                    'message' => 'Note: You have to store Api credentials first.',
                ], 422);
            }
        }
        
    }
}
