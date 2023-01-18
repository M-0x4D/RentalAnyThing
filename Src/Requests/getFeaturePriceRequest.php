<?php

namespace MvcCore\Rental\Requests;

use MvcCore\Rental\Validations\ValidateInputs;

class getFeaturePriceRequest
{
    public function rules()
    {
        return [
            'featureId' => 'required',
            'featureQuantity' => 'required',
        ];
    }

    public function validate(array $data)
    {
        $validator     = new ValidateInputs($data);
        $validatedData = $validator->passingInputsThrowValidationRules($this->rules());
        return $validatedData;
    }
}
