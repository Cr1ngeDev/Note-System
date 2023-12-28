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

            $params_for_sql = explode("|", (string)$ruleValue);
            $tableName = $params_for_sql[0] ?? null;
            $column = $params_for_sql[1] ?? null;

            $error = check($value, $key, $ruleName, $ruleValue, $tableName, $column);
            if($error){
                $errors[] = $error;
                return $errors;
            }
        }
    }
    return [];
}

function check(array $data, string $key, string $ruleName, string $ruleValue = null, string $tableName = null, string $column = null) :string|false
{
    $value = $data[$key];
    switch ($ruleName){
        case 'required':
            if(mb_strlen(trim($value)) === 0 || $value == null){
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
        case 'unique':
            if(!isUnique($tableName, $column, $value)){
                return "User with this $key is already exists!";
            }
            break;
    }
    return false;
}

function isUnique(string $tableName, string $column, string $value): bool
{
    $pdo = connect();
    $sql = "SELECT $column FROM $tableName WHERE $column = :value";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":value", $value);
    $stmt->execute();
    return $stmt->fetchColumn() === false;
}