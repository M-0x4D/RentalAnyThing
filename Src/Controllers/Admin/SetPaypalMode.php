<?php

namespace MvcCore\Rental\Controllers\Admin;

use MvcCore\Rental\Support\Facades\Configs\Configs;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Models\ApiCredentials;





class SetPaypalMode
{

    public function handle(Request $request)
    {
        $credential     = new ApiCredentials;
        
        $credentials    = $credential->all();
        // $mode = $request->all()['mode'];
        // $configs = new Configs();
        // $configs->setEnv('PAYPAL_MODE' , $mode);
        return Response::json($credentials , 200);
    }
}
