<?php
require_once('../auth/db.php'); 

if (isset($_GET['id'])) {
    $recipe_id = intval($_GET['id']); // Ensure ID is an integer

    try {
        $stmt = $db->prepare("SELECT * FROM recipes WHERE recipe_ID = :recipe_id");
        $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $stmt->execute();
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$recipe) {
            echo "Recipe not found.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error fetching recipe: " . htmlspecialchars($e->getMessage());
        exit;
    }
} else {
    echo "No recipe ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Recipe Details - Tasty Recipes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        h1 {
            margin-top: 100px;
        }
    </style>
</head>
<body>

    <div class="col-xl-3 col-lg-2">
        <div class="logo">
            <a href="../index.php">
            <img src="../img/logo.png" alt="Logo" style="max-width: 20%; height: auto; display: inline-block;">
            </a>
        </div>
    </div>

<div class="container mt-5">
    <!-- Website Title -->
    <div class="text-center mb-5">
        <h1 class="display-4">Tasty Recipes</h1>
        <p class="lead">Explore delicious recipes in detail</p>
        <a href="../Auth/signout.php" class="btn btn-danger d-inline-block">Sign Out</a>
        <a href="edit.php?id=<?php echo htmlspecialchars($recipe['recipe_ID']); ?>" class="btn btn-danger d-inline-block">Edit Recipe</a>
        <a href="delete.php?id=<?php echo htmlspecialchars($recipe['recipe_ID']); ?>" class="btn btn-danger d-inline-block">Delete Recipe</a>
    </div>

    <!-- Recipe Card -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mb-4">
                <!-- Recipe Image -->
                <img class="card-img-top" src="<?php echo isset($recipe['image']) && file_exists('../img/' . $recipe['image']) ? '../img/' . $recipe['image'] : '../img/placeholder.png'; ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                <div class="card-body">
                    <!-- Recipe Title -->
                    <h2 class="card-title"><?php echo htmlspecialchars($recipe['title']); ?></h2>

                    <!-- Recipe Details -->
                    <p class="card-text">
                        <strong>Cooking Time:</strong> <?php echo htmlspecialchars($recipe['cooking_time']); ?><br>
                        <strong>Category:</strong> <?php echo htmlspecialchars($recipe['category']); ?><br>
                    </p>

                    <!-- Ingredients -->
                    <h5>Ingredients</h5>
                    <ul>
                        <?php 
                        $ingredients = explode("\n", $recipe['ingredients']);
                        foreach ($ingredients as $ingredient): ?>
                            <li><?php echo htmlspecialchars($ingredient); ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- Instructions -->
                    <h5>Instructions</h5>
                    <p><?php echo nl2br(htmlspecialchars($recipe['instructions'])); ?></p>

                    <!-- Back to Recipe List Button -->
                    <a href="../index.php" class="btn btn-primary mt-4">Back to Recipes</a>

                    <!-- Favorite Button -->
                    <a href="../index.php" class="btn btn-primary mt-4">Add to Cookbook</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS Scripts -->
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
