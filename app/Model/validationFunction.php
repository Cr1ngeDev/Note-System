<?php

function validate(array $value, array $rules) :array
{
    if (empty($value) || empty($rules)) {
        return [];
    }
    $errors = [];
    foreach ($rules as $key => $rule) {
        foreach ($rule as $item) {
            $parameters = explode(":", trim($item));
            $ruleName = $parameters[0];
            $ruleValue = $parameters[1] ?? null;

            $error = check($value, $key, $ruleName, $ruleValue);
            if($error){
                $errors[] = $error;
            }
        }
    }
    return $errors;
}

function check(array $data, string $key, string $ruleName, string $ruleValue = null) :string|false
{
    $value = $data[$key];
    switch ($ruleName){
        case 'required':
            if(mb_strlen(trim($value)) === 0 && $value == null){
                return "The field {$key} is required!";
            }
            break;
        case 'min':
            if (mb_strlen($value) < $ruleValue) {
                return "Field {$key} must be at least {$ruleValue} characters long";
            }
            break;
        case 'max':
            if (mb_strlen($value) > $ruleValue) {
                return "Field {$key} must be at most {$ruleValue} characters long";
            }
            break;
        case 'number':
            if(!filter_var($value, FILTER_VALIDATE_INT)){
                return "The field {$key} must contain only numbers!";
            }
            break;
        case 'email':
            if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                return "The field {$key} must have a valid email!";
            }
            break;
        case 'alphanumeric':
            if(!preg_match('/^[a-zA-Z0-9\'-]+([a-zA-Z0-9\'-]+)*$/', $value)){
                return "The field {$key} must contain only words or/and numbers";
            }
            break;
        case 'confirm':
            if($value !== $data[$key . '_confirm']){
                return "Passwords must be same!";
            }
            break;
    }
    return false;
}
