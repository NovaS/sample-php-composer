<?php
date_default_timezone_set("Asia/Jakarta");
require __DIR__.'/vendor/autoload.php';

use Dotenv\Dotenv;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Psaux\Util\Timer;
use Psaux\Config\DatabaseConfig;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$log = new Logger('app');
$log->pushHandler(new RotatingFileHandler(__DIR__.'/logs/app.log', '10', Logger::INFO));

$timer = new Timer();
$start = $timer->start();
sleep(1);
$time = $timer->get_time();
$log->info("Hello World! Total: $time");

$conf = new DatabaseConfig($log, $_ENV['DB_APP_HOST'],$_ENV['DB_APP_USER'],$_ENV['DB_APP_PASS'],$_ENV['DB_APP_NAME']);
$pdo = $conf->getPdo();
try {
  $sql = "SELECT NOW() as currenttime";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetch();
  if(!empty($result)) {
    $time = $result['currenttime'];
    print "Database time is $time";
    $log->info("Database time is $time!");
  } else {
    $log->info("Error in query!");
  }
} catch (PDOException $e) {
  $this->log->error('PDOException: '.$e->getMessage());
}

?>