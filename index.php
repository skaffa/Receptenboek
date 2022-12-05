<?php
require_once('./Controllers/RecipeController.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Receptenboek</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="assets/css/index.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/header.css">
        <script src="./assets/scripts/index.js" defer></script>
    </head>
    <body>
        <?php include_once('assets/php/header.php') ?>
        <div id="container">
            <div id="intro">
                <div id="intro-text">
                    <div>Inspiratie nodig?</div>
                    <div>kies hieronder uit een van onze heerlijke recepten!</div>
                </div>
            </div>
            <div id="recipes-preview">
                <?php 
                    $items = RecipeController::getHomeItemColumns();
                    foreach($items as $item){
                        var_dump($item);
                    }
                ?>
            </div>
        </div>
    </body>
</html>