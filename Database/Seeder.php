<?php declare(strict_types=1);
require_once(__DIR__ . '/Database.php');

class Seeder{

public static function createTables() {
    $dbh = DATABASE::connectToDB();

    $dbh->query("CREATE TABLE recipes (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            pagetitle VARCHAR(50) NOT NULL,
            title VARCHAR(50) NOT NULL,
            subtitle VARCHAR(200),
            imagelink VARCHAR(50),
            calories VARCHAR(20),
            preptime VARCHAR(20),
            baketime VARCHAR(20),
            portions VARCHAR(20),
            necessary VARCHAR(100),
            preparation VARCHAR(2000),
            nutrition VARCHAR(200),
            added DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            )");
    
    $dbh->query("CREATE TABLE ingredients (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            ingredient VARCHAR(50) NOT NULL,
            quantity INT NOT NULL,
            unit VARCHAR(10)
     )");

    $dbh->query("CREATE TABLE recipe_ingredients (
        ingredient_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        recipe_id INT NOT NULL
    )");
}

public static function addToDatabase() {
    $dbh = Database::connectToDB();
    
    $count = Database::getMaxId() + 1;
    $date = date('Y-m-d H:i:s');

    foreach (glob(__DIR__ . "/../recepten/*.json") as $file) {
      
      $f = json_decode(file_get_contents($file));
      $f = $f[0];

      $f->nutrition = implode(',', $f->nutrition);
      $f->necessary = implode(',', $f->necessary);
      $f->preparation = implode(',', $f->preparation);
      $f->ingredients = implode(',', $f->ingredients);
      
      $stm = $dbh->query("INSERT INTO recipes
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
          $date .  "');");

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
      $count++;
    }

  }
}

// Seeder::createTables();
Seeder::addToDatabase();