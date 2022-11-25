<?php declare(strict_types=1);
namespace Models;

class Recipe {
    public static function getRecipeById(int $id) : array {
        // database call
        return json_decode(file_get_contents(__DIR__."/../Database/Recipes.json"));
    }
}