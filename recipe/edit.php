<?php

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
    header('location: index.php');
} else{
    $recipeId = $_GET['id'];
    foreach ($recipes as $recipe) {
      if ($recipe['id'] == $recipeId) {
        $currentRecipe = $recipe;
        break;
      }
    }

?>

<h1>Edit Recipe</h1>
<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>?id=<?=$_GET['id']?>">
      <div>
        <label>Title</label> <br>
        <input name="title" type="text" value="<?= $currentRecipe['title'] ?>" required />
      </div>
      <br>
      <div>
        <label>Ingredients</label> <br>
        <?php foreach ($currentRecipe['ingredients'] as $ingredient) { ?>
          <input name="ingredients[]" type="text" value="<?= $ingredient ?>" required /> <br>
        <?php } ?>
      </div>
      <br>
      <div>
        <label>Instruction</label> <br>
        <input name="instructions" type="text" value="<?= $currentRecipe['instructions'] ?>" maxLength="1000" required/>
      </div>
      <br>
      <div>
        <label>Cook Time (In minutes)</label> <br>
        <input name="cooking_time" type="text" value="<?= $currentRecipe['cooking_time'] ?>" required />
      </div>
      <br>
      <div>
        <label>Category</label> <br> <!--dropdown list-->
        <input name="category" type="text" value="<?= $currentRecipe['category'] ?>" required>
      </div>
      <br>
      <div>
        <label>Add image (optional)</label> <br>
        <input name="image" type="file"  accept="image/png, image/jpeg" />
      </div>
      <br>
      <button type="submit">Update Information</button>
    </form>
<?php
}
?>
