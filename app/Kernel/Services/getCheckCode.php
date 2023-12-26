<?php
session_start();

$userData = $_SESSION['user']['firstname'];
$code = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ%$!'),1, 5) . '@' . $userData;
$_SESSION['deleteCode'] = $code;

header("Content-Type: application/json");
echo json_encode($code);