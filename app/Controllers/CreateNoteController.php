<?php
session_start();
require 'app/Kernel/Validation/validationFunction.php';

$header = "Create Note";
$errors = [];

if(is_post_request()) {
    $pdo = connect();

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
    try{
        $pdo->beginTransaction();
        set_query($pdo,"INSERT INTO note_preview(note_name, user_id, createdAt) VALUES (:note_name, 1, :createdAt)",
            [
                ':note_name' => $title,
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
    }

}

require VIEW_DIR . 'CreateNoteView.php';