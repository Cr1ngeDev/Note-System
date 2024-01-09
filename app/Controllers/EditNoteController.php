<?php
session_start();
require KERNEL_DIR . 'Validation/validationFunction.php';
requireLogin();

$header = "Edit Note";
$old_data = getFromSession('noteData');
$noteId = getNoteId($url);
$response_id = $old_data['note_id'] ?? null;
sameOwnerOfNote($response_id, $noteId);

if (is_post_request()) {
    $pdo = connect();

    $title = $_POST['newTitle'] ?? null;
    $content = $_POST['newContent'];

    $newData = [
        'newTitle' => trim($title),
        'text' => rtrim(ltrim($content))
    ];
    $rules = [
        'newTitle' => ['max:65'],
        'text' => ['required', 'max:5000']
    ];

    $editErrors = validate($newData, $rules);

    if (!empty($editErrors)) {
        redirect_with('/note/' . $noteId . '/edit', ['inputs' => $newData, 'errors' => $editErrors]);
        exit;
    }

    $editTime = new DateTime();
    $createdAt = $editTime->format('Y-m-d G:i:s');
    $user_id = getFromSession('user', 'user_id');
    if (updateNoteDB($user_id, $createdAt, $noteId, $content, $title)) {
        $message = 'Your note has been successfully updated!';
        session_flash('userData');
        redirect_with_message('/note/' . $noteId, 'edited', $message, FLASH_SUCCESS);
    }
} elseif (is_get_request()) {
    [$userInput, $editErrors] = session_flash('inputs', 'errors');
}
require VIEW_DIR . 'EditPageView.php';
