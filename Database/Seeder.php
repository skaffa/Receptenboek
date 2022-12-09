<?php declare(strict_types=1);
require_once(__DIR__ . '/Database.php');

class Seeder{

public static function createTables() {
    $dbh = DATABASE::connectToDB();

    $dbh->query("CREATE TABLE recipes (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            pagetitle VARCHAR(500) NOT NULL,
            title VARCHAR(500) NOT NULL,
            subtitle VARCHAR(500),
            imagelink VARCHAR(50),
            calories VARCHAR(100),
            preptime VARCHAR(100),
            baketime VARCHAR(100),
            portions VARCHAR(100),
            necessary VARCHAR(1000),
            preparation VARCHAR(4000),
            nutrition VARCHAR(500),
            added DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            )");
    
    $dbh->query("CREATE TABLE ingredients (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            ingredient VARCHAR(100) NOT NULL,
            quantity VARCHAR(100) NOT NULL,
            unit VARCHAR(100)
     )");

    $dbh->query("CREATE TABLE recipe_ingredients (
        ingredient_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        recipe_id INT NOT NULL
    )");
}

public static function addToDatabase() {
    $dbh = Database::connectToDB();
    
    $count = 1; // Database::getMaxId() + 1;
    $date = date('Y-m-d H:i:s');

    foreach (glob(__DIR__ . "/../Utilities/AlbertHeijn/RecipeRipper/output/*.json") as $file) {
      
      $f = json_decode(file_get_contents($file));
      $f = $f;

      $f->nutrition = implode(',', $f->nutrition);
      $f->necessary = implode(',', $f->necessary);
      $f->preparation = implode(',', $f->preparation);
      $f->ingredients = implode(',', $f->ingredients);
      
      $stm = $dbh->query('INSERT INTO recipes
        VALUES ("' . $count . '", "'  . $f->pageTitle . '", "' . 
          $f->pageTitle . '", "' .  
          $f->title . '", "' . 
          $f->id . ".jpg" . '", "' . 
          $f->calories . '", "' . 
          $f->prepTime . '", "' . 
          $f->bakeTime . '", "' . 
          $f->portions . '", "' . 
          $f->necessary . '", "' . 
          $f->preparation . '", "' . 
          $f->nutrition . '", "' .     
          $date .  '");');

      $a = explode(',', $f->ingredients);

      foreach($a as $i) {
        
        $str = explode(' ', $i);
        $quan = array_shift($str);
        $unit = array_shift($str);
        
        $ing = implode(' ', $str );
        
        $dbh->query('INSERT INTO ingredients (ingredient, quantity, unit)
          VALUES ("' . $ing . '", "' . $quan . '", "' . $unit . '"); ');
      
        $dbh->query('INSERT INTO recipe_ingredients (recipe_id)
        VALUES ("' . $count . '");'); 
      }
      $count++;

    }

  }
}

// Seeder::createTables();
Seeder::addToDatabase();