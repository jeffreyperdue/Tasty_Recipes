<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: signup.php');
  exit();
}

if (count($_POST)>0){
  $recipesJson = file_get_contents('recipes.json');
  $recipes = json_decode($recipesJson, true);
  $nextId = count($recipes) + 1;
  $owner = 'Placeholder';
  if ($_POST['image'] == null){
    $_POST['image'] = '../img/No_Image_Available.jpg';
  }
  $newData = [
    'id' => $nextId,
    'title' => $_POST['title'],
    'ingredients' => $_POST['ingredients'],
    'instructions' => $_POST['instructions'],
    'cooking_time' => $_POST['cooking_time'],
    'category' => $_POST['category'],
    'image' => $_POST['image'],
    'owner' => $owner
  ];
  $recipes[]= $newData;
  $recipes = json_encode($recipes, JSON_PRETTY_PRINT);
  file_put_contents('recipes.json', $recipes);
  header('location: ../index.php');
}
else{

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create New Recipe</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Create New Recipe</h1>
    <form method="POST" action="" class="mx-auto" style="max-width: 600px;">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input id="title" name="title" type="text" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="ingredients" class="form-label">Ingredients</label>
            <textarea id="ingredients" name="ingredients[]" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="instructions" class="form-label">Instructions</label>
            <textarea id="instructions" name="instructions" class="form-control" rows="5" required></textarea>
        </div>
        <div class="mb-3">
            <label for="cooking_time" class="form-label">Cook Time (In minutes)</label>
            <input id="cooking_time" name="cooking_time" type="text" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input id="category" name="category" type="text" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Add Image (optional)</label>
            <input id="image" name="image" type="file" class="form-control" accept="image/png, image/jpeg">
        </div>
        <button type="submit" class="btn btn-primary w-100">Post</button>
    </form>
</div>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>

