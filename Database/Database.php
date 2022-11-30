<?php declare(strict_types=1);

require_once(__DIR__ . '/../.env.php');
require_once(__DIR__ . '/../Config/DotEnv.php');
(new DotEnv(__DIR__ . '/../.env'))->load();

class Database {

  public static function getRow($id) {
    $dbh = new PDO("mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASSWORD'));
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $stm = $dbh->query('SELECT * FROM recepten WHERE id = 1');
    
    $row = $stm->fetchObject();
    
    return $row;
  }
} 