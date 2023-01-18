<?php

namespace MvcCore\Rental\Requests;

use MvcCore\Rental\Validations\ValidateInputs;

class ApiCredentialsStoreRequest
{
    public function rules()
    {
        return [
            'business_account' => 'required',
            'client_id' => 'required',
            'secret_key' => 'required',
        ];
    }

    public function validate(Array $data)
    {
        $validator     = new ValidateInputs($data);
        $validatedData = $validator->passingInputsThrowValidationRules($this->rules());
        return $validatedData;
    }
}
