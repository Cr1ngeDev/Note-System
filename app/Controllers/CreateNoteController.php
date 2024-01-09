<?php
session_start();
requireLogin();
require 'app/Kernel/Validation/validationFunction.php';

$header = "Create Note";
$errors = [];


if (is_post_request()) {

    $title = $_POST['title'] ?? '';
    $content = $_POST['content'];

    $data = [
        'title' => trim($_POST['title']),
        'text' => rtrim(ltrim($_POST['content']))
    ];
    $rules = [
        'title' => ['max:65'],
        'text' => ['required', 'max:5000']
    ];

    $errors = validate($data, $rules);
    if (!empty($errors)) {
        redirect_with('/create', $errors);
        exit;
    }

    $time = new DateTime();
    $createdAt = $time->format('Y-m-d G:i:s');
    $user_id = getFromSession('user', 'user_id');

    if (saveNoteDB($user_id, $createdAt, $content, $title)) {
        header("Location: /");
    }
}
require VIEW_DIR . 'CreateNoteView.php';
