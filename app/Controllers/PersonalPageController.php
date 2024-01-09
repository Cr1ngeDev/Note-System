<?php
session_start();
requireLogin();

require KERNEL_DIR . 'Services/csrfCheck.php';
require KERNEL_DIR . 'Validation/validationFunction.php';

$userData = getFromSession('user');
$header = "Personal Page";
$checkCode = session_flash('deleteCode')[0];

if (is_get_request()) {
    // для CSRF
    $_SESSION['TOKEN'] = bin2hex(random_bytes(32));
    [$userInput, $errors] = session_flash('inputs', 'errors');
}

if (is_post_request() && isset($_POST['editForm'])) {
    $token = $_POST['token'] ?? '';
    if (!checkToken($token)) {
        abort(405);
    }
    // из за функционала защиты данных от изменений (кнопка которая переводит поле ввода в disable),
    // в случае если юзер не разблокирует поле ввода, будут переданны старые данные
    // это сделано, потому что атрибут value = NULL, когда поле ввода disable
    $newData = [
        'email' => $_POST['email'] ?? $userData['email'],
        'firstname' => $_POST['first_name'] ?? $userData['firstname'],
        'lastname' => $_POST['last_name'] ?? $userData['lastname']
    ];
    $rules = [
        'email' => ['email'],
        'firstname' => ['required', 'max:50', 'alphanumeric'],
        'lastname' => ['required', 'max:100', 'alphanumeric'],
    ];
    $difference = array_diff_assoc($newData, $userData);

    if (empty($difference)) {
        $errors = ['You can\'t save unchanged values!'];
        redirect_with('/profile', ['inputs' => $newData, 'errors' => $errors]);
    }

    $errors = validate($newData, $rules);

    if (isset($difference['email'])) {
        $same_email = $difference['email'] === $userData['email'];
        if (!$same_email) {
            $error = validate(['email' => $difference['email']], ['email' => ['unique:user|email']]);
        }
    }

    if (!empty($errors)) {
        redirect_with('/profile', ['inputs' => $newData, 'errors' => $errors]);
    }

    if (updateUserInfo($difference, $userData['user_id']) !== false) {
        updateSession($difference, 'user');
        sleep(0.5);
        redirect_with_message('/profile', 'UserInfoUpdated', 'Your personale info has been updated!', FLASH_SUCCESS);
    }
}

if (is_post_request() && isset($_POST['delete'])) {
    if ($checkCode === $_POST['code']) {
        deleteUser($userData['user_id']);
        redirect('/');
    }
    $errors[] = "You entered an incorrect code";
    redirect_with('/profile', ['errors' => $errors]);
}
require VIEW_DIR . 'PersonalPageView.php';

