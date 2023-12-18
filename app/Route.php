<?php

return [
    '/' => CONTROLLER_DIR . 'HomePageController.php',
    '/create' => CONTROLLER_DIR . 'CreateNoteController.php',
    '/note/'.$noteId => CONTROLLER_DIR . 'ShowNoteController.php',
    '/delete' => KERNEL_DIR . 'Services/delete.php',
    'edit/'.$noteId => CONTROLLER_DIR . 'EditNoteController.php',
    '/ahh-another-user' => CONTROLLER_DIR . 'RegisterController.php',
    '/login' => CONTROLLER_DIR . 'LoginController.php'
];