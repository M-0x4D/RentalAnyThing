<?php

namespace MvcCore\Rental\Requests;

use MvcCore\Rental\Validations\ValidateInputs;

class ImageUpdateRequest
{
    public static function rules()
    {
        return [
            'car_id' => 'required',
        ];
    }

    public static function validate(array $data)
    {
        $validator     = new ValidateInputs($data);
        $validatedData = $validator->passingInputsThrowValidationRules(self::rules());
        return $validatedData;
    }
}
