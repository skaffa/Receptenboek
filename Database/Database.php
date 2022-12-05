<?php declare(strict_types=1);

require_once(__DIR__ . '/../Config/DotEnv.php');
(new DotEnv(__DIR__ . '/../.env'))->load();

class Database {
  static function connectToDB() {
    $dbh = new PDO("mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME'), 
      getenv('DB_USER'), getenv('DB_PASS'));
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $dbh;
  }

  public static function getRow(int $id) : object {
    $dbh = self::connectToDB();
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
  public static function homeItemColumns(array ...$ids) {
    $dbh = self::connectToDB();
    $whereIs = "WHERE ";
    $len = count($ids) - 1;

    for ($i = 0; $i <= $len; $i++) {
      $whereIs .= "id = $ids[$i]";
      if ($i < $len ) {
        $whereIs .= ' AND ';
      }
    }

    $stm = $dbh->query("SELECT imageLink, baketime, calories, portions, title
      FROM recipes WHERE id = '" . $whereIs .  "';");
  }
} 