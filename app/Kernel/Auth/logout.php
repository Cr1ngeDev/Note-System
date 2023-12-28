<?php
session_start();

if (isUserLoggedIn()){
    unset($_SESSION);
    session_destroy();
    $message = 'Have a nice day! See you later...';
    redirect('/');
}