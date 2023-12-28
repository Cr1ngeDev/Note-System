<?php


function verifyRequest(string $code, int $user_id): bool
{
    $data = getFromVerifyDB($user_id);
    if (! $data){
        return false;
    }
    if(time() - strtotime($data['createdAt']) > 12 * 60 * 60){
        return false;
    }
    if (password_verify($code, $data['verify_code'])){
        return true;
    }
    return false;
}