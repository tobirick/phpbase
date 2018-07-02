<?php

namespace Core;

class Validator {
    private $lang;
    private $providedValidations;
    private $providedValues;
    private $validations;
    private $errors = [];
    
    public function __construct($providedValues, $providedValidations, $lang) {
        $this->lang = $lang;
        $this->providedValues = $providedValues;
        $this->providedValidations = $providedValidations;

        $this->setValidations();
    }

    private function setValidations() {
        $this->validations = [
            'required' => [
                'message' => $this->lang->getTranslation('is required'),
                'rule' => 'checkRequired'
            ],
            'max' => [
                'message' => $this->lang->getTranslation('is too long'),
                'rule' => 'checkMaxLength'
            ],
            'min' => [
                'message' => $this->lang->getTranslation('is too short'),
                'rule' => 'checkMinLength'
            ],
            'email' => [
                'message' => $this->lang->getTranslation('is no valid email'),
                'rule' => 'checkEmail'
            ],
            'int' => [
                'message' => $this->lang->getTranslation('is no valid number'),
                'rule' => 'checkInt'
            ]
        ];
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

    public function addError($field, $message) {
        $this->errors[$field][] = $message;
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

    private function checkEmail($value) {
        if(filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    private function checkInt($value) {
        if(filter_var($value, FILTER_VALIDATE_INT)) {
            return false;
        }

        return true;
    }
}