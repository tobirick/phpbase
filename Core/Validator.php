<?php

namespace Core;

class Validator {
    private $providedValidations;
    private $providedValues;
    private $validations = [
        'required' => [
            'message' => 'is required',
            'rule' => 'strlen'
        ]
    ];
    private $errors = [];
    
    public function __construct($providedValues, $providedValidations) {
        $this->providedValues = $providedValues;
        $this->providedValidations = $providedValidations;

        $this->validate();
    }

    public function validate() {
        foreach($this->providedValidations as $validationKey => $validationValue) {
            $providedValue = $this->providedValues[$validationKey];

            $providedValidationRules = explode('|', $validationValue);

            foreach($providedValidationRules as $providedValidationRule) {
                $rule = $this->validations[$providedValidationRule];

                if(call_user_func($rule['rule'], $providedValue) === 0) {
                    $errors[$validationKey] = $rule['message'];
                }
            }
        }

        return $this->errors;
    }

    public function addValidation() {

    }
}