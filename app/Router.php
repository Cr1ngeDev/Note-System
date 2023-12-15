<?php

$routes = require 'Route.php';

$url = parse_url($_SERVER['REQUEST_URI'])['path'];

if(array_key_exists($url, $routes)){
    require $routes[$url];
} else {
    abort(404);
}
