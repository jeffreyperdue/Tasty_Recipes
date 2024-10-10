<?php 
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: signup.php');
  exit();
}

$recipesJson = file_get_contents('recipes.json');
$recipes = json_decode($recipesJson, true);

for ($i =0; $i<count($recipes); $i++){
    if($recipes[$i]['id'] == $_GET['id']){
        unset($recipes[$i]);
    }
}
$recipes=array_values($recipes);
$recipes = json_encode($recipes, JSON_PRETTY_PRINT);
file_put_contents('recipes.json', $recipes);
header('location: index.php');



?>
