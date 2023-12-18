<?php
function abort($status = 404)
{
    http_response_code($status);
    require "View/error_pages/{$status}.php";
    exit;
}

function getNoteId($url): string|false
{
    if(preg_match('/\/note\/(\d+)/', $url, $matches)){
        return $matches[1];
    }
    return false;
}

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}
function is_get_request(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}
function is_post_request(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}
function redirect($url): void
{
    header("Location: " . $url);
    exit;
}
function redirect_with_message(string $url, string $name, string $message, string $type):void
{
    flash($name, $message, $type);
    redirect($url);
}
function redirect_with(string $url, array $value): void
{
    foreach ($value as $key => $item){
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }
        $_SESSION[$key] = $item;
    }
    redirect($url);
}
function session_flash(...$keys): array
{
    $data = [];
    foreach ($keys as $key) {
        if (isset($_SESSION[$key])) {
            $data[] = $_SESSION[$key];
            unset($_SESSION[$key]);
        } else {
            $data[] = [];
        }
    }
    return $data;
}
function flash(string $name = '', string $message = '', string $type = '') :void
{
    if($name !== '' && $message !== '' && $type !== ''){
        create_flash_message($name, $message, $type);
    } else if($name !== '' && $message === '' && $type === ''){
        show_flash($name);
    } else if($name === '' && $message === ''&& $type === '') {
        show_all_flash();
    }
}

function create_flash_message($name, $message, $type): void
{
    session_start();
    if(isset($_SESSION[FLASH][$name])){
        unset($_SESSION[FLASH][$name]);
    }
    $_SESSION[FLASH][$name] = [
        'message' => $message,
        'type' => $type
    ];
}

function show_flash($name): void
{
    if(!isset($_SESSION[FLASH][$name])) {
        return;
    }
    $flash_message = $_SESSION[FLASH][$name];
    unset($_SESSION[FLASH][$name]);

    echo format_flash_message($flash_message);
}

function format_flash_message($message): string
{
    return sprintf('<div class="alert alert-%s">%s</div>',
        $message['type'],
        $message['message']
    );
}
function show_all_flash() :void
{
    if(!isset($_SESSION[FLASH])) {
        return;
    }
    $flash_message = $_SESSION[FLASH];
    unset($_SESSION[FLASH][$name]);

    foreach ($flash_message as $message){
        echo format_flash_message($message);
    }
}