<?php
session_start();
require KERNEL_DIR . 'Validation/validationFunction.php';
requireLogin();

$header = "Edit Note";
$old_data = getFromSession('noteData');
$noteId = getNoteId($url);
$response_id = $old_data['note_id'] ?? null;
sameOwnerOfNote($response_id, $noteId);

if(is_post_request()){
    $pdo = connect();

    $title = $_POST['newTitle'] ?? null;
    $content = $_POST['newContent'];

    $newData = [
        'newTitle' => trim($title),
        'text'  => rtrim(ltrim($content))
    ];
    $rules = [
        'newTitle' => ['max:65'],
        'text'  => ['required', 'max:5000']
    ];

    $editErrors = validate($newData, $rules);

    if(!empty($editErrors)){
        redirect_with('/note/' . $noteId . '/edit', ['inputs' => $newData, 'errors' => $editErrors]);
        exit;
    }

    $editTime = new DateTime();
    $createdAt = $editTime->format('Y-m-d G:i:s');
    $user_id = getFromSession('user', 'user_id');

    try{
        $pdo->beginTransaction();
        set_query($pdo,"UPDATE note_preview SET note_name = :note_name, user_id = :user_id, createdAt = :createdAt WHERE id = :id",
            [
                ':note_name' => $title,
                ':user_id'   => $user_id,
                ':createdAt' => $createdAt,
                ":id"        => $noteId
            ]
        );

        set_query($pdo, "UPDATE note_content SET text = :text WHERE preview_id = :preview_id",
            ['text' => $content, 'preview_id' => $noteId]);

        $pdo->commit();
        $message = 'Your note has been successfully updated!';
        session_flash('userData');
        $pdo = null;
        redirect_with_message('/note/' . $noteId, 'edited', $message, FLASH_SUCCESS);
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("DB error: " . $e->getMessage());
    }
} elseif(is_get_request()){
    [$userInput, $editErrors] = session_flash('inputs', 'errors');
}
require VIEW_DIR . 'EditPageView.php';
