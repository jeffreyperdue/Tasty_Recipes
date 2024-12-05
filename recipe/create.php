<?php
session_start();
require_once('../auth/db.php'); 

if (!isset($_SESSION['user_ID'])) {
    header('Location: ../auth/index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $imagePath = '../img/No_Image_Available.jpg'; 
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../img/';
            $imagePath = $uploadDir . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            $imagePath = basename($_FILES['image']['name']); 
        }

        $stmt = $db->prepare("
            INSERT INTO recipes (user_ID, title, ingredients, instructions, cooking_time, category, image)
            VALUES (:user_ID, :title, :ingredients, :instructions, :cooking_time, :category, :image)
        ");
        $stmt->execute([
            ':user_ID' => $_SESSION['user_ID'], 
            ':title' => $_POST['title'],
            ':ingredients' => implode("\n", $_POST['ingredients']), // Combine ingredients into a single string
            ':instructions' => $_POST['instructions'],
            ':cooking_time' => $_POST['cooking_time'],
            ':category' => $_POST['category'],
            ':image' => $imagePath
        ]);

        header('Location: ../index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error creating recipe: " . htmlspecialchars($e->getMessage());
        exit();
    }
} else {
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
    <form method="POST" enctype="multipart/form-data" action="" class="mx-auto" style="max-width: 600px;">
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
