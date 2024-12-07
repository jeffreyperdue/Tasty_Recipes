<?php
session_start();
require_once('../auth/db.php'); 

if (!isset($_SESSION['user_ID'])) {
    header('Location: ../auth/index.php');
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid Recipe ID.";
    exit();
}

$recipeId = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $db->prepare("UPDATE recipes SET title = :title, ingredients = :ingredients, instructions = :instructions, cooking_time = :cooking_time, category = :category WHERE recipe_ID = :recipe_id");
        $stmt->execute([
            ':title' => $_POST['title'],
            ':ingredients' => implode("\n", $_POST['ingredients']), 
            ':instructions' => $_POST['instructions'],
            ':cooking_time' => $_POST['cooking_time'],
            ':category' => $_POST['category'],
            ':recipe_id' => $recipeId
        ]);
        header('Location: ../index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error updating recipe: " . htmlspecialchars($e->getMessage());
        exit();
    }
} else {
    try {
        $stmt = $db->prepare("SELECT * FROM recipes WHERE recipe_ID = :recipe_id");
        $stmt->execute([':recipe_id' => $recipeId]);
        $currentRecipe = $stmt->fetch();

        if (!$currentRecipe) {
            echo "Recipe not found.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error fetching recipe: " . htmlspecialchars($e->getMessage());
        exit();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Recipe</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Edit Recipe</h1>
    <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>?id=<?= $recipeId ?>" class="mx-auto" style="max-width: 600px;">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input id="title" name="title" type="text" class="form-control" value="<?= $currentRecipe['title'] ?>" required>
        </div>
        <div class="mb-3">
          <label for="ingredients" class="form-label">Ingredients</label>
          <?php 
          $ingredientsArray = explode("\n", $currentRecipe['ingredients']);
          foreach ($ingredientsArray as $ingredient): ?>
            <input name="ingredients[]" type="text" class="form-control mb-2" value="<?= htmlspecialchars($ingredient) ?>" required>
          <?php endforeach; ?>
        </div>

        <div class="mb-3">
            <label for="instructions" class="form-label">Instructions</label>
            <textarea id="instructions" name="instructions" class="form-control" rows="5" required><?= $currentRecipe['instructions'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="cooking_time" class="form-label">Cook Time (In minutes)</label>
            <input id="cooking_time" name="cooking_time" type="text" class="form-control" value="<?= $currentRecipe['cooking_time'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input id="category" name="category" type="text" class="form-control" value="<?= $currentRecipe['category'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Add Image (optional)</label>
            <input id="image" name="image" type="file" class="form-control" accept="image/png, image/jpeg">
        </div>
        <button type="submit" class="btn btn-primary w-100">Update</button>
    </form>
</div>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
<?php
?>
