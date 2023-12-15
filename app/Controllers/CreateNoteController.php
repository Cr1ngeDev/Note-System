<?php
session_start();

require 'app/Model/validationFunction.php';

$header = "Create Note";
$errors = [];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = connect('root', '0375Ihor_');

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
        $_SESSION['errors'] = $errors;
        header("Location: /create", true, 303);
        exit;
    }

    $time = new DateTime();
    $createdAt = $time->format('Y-m-d G:i:s');
    try{
        set_query($pdo,"INSERT INTO note_preview(note_name, user_id, createdAt) VALUES (:note_name, 1, :createdAt)",
            [
                ':note_name' => $title,
                ':createdAt' => $createdAt
            ]
        );

        $lastConnectedId = $pdo->lastInsertId();

        set_query($pdo, "INSERT INTO note_content(text, preview_id) VALUES (:text, :preview_id)",
            ['text' => $content, 'preview_id' => $lastConnectedId]);

        header("Location: /");
    } catch (PDOException $e) {
        die("DB error: " . $e->getMessage());
    }

}

require VIEW_DIR . 'CreateNoteView.php';