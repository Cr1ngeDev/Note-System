<?php
session_start();
requireLogin();
require 'app/Kernel/Validation/validationFunction.php';

$header = "Create Note";
$errors = [];

if(is_post_request()) {

    $title = $_POST['title'] ?? null;
    $content = $_POST['content'];

    $data = [
        'title' => trim($_POST['title']),
        'text'  => rtrim(ltrim($_POST['content']))
    ];
    $rules = [
        'title' => ['max:65'],
        'text'  => ['required', 'max:5000']
    ];

    $errors = validate($data, $rules);
    if(!empty($errors)){
        redirect_with('/create', $errors);
        exit;
    }

    $time = new DateTime();
    $createdAt = $time->format('Y-m-d G:i:s');
    $user_id = getFromSession('user', 'user_id')[0];
    try{
        $pdo = connect();
        $pdo->beginTransaction();
        set_query($pdo,"INSERT INTO note_preview(note_name, user_id, createdAt) VALUES (:note_name, :user_id, :createdAt)",
            [
                ':note_name' => $title,
                ':user_id'   => $user_id,
                ':createdAt' => $createdAt
            ]
        );

        $lastConnectedId = $pdo->lastInsertId();

        set_query($pdo, "INSERT INTO note_content(text, preview_id) VALUES (:text, :preview_id)",
            ['text' => $content, 'preview_id' => $lastConnectedId]);

        $pdo->commit();
        header("Location: /");
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("DB error: " . $e->getMessage());
    } finally {
        $pdo = null;
    }

}
require VIEW_DIR . 'CreateNoteView.php';