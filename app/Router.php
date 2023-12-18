<?php

$url = parse_url($_SERVER['REQUEST_URI'])['path'];
$noteId = getNoteId($url);

$routes = require 'Route.php';

if(array_key_exists($url, $routes)){
    require $routes[$url];
} else {
    abort(404);
}
