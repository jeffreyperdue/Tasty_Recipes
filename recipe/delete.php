<?php 

$recipesJson = file_get_contents('recipes.json');
$recipes = json_decode($recipesJson, true);

unset($recipes[$_GET['id']]);
$recipes=array_values($recipes);
$recipes = json_encode($recipes, JSON_PRETTY_PRINT);
file_put_contents('recipes.json', $recipes);



?>

<h1>Delete Recipe</h1>
