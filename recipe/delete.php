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

try {
    $stmt = $db->prepare("DELETE FROM recipes WHERE recipe_ID = :recipe_id");
    $stmt->execute([':recipe_id' => $recipeId]);

    if ($stmt->rowCount() > 0) {
        header('Location: ../index.php');
        exit();
    } else {
        echo "Recipe not found or could not be deleted.";
    }
} catch (PDOException $e) {
    echo "Error deleting recipe: " . htmlspecialchars($e->getMessage());
    exit();
}
?>
