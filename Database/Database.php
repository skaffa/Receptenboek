<?php declare(strict_types=1);

require_once(__DIR__ . '/../Config/DotEnv.php');
(new DotEnv(__DIR__ . '/../.env'))->load();

class Database {
  static function setUpDB() {
    $dbh = new PDO("mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME'), 
      getenv('DB_USER'), getenv('DB_PASS'));
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $dbh;
  }

  public static function getRow(int $id) : object {
    $dbh = self::setUpDB();
    $stm = $dbh->query("SELECT *, (
      SELECT GROUP_CONCAT(ingredients.quantity, ' ', ingredients.unit, ' ', ingredients.ingredient)
        FROM recipe_ingredients 
        RIGHT JOIN ingredients ON recipe_ingredients.ingredient_id = ingredients.id
        WHERE recipe_ingredients.recipe_id = $id) AS ingredients
      FROM recipes 
      WHERE recipes.id = $id");
    
    $row = $stm->fetchObject();

    return $row;
  }

  // image, baketime, calories, portions, title
  // static function getColums
  public static function homeItemColumns(array ...$id) {
    $dbh = self::setUpDB();
    $stm = $dbh->query("SELECT imageLink, baketime, calories, portions, title
      FROM recipes WHERE id =  ");
  }

  public static function addToDatabase() {
    $dbh = Database::setUpDb();

    foreach (glob(__DIR__ . "/*.json") as $file) {
      $count = 1;
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
          $f->nutrition ."');");

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
    $count++;
  }

} 

Database::addToDatabase();