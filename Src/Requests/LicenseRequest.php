<?php

namespace MvcCore\Rental\Requests;

use MvcCore\Rental\Validations\ValidateInputs;

class LicenseRequest
{
    public function rules()
    {
        return [
            'email' => 'required',
            'licensekey' => 'required'
        ];
    }

    public function validate(Array $data)
    {
        $validator     = new ValidateInputs($data);
        $validatedData = $validator->passingAjaxRequestThrowValidationRules($this->rules());
        return $validatedData;
    }
}
