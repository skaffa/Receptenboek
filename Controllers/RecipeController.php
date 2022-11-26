<?php declare(strict_types=1);
namespace Controllers;

use Models\Recipe;
require_once('../Models/Recipe.php');

class RecipeController {
    public static function getRecipeById(int $id) {
        $recipe = Recipe::getRecipeById($id);
        $replace = [];
        foreach($recipe[0] as $key => $value) {
            
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