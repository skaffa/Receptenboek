<?php declare(strict_types=1);

require_once(__DIR__ . '/../Controllers/RecipeController.php');

$id = (int) $_GET['recipeId'];

$replace = [
    '{recipeId}',
    '{recipePageTitle}',
    '{recipeTitle}',
    '{recipeSubTitle}',
    '{imageLink}',
    '{calories}',
    '{prepTime}',
    '{bakeTime}',
    '{portions}',
    '{necessary}',
    '{preparation}',
    '{nutrition}',
    '{dateAdded}',
    '{ingredients}'
];

// get Recipe
$recipe = RecipeController::getRecipeById($id);

$template = file_get_contents(__DIR__.'/../Templates/Recipe.html');
echo str_replace($replace, $recipe, $template);