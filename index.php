<?php
include_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function env($name)
{
    return isset($_ENV[$name]) ? $_ENV[$name] : null;
}

global $app;
dump($_POST);
$app = new \Vpos\Core();

include_once './layout/main.php';