<?php
require_once('Auth/auth.php');
// Read the JSON file
$recipesJson = file_get_contents('./recipe/recipes.json');
$recipes = json_decode($recipesJson, true);
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Welcome - Tasty Recipes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        h1 {
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="header-area">
            <div id="sticky-header" class="main-header-area">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- Logo Section -->
                        <div class="col-xl-3 col-lg-2">
                            <div class="logo">
                                <a href="index.php">
                                   <img src="./img/logo.png" alt="Logo" style="max-width: 20%; height: auto; display: inline-block;">
                                </a>
                            </div>
                        </div>
                        <!-- Title Section -->
                        <div class="col-xl-6 col-lg-7 text-center">
                        </div>
                        <div class="col-xl-3 col-lg-3 d-none d-lg-block">
                            <div class="search_icon">
                                <!-- Optional: Add search bar or additional content here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Welcome Section -->
    <div class="container mt-5">
        <?php
        if (isLoggedIn()) {
            ?>
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h1 class="display-4">Welcome to Tasty Recipes!</h1>
                    <p class="lead">Explore delicious recipes and more!</p>
                    <a href="./Auth/signout.php" class="btn btn-danger mt-4">Sign Out</a>
                    <a href="recipe/create.php" class="btn btn-danger mt-4">Create New Recipe</a>
                    <a href="cookbook.php" class="btn btn-danger mt-4">View Cookbook</a>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h1 class="display-4">Welcome to Tasty Recipes!</h1>
                    <p class="lead">Explore delicious recipes and more!</p>
                    <a href="./Auth/index.php" class="btn btn-danger mt-4">Sign In</a>
                </div>
            </div>
            <?php
        }
        ?>
        <!-- Recipe Cards Section -->
        <div class="row mt-5">
            <?php foreach ($recipes as $recipe): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img class="card-img-top" src="<?php echo isset($recipe['image']) ? './img/' . $recipe['image'] : '../img/placeholder.png'; ?>" alt="<?php echo $recipe['title']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $recipe['title']; ?></h5>
                        <p class="card-text">
                            <strong>Cooking Time:</strong> <?php echo $recipe['cooking_time']; ?><br>
                            <strong>Category:</strong> <?php echo $recipe['category']; ?>
                        </p>
                        <a href="./recipe/detail.php?id=<?php echo $recipe['id']; ?>" class="btn btn-primary">See More</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="./js/vendor/jquery-1.12.4.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</body>
</html>
