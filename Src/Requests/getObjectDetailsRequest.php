<?php

namespace MvcCore\Rental\Requests;

use MvcCore\Rental\Validations\ValidateInputs;

class getObjectDetailsRequest
{
    public function rules()
    {
        return [
            'objectId' => 'required',
        ];
    }

    public function validate(array $data)
    {
        $validator     = new ValidateInputs($data);
        $validatedData = $validator->passingInputsThrowValidationRules($this->rules());
        return $validatedData;
    }
}
