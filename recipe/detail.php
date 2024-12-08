<?php
require_once('../auth/db.php'); 
session_start();

// Add to cookbook logic
if (isset($_POST['add_to_cookbook'])) {
    if (!isset($_SESSION['user_ID'])) {
        echo "You must be logged in to add recipes to your cookbook.";
        exit;
    }

    $user_id = $_SESSION['user_ID'];
    $user_role = $_SESSION['role'];
    $recipe_id = intval($_GET['id']);
    

    try {
        // Fetch the recipe owner to ensure it's not the user's own recipe
        $stmt = $db->prepare("SELECT user_ID FROM recipes WHERE recipe_ID = :recipe_id");
        $stmt->execute([':recipe_id' => $recipe_id]);
        $recipeOwner = $stmt->fetchColumn();

        if ($recipeOwner == $user_id) {
            ?>
                <div class="alert alert-info text-center" role="alert">You cannot add your own recipe to your cookbook.
                </div><?php
            
        }

        else {
            // Check if the recipe is already in the user's cookbook
            $checkStmt = $db->prepare("SELECT * FROM cookbook WHERE user_ID = :user_id AND recipe_ID = :recipe_id");
            $checkStmt->execute([':user_id' => $user_id, ':recipe_id' => $recipe_id]);

            if ($checkStmt->rowCount() > 0) {?>
                <div class="alert alert-info text-center" role="alert">This recipe is already in your cookbook.
                </div><?php
                
            } else {
                // Add recipe to the cookbook table
                $insertStmt = $db->prepare("INSERT INTO cookbook (user_ID, recipe_ID) VALUES (:user_id, :recipe_id)");
                $insertStmt->execute([':user_id' => $user_id, ':recipe_id' => $recipe_id]);

                ?>
                <div class="alert alert-info text-center" role="alert">Recipe added to your cookbook!
                </div><?php 
                
            }
        } 
    } catch (PDOException $e) {
        echo "Error adding recipe to cookbook: " . htmlspecialchars($e->getMessage());
    }
}

// Fetch recipe details
if (isset($_GET['id'])) {
    $recipe_id = intval($_GET['id']); 

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

// Determine if the user can edit/delete the recipe
$canEditDelete = false;
if (isset($_SESSION['user_ID']) && isset($_SESSION['role'])) {
    $logged_in_user_id = $_SESSION['user_ID'];
    $user_role = $_SESSION['role'];

    if ($user_role == 2) {
        // Admin can edit/delete all recipes
        $canEditDelete = true;
    } elseif ($user_role == 1 && $logged_in_user_id == $recipe['user_ID']) {
        // User can edit/delete their own recipes
        $canEditDelete = true;
    }
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
        <!-- Show the "Sign Out" button only if the user is logged in -->
        <?php if (isset($_SESSION['user_ID'])): ?>
            <a href="../Auth/signout.php" class="btn btn-danger mt-4">Sign Out</a>
            <a href="../cookbook.php" class="btn btn-danger mt-4">View Cookbook</a>
        <?php endif; ?>

        <!-- Edit/Delete Buttons -->
        <?php if ($canEditDelete): ?>
            <a href="edit.php?id=<?php echo htmlspecialchars($recipe['recipe_ID']); ?>" class="btn btn-danger mt-4">Edit Recipe</a>
            <a href="delete.php?id=<?php echo htmlspecialchars($recipe['recipe_ID']); ?>" class="btn btn-danger mt-4">Delete Recipe</a>
        <?php endif; ?>
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

                    <!-- Add to Cookbook Button -->
                    <?php if (isset($_SESSION['user_ID'])): ?>
                        <form method="POST" action="detail.php?id=<?php echo htmlspecialchars($recipe['recipe_ID']); ?>">
                        <button type="submit" name="add_to_cookbook" class="btn btn-primary mt-4">Add to Cookbook</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS Scripts -->
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>