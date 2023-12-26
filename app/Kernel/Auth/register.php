<?php

function saveUser(array $userData): bool
{
    $pdo = connect();
    $keys = array_keys($userData);
    $fields = implode(', ', $keys);
    $columns = implode(', ', array_map(fn($fields) => ":$fields", $keys));

    try {
        $pdo->beginTransaction();
        set_query($pdo, "INSERT INTO user($fields) VALUES($columns)", $userData)->errorInfo();
        $pdo->commit();
        $pdo = null;
        return true;
    } catch(PDOException $e){
        $pdo->rollBack();
        return false;
    }
}

function register(array $userData): void
{
    if(!saveUser($userData)){
        return;
    }
    $message = "Your account has been created successfully! Now you can login with your credentials.";
    redirect_with_message('/login', 'success', $message, FLASH_SUCCESS);
}