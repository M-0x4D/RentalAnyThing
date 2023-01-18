<?php

namespace MvcCore\Rental\Requests;

use MvcCore\Rental\Validations\ValidateInputs;

class LabelStoreRequest
{
    public static function rules()
    {
        return [
            'name' => 'required',
            'object_id' => 'required' , 
            'type' => 'required' , 
            'value' => 'required'

        ];
    }

    public static function validate(array $data)
    {
        $validator     = new ValidateInputs($data);
        $validatedData = $validator->passingInputsThrowValidationRules(self::rules());
        return $validatedData;
    }
}
