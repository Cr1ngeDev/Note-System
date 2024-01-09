<?php
session_start();
require KERNEL_DIR . 'Auth/verify.php';
require KERNEL_DIR . 'Validation/validationFunction.php';

if (is_get_request()) {
    $code = urldecode($_GET['ver'] ?? null);
    $uid = urldecode(filter_input(INPUT_GET, 'uid', FILTER_VALIDATE_INT) ?? 0);
    if (verifyRequest($code, $uid)) {
        $_SESSION['uid'] = $uid;
        [$errors] = session_flash('errors');
        require VIEW_DIR . 'NewPasswordPage.php';
    } else {
        require VIEW_DIR . 'MiddlePages/invalid.php';
    }
    exit;
}
if (is_post_request()) {
    $session_data = session_flash();

    $inputData = [
        'password' => $_POST['password'],
        'password_confirm' => $_POST['password_confirm']
    ];
    $rules = [
        'password' => ['required', 'min:5', 'max:255', 'confirm'],
        'password_confirm' => ['required']
    ];

    $errors = validate($inputData, $rules);
    if (!empty($errors)) {
        redirect_with($_SERVER['REQUEST_URI'], ['errors' => $errors]);
    }

    $user_id = $session_data['uid'];
    $password = getUserInfoBy(['password'], [':user_id' => $user_id], 'user_id');
    if (password_verify($inputData['password'], $password['password'])) {
        $errors[] = 'Your new password must not be the same as the previous one!';
        redirect_with($_SERVER['REQUEST_URI'], ['errors' => $errors]);
    }
    if (updatePasswordDB($inputData['password'], $user_id)) {
        deleteFromVerifyDB($user_id);
        $message = 'You password has been successfully updated. Please re-login yo your account';
        redirect_with_message('/login', 'Relogin', $message, FLASH_SUCCESS);
    }
}

require VIEW_DIR . 'NewPasswordPage.php';