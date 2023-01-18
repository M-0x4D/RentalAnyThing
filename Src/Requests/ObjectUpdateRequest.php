<?php

namespace MvcCore\Rental\Requests;

use MvcCore\Rental\Validations\ValidateInputs;

class ObjectUpdateRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'category_id' => 'required' ,
            'location_id' => 'required'
        ];
    }

    public function validate(array $data)
    {
        $validator     = new ValidateInputs($data);
        $validatedData = $validator->passingInputsThrowValidationRules($this->rules());
        return $validatedData;
    }
}
