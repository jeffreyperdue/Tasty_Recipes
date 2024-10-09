<?php

$recipesJson = file_get_contents('recipes.json');
$recipes = json_decode($recipesJson, true);
$item = $recipes[$_GET['id']];
if (count($_POST)>0){
    $item = $_POST;
    $recipes[$_GET['id']]=$item;
    $recipes = json_encode($recipes, JSON_PRETTY_PRINT);
    file_put_contents('recipes.json', $recipes);
    header('location: index.php');
}


?>

<h1>Edit Recipe</h1>
<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>?id=<?=$_GET['id']?>">
      <div>
        <label>Title</label> <br>
        <input name="title" type="text" value="<?= $item['title'] ?>" required />
      </div>
      <br>
      <div>
        <label>Ingredients</label> <br>
        <input name="ingredients" type="text" value="<?= $item['ingredients'] ?>" required />
      </div>
      <br>
      <div>
        <label>Instruction</label> <br>
        <input name="instructions" type="text" value="<?= $item['instructions'] ?>" maxLength="1000" required/>
      </div>
      <br>
      <div>
        <label>Cook Time (In minutes)</label> <br>
        <input name="cooking_time" type="text" value="<?= $item['cooking_time'] ?>" required />
      </div>
      <br>
      <div>
        <label>Category</label> <br> <!--dropdown list-->
        <input name="category" type="text" value="<?= $item['category'] ?>" required>
      </div>
      <br>
      <div>
        <label>Add image (optional)</label> <br>
        <input name="image" type="file" accept="image/png, image/jpeg" />
      </div>
      <br>
      <button type="submit">Update Information</button>
    </form>

