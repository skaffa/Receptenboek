<?php declare(strict_types=1);

require_once(__DIR__  . '/../Models/Recipe.php');

class RecipeController {
    public static function getRecipeById(int $id) {
        $recipe = Recipe::getRecipeById($id);
       
        $replace = [];
        $recipe->ingredients = explode(',', $recipe->ingredients);
        $recipe->necessary = explode(',', $recipe->necessary);
        $recipe->preparation = explode('.,', $recipe->preparation);
        $recipe->nutrition = explode(',', $recipe->nutrition);
        foreach($recipe as $key => $value) {
            
            if (is_array($value)){
                $str = '';
                foreach($value as $k => $v) {
                    $str .= "<li>$v</li>";
                }
                $replace[$key] = $str;
            } else {
                $replace[$key] = $value;
            }
        }
       
        return $replace;
    }
}