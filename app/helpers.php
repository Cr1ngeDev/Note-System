<?php
function abort($status = 404)
{
    http_response_code($status);
    require "View/error_pages/$status.php";
    exit;
}
function getNoteId($url = null): string|false
{
    if($url == null){
        $url = parse_url($_SERVER['REQUEST_URI'])['path'];
    }
    if(preg_match('/\/note\/(\d+)|\/note\/(\d+)\//', $url, $matches)){
        return $matches[1];
    }
    return false;
}
function isUserLoggedIn(): bool
{
    return isset($_SESSION['user']);
}
function getFromSession(...$keys)
{
    $currentSession = $_SESSION;
    foreach ($keys as $key) {
        if (!isset($currentSession[$key])) {
            return false;
        }
        $currentSession = $currentSession[$key];
    }
    return $currentSession;
}
function requireLogin(): void
{
    if(!isUserLoggedIn()){
        redirect('/login');
    }
}
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function sameOwnerOfNote($response_id, $url_id = 0): bool
{
    if($url_id !== $response_id){
        abort();
    }
    return true;
}
function is_get_request(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}
function is_post_request(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}
function generateCode()
{
    return bin2hex(random_bytes(32));
}
function redirect($url, $status = null): void
{
    if($status !== null){
        http_response_code($status);
        header("Location: " . $url, $status);
    }
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
    if(count($keys) === 0){
        $data = $_SESSION;
        session_unset();
        return $data;
    }
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
    if(session_status() != PHP_SESSION_ACTIVE){
        session_start();
    }
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
    unset($_SESSION[FLASH]);

    foreach ($flash_message as $message){
        echo format_flash_message($message);
    }
}
function updateSession(array $newData, ...$session_key_way): void
{
    if(count($session_key_way) >= 1) {
        foreach ($session_key_way as $key){
            foreach ($newData as $data_key => $data){
                if(isset($_SESSION[$key][$data_key]) && $_SESSION[$key][$data_key] !== $data){
                    $_SESSION[$key][$data_key] = $data;
                }
            }
            unset($data);
        }
    }
}


