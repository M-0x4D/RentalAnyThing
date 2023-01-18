<?php

        namespace MvcCore\Rental\Requests;
        
        use MvcCore\Rental\Validations\ValidateInputs;
        
        class TranslateRequest
        {
            public function rules()
            {
                return [
                    
                ];
            }
        
            public function validate(Array $data = [])
            {
                $validator     = new ValidateInputs($data);
                $validatedData = $validator->passingInputsThrowValidationRules($this->rules());
                return $validatedData;
            }
        }
        