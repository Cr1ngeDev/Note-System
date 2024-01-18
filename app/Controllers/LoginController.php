<?php
session_start();
require KERNEL_DIR . 'Auth/login.php';
require KERNEL_DIR . 'Validation/validationFunction.php';

notAllowedForLoggedUser('/login');

if (is_post_request()) {

    $userData = [
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ];
    $rules = [
        'email' => ['email'],
        'password' => ['required']
    ];

    $errors = validate($userData, $rules);

    if (!empty($errors)) {
        $message = 'Invalid password or email!';
        redirect_with_message('/login', 'Validation Error', $message, FLASH_WARNING);
    }
    $email = $userData['email'];
    $password = $userData['password'];

    if (!login($email, $password)) {
        $message = 'Wrong email or password! Try again.';
        redirect_with_message('/login', 'Access Error', $message, FLASH_ERROR);
    }
    redirect('/');
}

require VIEW_DIR . 'LoginPageView.php';