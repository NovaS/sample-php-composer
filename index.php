<?php
date_default_timezone_set("Asia/Jakarta");
require __DIR__.'/vendor/autoload.php';

use Dotenv\Dotenv;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$log = new Logger('app');
$log->pushHandler(new RotatingFileHandler(__DIR__.'/logs/app.log', '10', Logger::INFO));

$log->info("Hello World!");

?>