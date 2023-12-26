<?php
session_start();
require KERNEL_DIR . 'Auth/verify.php';
require KERNEL_DIR . 'Validation/validationFunction.php';

if(is_get_request()){
    $code = urldecode($_GET['ver'] ?? null);
    $uid  = urldecode(filter_input(INPUT_GET, 'uid', FILTER_VALIDATE_INT) ?? 0);

    if(verifyRequest($code, $uid)){
        require VIEW_DIR . 'NewPasswordPage.php';
    } else {
        require VIEW_DIR . 'MiddlePages/invalid.php';
    }
    exit;
}

if(is_post_request()){
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
    $user_id = $session_data['user']['user_id'];

    $password = getUserInfoBy(['password'], [':user_id' => $user_id], 'user_id');
    if(password_verify($inputData['password'], $password['password'])){
        $errors[] = 'Your new password must not be the same as the previous one!';
    }
    try {
        $pdo = connect();
        $pdo->beginTransaction();
        $sql = "UPDATE user SET password = :newPassword WHERE user_id = :user_id";
        $change = set_query($pdo, $sql, [':newPassword' => password_hash($inputData['password'], PASSWORD_BCRYPT), ':user_id' => $user_id]);
        $pdo->commit();
        if($change !== false){
            $message = 'You password has been successfully updated. Please re-login yo your account';
            $pdo = null;
            redirect_with_message('/login', 'Relogin', $message, FLASH_SUCCESS);
        }
    } catch (Exception $e){
        $pdo->rollBack();
        echo $e->getMessage();
    }
}

require VIEW_DIR . 'NewPasswordPage.php';