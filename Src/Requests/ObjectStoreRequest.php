<?php

namespace MvcCore\Rental\Requests;

use MvcCore\Rental\Validations\ValidateInputs;

class ObjectStoreRequest
{
    public static function rules()
    {
        return [
            'name' => 'required',
            'category_id' => 'required' ,
            'location_id' => 'required' ,

        ];
    }

    public static function validate(array $data)
    {
        $validator     = new ValidateInputs($data);
        $validatedData = $validator->passingInputsThrowValidationRules(self::rules());
        return $validatedData;
    }
}
