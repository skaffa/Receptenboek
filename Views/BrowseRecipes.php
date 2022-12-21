<?php 
require_once(__DIR__ . "/../Controllers/RecipeController.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/index.css" />
    <link rel="stylesheet" href="../assets/css/browse.css"  />
    <link rel="stylesheet" href="../assets/css/header.css" />
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
    <header>
        <h1>overzicht recepten!</h1>
        <p>Vind hier de lekkerste recepten</p>
    </header>   
    <main>
        <section>
            <?php
                $start = isset($_GET['page']) && $_GET['page'] > 2 ? 
                    $_GET['page'] - 1 : 1;
                $recipes = RecipeController::getPaginationItems($start);

                foreach($recipes as $recipe) {
                    $imgSrc = "../Utilities/AlbertHeijn/RecipeRipper/output/images/" . $recipe['imageLink'];
                    ?>
                    <div>
                        <a href="./Recipe.php?recipeId=<?php echo $recipe["id"] ?>">
                            <img src="<?php echo $imgSrc ?>" alt="" />
                            <ul>
                                <li><img src="../assets/img/clock.svg"
                                        alt="" />
                                    <?php echo preg_filter('/bereiden/', '', $recipe['preptime']);?>
                                </li>
                                <li>
                                    <img src="../assets/img/calorie.svg" 
                                        alt="" />
                                    <?php echo preg_filter('/[^\d]/', '', $recipe['calories']);?>
                                </li>
                                <li>
                                    <img src="../assets/img/persons.svg" 
                                        alt="" />
                                    <?php echo preg_filter('/[^\d]/', '', $recipe['portions']);?>
                                </li>
                            </ul>
                        </a>
                    </div>
            <?php
                }
            ?>
        </section>
        <section id="pagination">
            <div>
                <ul>
                <?php
                    $limit = 40;
                    
                    $page = $_GET['page'] ?? 1;
                    
                    $totalPages = $start + 10;
                    if ($page > 1) {
                        echo '<li id="previous"><a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span></a></li>';
                    }
                    for($i = $start; $i < $totalPages; $i++) {
                        $num = $i;
                        if ($num == $page) {
                            echo '<li class="currentpage"><a href="' . "?page=${num}\">
                            ${num}</a></li>";
                        } else {
                            echo '<li><a href="' . "?page=${num}\">
                                    ${num}</a></li>";
                        }
                    }
                    if ($page < $totalPages){
                        echo '<li id="next"><a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span></a></li>';
                    }
                ?>
                </ul>
            </div>
        </section>
    </main>
<script>
window.addEventListener('load', () => {
    const prevBtn = document.getElementById('previous');
    const nextBtn = document.getElementById('next');
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            let page = <?php echo $page; ?> + 1;
            window.location.href = `?page=${page}`;
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            let page = <?php echo $page; ?> - 1 ;
            window.location.href = `?page=${page}`;
        });
    }
});
</script>
</body>
</html>