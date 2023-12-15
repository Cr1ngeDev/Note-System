<?php

$header = "Your Notes";

$all_notes = [];

$user_id = 1; // временно

$pdo = connect('root', '0375Ihor_');

if($_SERVER['REQUEST_METHOD'] == "GET"){
   $all_notes = set_query($pdo, 'SELECT c.text, p.note_name, p.createdAt FROM note_content AS c 
                                JOIN note_preview AS p WHERE p.id = c.preview_id AND p.user_id = :user_id',
   [':user_id'=>$user_id])->fetchAll(PDO::FETCH_ASSOC);
}
function getFirstSentence(string $text) :string
{
    preg_match('/^(.{1,25}[^,]*[.!?\s])/', $text, $matches);
    return $matches[0] ?? '';
}

require VIEW_DIR . "HomePageView.php";

// добавить авторизацию