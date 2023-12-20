<?php
session_start();
requireLogin();

$header = "Your Note";

$pdo = connect();
$user_id = getFromSession('user','user_id') ?? false;
if (is_get_request()){
    $stmt = set_query($pdo, 'SELECT c.text, p.note_name, p.createdAt, p.id FROM note_content AS c 
                                JOIN note_preview AS p WHERE p.id = c.preview_id AND p.user_id = :user_id AND p.id = :noteId',
        [
            ':user_id' => $user_id,
            ':noteId' => $noteId
        ])->fetch(PDO::FETCH_ASSOC);
    $noteData = $stmt;
    $stmt = null;
    $_SESSION['noteData'] = [
        'note_name'     => $noteData['note_name'],
        'text'          => $noteData['text']
    ];
    $fullName = getFromSession('user');
    $fullName = $fullName['lastname'] . ' ' . $fullName['firstname'];
}

require VIEW_DIR . 'ShowNoteView.php';