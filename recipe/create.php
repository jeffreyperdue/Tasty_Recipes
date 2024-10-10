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
  header('location: index.php');
}
else{

?>
<html>
  <head>
<h1>Create New Recipe</h1>    
  </head>
  <body>
    <form method="POST" action="">
      <div>
        <label>Title</label> <br>
        <input name="title" type="text" required />
      </div>
      <br>
      <div>
        <label>Ingredients</label> <br>
        <input name="ingredients[]" type="text" required />
      </div>
      <br>
      <div>
        <label>Instruction</label> <br>
        <input name="instructions" type="text" maxLength="1000" required/>
      </div>
      <br>
      <div>
        <label>Cook Time (In minutes)</label> <br>
        <input name="cooking_time" type="text" required />
      </div>
      <br>
      <div>
        <label>Category</label> <br> <!--dropdown list-->
        <input name="category" type="text" required>
      </div>
      <br>
      <div>
        <label>Add image (optional)</label> <br>
        <input name="image" type="file" accept="image/png, image/jpeg" />
      </div>
      <br>
      <button type="submit">Post</button>
    </form>
  </body>
</html>
<?php } ?>

