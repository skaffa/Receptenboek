<?php declare(strict_types=1);

require_once(__DIR__ . '/../Controllers/RecipeController.php');

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
$recipe = RecipeController::getRecipeById(13);

$template = file_get_contents(__DIR__.'/../Templates/Recipe.html');
echo str_replace($replace, $recipe, $template);