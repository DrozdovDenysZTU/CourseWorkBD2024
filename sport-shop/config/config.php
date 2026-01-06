<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$script = dirname($_SERVER['SCRIPT_NAME']);
$basePath = rtrim($script, '/');

define('BASE_URL', "$protocol://$host$basePath");

define('APP_PATH', realpath(__DIR__ . '/..'));

function base_url($path = '')
{
    return rtrim(BASE_URL, '/') . ltrim($path, '/');
}

function view_path($relativePath)
{
    return APP_PATH . '/' . ltrim($relativePath, '/');
}
