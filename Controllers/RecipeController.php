<?php declare(strict_types=1);

require_once(__DIR__  . '/../Models/Recipe.php');

class RecipeController {
    private $replace = [];

    private function setRecipeItems (object $recipe) : array {
        $recipe->ingredients = explode(',', $recipe->ingredients);
        $recipe->necessary = explode(',', $recipe->necessary);
        $recipe->preparation = explode('.,', $recipe->preparation);
        $recipe->nutrition = explode(',', $recipe->nutrition);
        $date = date_create($recipe->added);
        $recipe->added = date_format($date, 'd-m-Y');
        
        foreach($recipe as $key => $value) {
            
            if (is_array($value)){
                $str = '';
                foreach($value as $k => $v) {
                    if ($v == "") {
                        $str .= "<li>Geen baktijd</li>";
                    } else {
                        $str .= "<li>$v</li>";
                    }
                }
                $this->replace[$key] = $str;
            } else {
                $this->replace[$key] = $value;
            }
        }
        
        return $this->replace;
    }

    public static function getRecipeById(int $id) : array {
        $recipe = Recipe::getRecipeById($id);
        $replace = new RecipeController();
        
        return $replace->setRecipeItems($recipe);
    }

    public static function getHomeItemColumns () : array {
        $max = Recipe::getMaxId();
        $ids = [];

        for ( $i = 0; $i < 6; $i++) {
            array_push($ids, rand(1, $max));
        }

        return Recipe::getHomeItemColumns($ids);
    }

    public static function getPaginationItems(int $page) : array {
        return Recipe::getPaginationItems($page);
    }
}