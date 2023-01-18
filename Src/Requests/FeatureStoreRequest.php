<?php

namespace MvcCore\Rental\Requests;

use MvcCore\Rental\Validations\ValidateInputs;

class FeatureStoreRequest
{
    public static function rules()
    {
        return [
            'feature_name' => 'required',
            'feature_description' => 'required',
        ];
    }

    public static function validate(array $data)
    {
        $validator     = new ValidateInputs($data);
        $validatedData = $validator->passingInputsThrowValidationRules(self::rules());
        return $validatedData;
    }
}
