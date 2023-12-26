<?php

return [
    '/'                          => CONTROLLER_DIR . 'HomePageController.php',
    '/create'                    => CONTROLLER_DIR . 'CreateNoteController.php',
    '/note/'.$noteId             => CONTROLLER_DIR . 'ShowNoteController.php',
    '/delete'                    => KERNEL_DIR     . 'Services/delete.php',
    '/note/'.$noteId.'/edit'     => CONTROLLER_DIR . 'EditNoteController.php',
    '/ahh-another-user'          => CONTROLLER_DIR . 'RegisterController.php',
    '/login'                     => CONTROLLER_DIR . 'LoginController.php',
    '/logout'                    => KERNEL_DIR     . 'Auth/logout.php',
    '/profile'                   => CONTROLLER_DIR . 'PersonalPageController.php',
    '/reset/send-email'          => KERNEL_DIR     . 'Auth/EmailChangePassword.php',
    '/reset/new-password'        => CONTROLLER_DIR . 'ResetPasswordController.php'
];