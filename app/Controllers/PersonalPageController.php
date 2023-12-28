<?php
session_start();
requireLogin();

require KERNEL_DIR . 'Services/csrfCheck.php';
require KERNEL_DIR . 'Validation/validationFunction.php';

$userData = getFromSession('user');
$header = "Personal Page";
$checkCode = session_flash('deleteCode')[0];

if(is_get_request()){
    // для CSRF
    $_SESSION['TOKEN'] = bin2hex(random_bytes(32));
    [$userInput, $errors] = session_flash('inputs', 'errors');

}
if (is_post_request() && isset($_POST['editForm'])){
    $token = $_POST['token'] ?? '';
    if(!checkToken($token)){
        abort(405);
    }
    // из за функционала защиты данных от изменений (кнопка которая переводит поле ввода в disable),
    // в случае если юзер не разблокирует поле ввода, будут переданны старые данные
    // это сделано, потому что атрибут value = NULL, когда поле ввода disable
    $newData = [
        'email'     => $_POST['email'] ?? $userData['email'],
        'firstname' => $_POST['first_name'] ?? $userData['firstname'],
        'lastname'  => $_POST['last_name'] ?? $userData['lastname']
    ];
    $rules = [
        'email'     => ['email', 'unique:user|email'],
        'firstname' => ['required', 'max:50'],
        'lastname'  => ['required', 'max:100'],
    ];
    $difference = array_diff_assoc($newData, $userData);

    if($difference && $newData['email'] === $userData['email']){
        $errors = ['Your new email must not be same!'];
        redirect_with('/profile', ['inputs' => $newData, 'errors' => $errors]);
    }

    if(empty($difference)){
        $errors = ['You can\'t save unchanged values!'];
        redirect_with('/profile', ['inputs' => $newData, 'errors' => $errors]);
    }

    if(!empty($errors)){
        redirect_with('/profile', ['inputs' => $newData, 'errors' => $errors]);
    }

    try{
        $pdo = connect();
        $diff_keys = array_keys($difference);
        $fields = implode(', ', array_map(fn($diff_keys) => "$diff_keys = :$diff_keys", $diff_keys));
        $sql = "UPDATE user SET $fields WHERE user_id = :user_id";

        $values = array_merge($difference, ['user_id' => $userData['user_id']]);

        $pdo->beginTransaction();
        $is_updated = set_query($pdo, $sql,  $values);

        if ($is_updated !== false){
            $pdo->commit();
            $pdo = null;
            updateSession($difference, 'user');
            sleep(0.5);
            redirect_with_message('/profile', 'UserInfoUpdated', 'Your personale info has been updated!', FLASH_SUCCESS);
        }
    } catch (PDOException $e){
        $pdo->rollBack();
        die($e->getMessage());
    }
}
if(is_post_request() && isset($_POST['delete'])){
    if($checkCode === $_POST['code']) {
        try{
            $pdo = connect();
            $pdo->beginTransaction();
            $sql = "DELETE FROM user WHERE user_id = :user_id";
            set_query($pdo, $sql, [':user_id' => $userData['user_id']]);
            $pdo->commit();
            session_flash('user');
            session_flash('TOKEN');
        } catch (PDOException $e){
            $pdo->rollBack();
            die($e->getMessage());
        } finally {
            $pdo = null;
        }
        redirect('/');
    }
    $errors[] = "You entered an incorrect code";
    redirect_with('/profile', ['errors' => $errors]);
}
require VIEW_DIR . 'PersonalPageView.php';

