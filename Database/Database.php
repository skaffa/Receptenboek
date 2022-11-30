<?php declare(strict_types=1);

require_once(__DIR__ . '/../Config/DotEnv.php');
(new DotEnv(__DIR__ . '/../.env'))->load();

class Database {

  public static function getRow($id) {
    $dbh = new PDO("mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME'), 
      getenv('DB_USER'), getenv('DB_PASS'));
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $stm = $dbh->query("SELECT *, (
      SELECT GROUP_CONCAT(ingredients.quantity, ' ', ingredients.unit, ' ', ingredients.ingredient)
        FROM recipe_ingredients 
        RIGHT JOIN ingredients ON recipe_ingredients.ingredient_id = ingredients.id
        WHERE recipe_ingredients.recipe_id = 1) AS ingredients
      FROM recipes 
      WHERE recipes.id = 1");
    
    $row = $stm->fetchObject();

    return $row;
  }
} 