<?php

namespace MvcCore\Rental\Requests;

use MvcCore\Rental\Validations\ValidateInputs;

class DescriptionStoreRequest
{
    public static function rules()
    {
        return [
            'short_description' => 'required',
            'long_description' => 'required',
            'object_id' => 'required',
        ];
    }

    public static function validate(array $data)
    {
        $validator     = new ValidateInputs($data);
        $validatedData = $validator->passingInputsThrowValidationRules(self::rules());
        return $validatedData;
    }
}
