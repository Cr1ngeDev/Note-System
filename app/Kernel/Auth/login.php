<?php
function findUserByEmail(string $email): array|false
{
    $pdo = connect();
    try {
        $sql = 'SELECT user_id, email, firstname, lastname, password FROM user WHERE email = :email';
        $userData = set_query($pdo,$sql, ['email' => $email])->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e){
        return false;
    }
    return $userData;
}
function login(string $email, string $password): bool
{
    $userData = findUserByEmail($email);
    if($userData && password_verify($password, $userData['password'])){
        session_regenerate_id();
        $_SESSION['user'] = [
            'user_id'   => $userData['user_id'],
            'firstname' => $userData['firstname'],
            'lastname'  => $userData['lastname'],
            'email'     => $userData['email']
        ];
        return true;
    }
    return false;
}

