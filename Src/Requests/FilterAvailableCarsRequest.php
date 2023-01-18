<?php

namespace MvcCore\Rental\Requests;

use MvcCore\Rental\Validations\ValidateInputs;

class FilterAvailableCarsRequest
{
    public function rules()
    {
        return [
            'pickup_location_id' => 'required',
            'pickup_date' => 'required',
            'dropoff_location_id' => 'required',
            'dropoff_date' => 'required',
        ];
    }

    public function validate(array $data)
    {
        $validator     = new ValidateInputs($data);
        $validatedData = $validator->passingInputsThrowValidationRules($this->rules());
        return $validatedData;
    }
}
