<?php

namespace MvcCore\Rental\Validations;

use MvcCore\Rental\Support\Facades\Localization\Lang;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Support\Http\Request;

class ValidateInputs extends Request
{

    public function passingInputsThrowValidationRules($rules)
    {
        $inputs = $this->all();
        array_walk($inputs, function (&$input, $key) use ($rules) {
            if (array_key_exists($key, $rules) !== false) {
                switch ($rules[$key]) {
                    case 'required':
                        if ($input) {
                            $input = $input;
                        } else {
                            Alerts::show('warning', ValidationMessage::get('required'), $key);
                        }
                        break;
                    case 'nullable':
                        $input = !!$input ? $input : '';
                        break;
                    default:
                        $input = 'not supported validation rule';
                        break;
                }
            }
        });
        if (isset($inputs['jtl_token']) && !empty($inputs['jtl_token'])) {
            unset($inputs['jtl_token']);
        }
        return $inputs;
    }

    public function passingAjaxRequestThrowValidationRules($rules)
    {
        $inputs = $this->all();
        array_walk($inputs, function (&$input, $key) use ($rules) {
            if (array_key_exists($key, $rules) !== false) {
                switch ($rules[$key]) {
                    case 'required':
                        if ($input) {
                            $input = $input;
                        } else {
                            return Response::json([
                                $key => Lang::get('validations', 'required')
                            ], 422);
                            exit();
                        }
                        break;
                    case 'nullable':
                        $input = !!$input ? $input : '';
                        break;
                    default:
                        $input = 'not supported validation rule';
                        break;
                }
            }
        });
        return $inputs;
    }
}
