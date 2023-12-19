<?php
require KERNEL_DIR . 'Validation/validationFunction.php';
require KERNEL_DIR . 'Auth/register.php';
session_start();

if(is_post_request()){
    $userData = [
        'firstname'        => trim($_POST['firstname']),
        'lastname'         => trim($_POST['lastname']),
        'email'            => $_POST['email'],
        'password'         => $_POST['password'],
        'password_confirm' => $_POST['confirm-password']
    ];
    $rules = [
        'email'            => ['email', 'unique:user|email'],
        'password_confirm' => ['required'],
        'password'         => ['required', 'min:5', 'max:255', 'confirm'],
        'firstname'        => ['required', 'max:50'],
        'lastname'         => ['required', 'max:100'],
    ];

    $errors = validate($userData, $rules);

    if(!empty($errors)){
        redirect_with('/ahh-another-user', ['inputs' => $userData, 'errors' => $errors]);
    }
    $now = new DateTime();
    $createdAt = $now->format('Y-m-d G:s:i');
    $saveUserData = [
        'email'     => $_POST['email'],
        'password'  => password_hash($_POST['password'], PASSWORD_BCRYPT),
        'firstname' => trim($_POST['firstname']),
        'lastname'  => trim($_POST['lastname']),
        'createdAt' => $createdAt
    ];

    register($saveUserData);

} elseif (is_get_request()){
    [$userInput, $errors] = session_flash('inputs', 'errors');
}

require VIEW_DIR . 'RegisterView.php';