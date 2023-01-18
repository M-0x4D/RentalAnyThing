<?php

namespace MvcCore\Rental\Controllers\Admin;

use MvcCore\Rental\Controllers\Admin\Test as AdminTest;
use MvcCore\Rental\Models\ApiCredentials;
use MvcCore\Rental\Models\TokenParameter;
use MvcCore\Rental\Requests\ApiCredentialsStoreRequest;
use MvcCore\Rental\Requests\ApiCredentialsUpdateRequest;
use MvcCore\Rental\Validations\Alerts;
use Symfony\Component\Dotenv\Dotenv as DotenvDotenv;
use Symfony\Component\Dotenv\Dotenv;
use MvcCore\Rental\Controllers\Admin\Test;
use MvcCore\Rental\Support\Http\HttpRequest;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Support\Http\Server;
use JTL\Shop;
use MvcCore\Rental\Support\Facades\Configs\Configs;
use MvcCore\Rental\Helpers\GetPaypalMode;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Helpers\Response;




class ApiCredentialsController
{
    public function index()
    {
        
        $credential     = new ApiCredentials;
        
        $credentials    = $credential->all();

        $successUrl = Server::base_url('/booking?return=success');
        $cancelUrl = Server::base_url('/booking?return=cancel');

        $smarty = Shop::Smarty();
        $smarty->assign('successUrl', $successUrl);
        $smarty->assign('cancelUrl', $cancelUrl);

        return $smarty->assign('credentials', $credentials);
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $validator = new ApiCredentialsStoreRequest;
        $validatedData = $validator->validate($data);
        $configs = new Configs();
        $credential     = new ApiCredentials;

        $searchForExistedCredentials = $credential->all();

        if (count($searchForExistedCredentials) >= 1) {
            return Response::json('You can only add one credential' , 404);
        }


        $username = $validatedData['client_id'];
        $password = $validatedData['secret_key'];
        $auth = base64_encode($username . ':' . $password);
        $payPalMode = $validatedData['mode'];
        $configs->setEnv('PAYPAL_MODE', $payPalMode);
        $mode = !empty($configs->getEnvValue('PAYPAL_MODE')) ? $configs->getEnvValue('PAYPAL_MODE') : NULL;
        $paypalBaseUrl = $configs->get_configs()["$mode"];
        $curl = new HttpRequest($paypalBaseUrl);
        $checkCredentials = $curl->post(
            '/v1/oauth2/token',
            'Basic',
            'grant_type=client_credentials',
            [
                "Content-Type: application/x-www-form-urlencoded",
                "Authorization: Basic $auth",
            ]
        );

        if (isset($checkCredentials['error'])) {
            return Response::json(['message' => $checkCredentials["error_description"]], 404);
        }

        /**
         * 
         *  
         */
        $paypalMode = new GetPaypalMode();
        $url = $paypalMode->getPaypalUrl();

        $curl = new HttpRequest($url);
        

        /***
         * 
         */
        // $checkCredentials = $curl->post(
        //     "/v1/oauth2/token",
        //     "Basic",
        //     'grant_type=client_credentials',
        //     [
        //         "Content-Type: application/x-www-form-urlencoded",
        //         "Authorization: Basic $auth",
        //     ]
        // );

        // if (isset($checkCredentials['error'])) {
        //     return Response::json('API credentials are invalid' , 404);

        // }

        $accessToken = $checkCredentials['access_token'];
        $tokenType = $checkCredentials['token_type'];
        $expiration = $checkCredentials['expires_in'];

        $tokenParameter = new TokenParameter;
        $tokenParameter->create([
            'token_name' => $accessToken,
            'token_type' => $tokenType,
            'token_expiration' => $expiration,
        ]);

        $credential->create(
            [
                'business_account' => $validatedData['business_account'],
                'client_id' => $validatedData['client_id'],
                'secret_key' => $validatedData['secret_key'],
            ]
        );

        return Response::json('Record is created successfully' , 201);
        
    }





    public function destroy(Request $request)
    {
        ApiCredentials::where('id' , $request->all()['id'])->delete();
        return Response::json('Record is deleted successfully' , 204);
        
    }


    public function update(Request $request )
    {

        $data = $request->all();

        $validator = new ApiCredentialsUpdateRequest;
        $validatedData = $validator->validate($data);
        $configs = new Configs();
        $username = $validatedData['client_id'];
        $password = $validatedData['secret_key'];
        $payPalMode = $validatedData['paypal-mode'];
        $auth = base64_encode($username . ':' . $password);
        $configs->setEnv('PAYPAL_MODE', $payPalMode);
        $mode = !empty($configs->getEnvValue('PAYPAL_MODE')) ? $configs->getEnvValue('PAYPAL_MODE') : NULL;
        $paypalBaseUrl = $configs->get_configs()["$mode"];
        $curl = new HttpRequest($paypalBaseUrl);
        $checkCredentials = $curl->post(
            '/v1/oauth2/token',
            'Basic',
            'grant_type=client_credentials',
            [
                "Content-Type: application/x-www-form-urlencoded",
                "Authorization: Basic $auth",
            ]
        );

        if (isset($checkCredentials['error'])) {
            return Response::json(['message' => $checkCredentials["error_description"]], 422);
        }
        $accessToken = $checkCredentials['access_token'];
        $tokenType = $checkCredentials['token_type'];
        $expiration = $checkCredentials['expires_in'];
        $searchForToken    = TokenParameter::select('id')
            ->orderBy('created_at', 'desc')->first();
        TokenParameter::where('id', $searchForToken->id)->update([
            'token_name' => $accessToken,
            'token_type' => $tokenType,
            'token_expiration' => $expiration,
        ]);
///////////////////////////////////////////////////////////////////////////


        $credential     = new ApiCredentials;
        $credential->where('id' , $validatedData['credentialId'])->update(
            [
                'business_account' => $validatedData['business_account'],
                'client_id' => $validatedData['client_id'],
                'secret_key' => $validatedData['secret_key'],
            ] 
        );

        return Response::json('Record is updated successfully' , 206);

    }
}
