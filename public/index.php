<?php

define('ROOT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

require ROOT_PATH . 'vendor/autoload.php';

$app = new Soda\Application('dev', true);
$app->start();
