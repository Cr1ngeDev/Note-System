<?php
session_start();
requireLogin();

require KERNEL_DIR . 'Validation/validationFunction.php';
require KERNEL_DIR . 'Services/Email.php';


if(is_post_request()){
    $accountEmail = getFromSession('user', 'email');
    $data = [
        'email' => $_POST['email']
    ];
    $rules = [
        'email' => ['email']
    ];

    $errors = validate($data, $rules);
    if(!empty($errors)){
        redirect_with('/reset', ['inputs' => $data, 'errors' => $errors]);
    }

    $code = generateCode();
    $user_id = getFromSession('user', 'user_id');

    if(sendVerificationEmail($data['email'], $user_id ,$code)){
        $hash = password_hash($code, PASSWORD_BCRYPT);
        if(addToVerifyDB($user_id, $hash)){
            require VIEW_DIR . 'MiddlePages/emailSent.php';
            exit;
        }
        redirect_with_message('/reset', 'resetError', 'Something went wrong. Please try again or connect to our support', FLASH_ERROR);
    }
} elseif (is_get_request()){
    [$errors, $inputs] = session_flash('errors', 'inputs');
}

require VIEW_DIR . 'ResetPasswordPage.php';