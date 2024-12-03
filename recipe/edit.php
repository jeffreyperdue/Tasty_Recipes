<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: signup.php');
  exit();
}

$recipesJson = file_get_contents('recipes.json');
$recipes = json_decode($recipesJson, true);
if (count($_POST)>0){
  for ($i =0; $i<count($recipes); $i++){
    if($recipes[$i]['id'] == $_GET['id']){
      $item = $_POST;
      $recipes[$i]['id'] = $recipes[$i]['id'];
      $recipes[$i]['title'] = $item['title'];
      $recipes[$i]['ingredients'] = $item['ingredients'];
      $recipes[$i]['instructions'] = $item['instructions'];
      $recipes[$i]['cooking_time'] = $item['cooking_time'];
      $recipes[$i]['category'] = $item['category'];
      $recipes[$i]['image'] = $recipes[$i]['image'];
      $recipes[$i]['owner'] = $recipes[$i]['owner'];
    }
  }
    $recipes = json_encode($recipes, JSON_PRETTY_PRINT);
    file_put_contents('recipes.json', $recipes);
    header('location: ../index.php');
} else{
    $recipeId = $_GET['id'];
    foreach ($recipes as $recipe) {
      if ($recipe['id'] == $recipeId) {
        $currentRecipe = $recipe;
        break;
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
            <?php foreach ($currentRecipe['ingredients'] as $ingredient): ?>
                <input name="ingredients[]" type="text" class="form-control mb-2" value="<?= $ingredient ?>" required>
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
}
?>
