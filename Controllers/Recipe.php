<?php declare(strict_types=1);
namespace Controllers;

use Models;
require_once('../Models/Recipe.php');

class Recipe {
    public static function getRecipeById(int $id) {
        $recipe = \Models\Recipe::getRecipeById($id);

        foreach($recipe as $key => $value) {
            if (is_array($value)){
                $str = '';
                foreach($value as $k => $v) {
                    $str .= "<li>$v</li>";
                }
                $recipe[$key] = $str;
            }
        }

        return $recipe;
    }
}