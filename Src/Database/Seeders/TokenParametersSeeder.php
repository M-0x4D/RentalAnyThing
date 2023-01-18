<?php

namespace MvcCore\Rental\Database\Seeders;

use MvcCore\Rental\Models\TokenParameter;

class TokenParametersSeeder
{

    public function createTokenParameters()
    {

        $tokenParameterObject = new TokenParameter();
        $tokenParameters = [
            [
                'token_name' => 'TEST',
                'token_type' => 'Basic',
                'token_expiration' => '5000'
            ],
            [
                'token_name' => 'TEST',
                'token_type' => 'Basic',
                'token_expiration' => '5000'
            ],
            [
                'token_name' => 'TEST',
                'token_type' => 'Basic',
                'token_expiration' => '5000'
            ],
           
        ];

        array_map(fn ($tokenParameters) => $tokenParameterObject->create($tokenParameters), $tokenParameters);
    }
}
