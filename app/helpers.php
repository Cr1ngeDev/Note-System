<?php
function abort($status = 404)
{
    http_response_code($status);
    require "View/error_pages/{$status}.php";
    exit;
}

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

