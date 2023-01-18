<?php

namespace MvcCore\Rental\Controllers\Repository;

use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Models\TokenParameter;
use Carbon\Carbon;
use MvcCore\Rental\Models\ApiCredentials;
use MvcCore\Rental\Support\Http\HttpRequest;
use MvcCore\Rental\Helpers\GetPaypalMode;
use MvcCore\Rental\Support\Debug\Debugger;

class InitiatePayment
{

        public static function initiate()
        {
                $tokenParameter = new TokenParameter;

                $searchForToken    = $tokenParameter->select('token_name', 'token_type', 'token_expiration', 'created_at')
                        ->orderBy('created_at', 'desc')->first();
                if (isset($searchForToken)) {

                        $expiry = $searchForToken->token_expiration;
                        $expiry = $expiry / 3600;
                        $creationTime = $searchForToken->created_at;

                        $creationTime = Carbon::parse($creationTime);
                        $currentTime = Carbon::now();
                        $addedTime = $creationTime->addHours($expiry);

                        $difference = $currentTime->diffInSeconds($addedTime, false);


                        if ($difference < 0) {

                                $credential     = new ApiCredentials;
                                $credentials    = $credential->select('client_id', 'secret_key')->first();



                                $auth = base64_encode($credentials->client_id . ':' . $credentials->secret_key);

                                $baseUrl = GetPaypalMode::getPaypalUrl();
                                $curl = new HttpRequest($baseUrl);


                                $checkCredentials = $curl->post(
                                        '/v1/oauth2/token',
                                        'Basic',
                                        'grant_type=client_credentials',
                                        [
                                                "Content-Type: application/x-www-form-urlencoded",
                                                "Authorization: Basic $auth"
                                        ]
                                );

                                $tokenParameter->create([
                                        'token_name' => $checkCredentials['access_token'],
                                        'token_type' => $checkCredentials['token_type'],
                                        'token_expiration' => $checkCredentials['expires_in'],
                                ]);


                                $searchForToken->token_name = $checkCredentials['access_token'];
                                $searchForToken->token_type = $checkCredentials['token_type'];
                        }


                        $tokenName = $searchForToken->token_name;
                        $tokenType = $searchForToken->token_type;

                        return [
                                'tokenName' => $tokenName,
                                'tokenType' => $tokenType,
                        ];
                }
                else{
                        return Response::json('please enter api credentials first from admin panel' , 404);
                }
        }
}
