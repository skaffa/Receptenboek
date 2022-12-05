<?php declare(strict_types=1);

require_once(__DIR__ . '/RecipeController.php');

function fetchItems() {
    $data = RecipeController::getHomeItemColumns();
    
    return json_encode($data);
}

return fetchItems();

