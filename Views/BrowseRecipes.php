<?php 
require_once(__DIR__ . "/../Controllers/RecipeController.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/browse.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/header.css" />
    <link rel="stylesheet" href="../assets/css/index.css" />
    <title>Document</title>
</head>
<body>
    <nav>
        <img src="../assets/img/logo.svg" width="55px" alt="logo" draggable="false">
        <div id="nav-buttons">
            <a href="/" draggable="false">Home</a>
            <a href="../Views/BrowseRecipes.php" draggable="false">Recepten</a>
        </div>
    </nav>
    <main>
        <section>
            <?php
                $recipes = RecipeController::getPaginationItems(1);

                foreach($recipes as $recipe) {
                    $imgSrc = "../Utilities/AlbertHeijn/RecipeRipper/output/images/" . $recipe['imageLink'];
                    ?>
                    <div>
                        <a href="./Recipe.php?recipeId=<?php echo $recipe["id"] ?>">
                            <img src="<?php echo $imgSrc ?>" alt="" />
                            <ul>
                                <li><?php echo $recipe['preptime'];?></li>
                                <li><?php echo $recipe['calories'];?></li>
                                <li><?php echo $recipe['portions'];?></li>
                            </ul>
                        </a>
                    </div>
            <?php
                }
            ?>
        </section>
        <section id="pagination">

        </section>
    </main>
</body>
</html>