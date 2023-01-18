<?php

namespace MvcCore\Rental\Requests;

use MvcCore\Rental\Validations\ValidateInputs;

class CategoryStoreRequest
{
    public static function rules()
    {
        return [
            'name' => 'required',
        ];
    }

    public static function validate(array $data)
    {
        $validator     = new ValidateInputs($data);
        $validatedData = $validator->passingInputsThrowValidationRules(self::rules());
        return $validatedData;
    }
}
