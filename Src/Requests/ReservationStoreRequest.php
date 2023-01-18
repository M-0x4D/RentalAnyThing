<?php

namespace MvcCore\Rental\Requests;

use MvcCore\Rental\Validations\ValidateInputs;

class ReservationStoreRequest
{
    public function rules()
    {
        return [
            'customer_id' => 'required',
            'object_id' => 'required',
            'location_id' => 'required',
            'pickup_date' => 'required',
            'dropoff_date' => 'required',
            'total_amount' => 'required',
            'currency' => 'required',
            'order_id' => 'required',
        ];
    }

    public function validate(Array $data)
    {
        $validator     = new ValidateInputs($data);
        $validatedData = $validator->passingInputsThrowValidationRules($this->rules());
        return $validatedData;
    }
}
