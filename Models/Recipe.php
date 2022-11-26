<?php declare(strict_types=1);
namespace Models;

class Recipe {
    public static function getRecipeById(int $id) : array {
        // database call
        $file = file_get_contents(__DIR__."/../Database/Recipes.json");
        return json_decode($file);
    }
}