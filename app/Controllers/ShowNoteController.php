<?php

$header = "Your Note";

$pdo = connect();
$user_id = 1;
if (is_get_request()){

    $noteData = set_query($pdo, 'SELECT c.text, p.note_name, p.createdAt, p.id FROM note_content AS c 
                                JOIN note_preview AS p WHERE p.id = c.preview_id AND p.user_id = :user_id AND p.id = :noteId',
        [
            ':user_id' => $user_id,
            ':noteId' => $noteId
        ])->fetch(PDO::FETCH_ASSOC);
}

require VIEW_DIR . 'ShowNoteView.php';