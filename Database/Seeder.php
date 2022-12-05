<?php declare(strict_types=1);
require_once(__DIR__ . '/Database.php');

class Seeder{

public static function createTables() {
    $dbh = DATABASE::connectToDB();

    $dbh->query("CREATE TABLE recipes (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            pagetitle VARCHAR(20) NOT NULL,
            title VARCHAR(50) NOT NULL,
            subtitle VARCHAR(100),
            imagelink VARCHAR(20),
            calories VARCHAR(20),
            preptime VARCHAR(20),
            baketime VARCHAR(20),
            portions VARCHAR(20),
            necessary VARCHAR(100),
            preparation VARCHAR(1000),
            nutrition VARCHAR(200),
            added DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            )");
    
    $dbh->query("CREATE TABLE ingredients (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            ingredient VARCHAR(50) NOT NULL,
            quantity INT NOT NULL,
            unit VARCHAR(1)
     )");

    $dbh->query("CREATE TABLE recipe_ingredients (
        ingredient_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        recipe_id INT NOT NULL
    )");
}

public static function addToDatabase() {
    $dbh = Database::connectToDB();
    $count = $dbh->query("SELECT MAX(id) FROM test") + 1;
    $day = 1;
    $month = 1;
    $year = 2022;
    $hour = 0;
    $minute = 0;

    foreach (glob(__DIR__ . "/*.json") as $file) {
      $added = create_date("$year, $month, $day, $hour, $minute");
      $f = json_decode(file_get_contents($file));
      $f = $f[0];

      $f->nutrition = implode(',', $f->nutrition);
      $f->necessary = implode(',', $f->necessary);
      $f->preparation = implode(',', $f->preparation);
      $f->ingredients = implode(',', $f->ingredients);
      
      $stm = $dbh->query("INSERT INTO test 
        VALUES ('" . $count . "', '"  . $f->pageTitle . "', '" . 
          $f->title . "', '" .  
          $f->subTitle . "', '" . 
          $f->imageLink . "', '" . 
          $f->calories . "', '" . 
          $f->prepTime . "', '" . 
          $f->bakeTime . "', '" . 
          $f->portions . "', '" . 
          $f->necessary . "', '" . 
          $f->preparation . "', '" . 
          $f->nutrition . "', '" .
          $added .
          "');");

      $a = explode(',', $f->ingredients);
     
      foreach($a as $i) {
        
        $str = explode(' ', $i);
        $quan = array_shift($str);
        $unit = array_shift($str);
        
        $ing = implode(' ', $str );
        
        $dbh->query("INSERT INTO ingredients (ingredient, quantity, unit)
          VALUES ('" . $ing . "', '" . $quan . "', '" . $unit ."'); ");
      
        $dbh->query("INSERT INTO recipe_ingredients (recipe_id)
        VALUES ('" . $count . "');"); 
      }
    }
    $minute += 30;

    if ($added < new date()) {
      if ($minute == 60) {
        $minute = 0;
        $hour++;
        if ($hour == 24) {
          $day++;
          $hour = 0;
          if ($day == 30) {
            $day = 1;
            if ($month <= 12) {
              $month++;
            }
          }
        }
      }
    }

    $count++;
  }
}

// Seeder::addToDatabase();
Seeder::createTables();