<?php

namespace Core;

class Validator {
    private $providedValidations;
    private $providedValues;
    private $validations = [
        'required' => [
            'message' => 'is required',
            'rule' => 'checkRequired'
        ],
        'maxlength' => [
            'message' => 'is too long',
            'rule' => 'checkMaxLength'
        ],
        'minlength' => [
            'message' => 'is too short',
            'rule' => 'checkMinLength'
        ]
    ];
    private $errors = [];
    
    public function __construct($providedValues, $providedValidations) {
        $this->providedValues = $providedValues;
        $this->providedValidations = $providedValidations;
    }

    public function validate() {
        foreach($this->providedValidations as $validationKey => $validationValue) {
            $providedValue = $this->providedValues[$validationKey];
            $params = [$providedValue];

            $providedValidationRules = explode('|', $validationValue);

            foreach($providedValidationRules as $providedValidationRule) {
                if(strpos($providedValidationRule, ':') !== false) {
                    $explodedValidationRule = explode(':', $providedValidationRule);
                    $params[] = $explodedValidationRule[1];
                    $providedValidationRule = $explodedValidationRule[0];
                }
                $rule = $this->validations[$providedValidationRule];

                if(call_user_func_array(array($this, $rule['rule']), $params)) {
                    $validationKeyString = ucfirst(join(' ', explode('_', $validationKey)));

                    $this->errors[$validationKey][] = $validationKeyString . ' ' . $rule['message'] . '!';
                }
            }
        }

        return $this->errors;
    }

    private function checkRequired($value) {
        return strlen($value) === 0;
    }

    private function checkMaxLength($value, $length) {
        if(strlen($value) > $length) {
            return true;
        }

        return false;
    }

    private function checkMinLength($value, $length) {
        if(strlen($value) >= $length) {
            return false;
        }

        return true;
    }
}