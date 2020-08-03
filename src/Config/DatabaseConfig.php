<?php
namespace Psaux\Config;

use PDO;
use PDOException;

class DatabaseConfig {
  protected $log;
  protected $host;
  protected $user;
  protected $pass;
  protected $name;

  public function __construct($log,$host,$user,$pass,$name) {
    $this->log = $log;
    $this->host = $host;
    $this->user = $user;
    $this->pass = $pass;
    $this->name = $name;
  }

  public function getPdo() {
    $dsn = "mysql:host=$this->host;dbname=$this->name";
    $opt = array (
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false 
    );
    try {
      return new PDO($dsn, $this->user, $this->pass, $opt);
    } catch (PDOException $e) {
      $this->log->error("PDOException-getPdo: ".$e->getMessage());
      return false;
    }
  }
}