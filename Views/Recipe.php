<?php declare(strict_types=1);
namespace Views;

use Controllers;
require_once('../Controllers/Recipe.php');

$replace = [
    '{recipePageTitle}',
    '{recipeTitle}',
    '{recipeSubTitle}',
    '{calories}',
    '{prepTime}',
    '{bakeTime}',
    '{portions}',
    '{ingredients}',
    '{necessary}',
    '{preparation}',
    '{nutrition}'
];

// get Recipe
$recipe = \Controllers\Recipe::getRecipeById(1);

$template = file_get_contents(__DIR__.'/../Templates/Recipe.html');
echo str_replace($replace, $recipe, $template);