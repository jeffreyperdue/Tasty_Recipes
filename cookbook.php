<?php
session_start();
require_once('auth/db.php');

if (!isset($_SESSION['user_ID'])) {
    header('Location: auth/index.php');
    exit();
}

$user_id = $_SESSION['user_ID'];

// Fetch user's first and last name
try {
    $stmt = $db->prepare("SELECT firstname, lastname FROM users WHERE user_ID = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found.";
        exit();
    }

    $user_full_name = htmlspecialchars($user['firstname'] . ' ' . $user['lastname']);
} catch (PDOException $e) {
    echo "Error fetching user details: " . htmlspecialchars($e->getMessage());
    exit();
}

// Handle "Remove from Cookbook" logic
if (isset($_POST['remove_from_cookbook'])) {
    $recipe_id = intval($_POST['recipe_id']);

    try {
        $stmt = $db->prepare("DELETE FROM cookbook WHERE user_ID = :user_id AND recipe_ID = :recipe_id");
        $stmt->execute([
            ':user_id' => $user_id,
            ':recipe_id' => $recipe_id
        ]);
        header('Location: cookbook.php');
        exit();
    } catch (PDOException $e) {
        echo "Error removing recipe from cookbook: " . htmlspecialchars($e->getMessage());
        exit();
    }
}

// Fetch recipes in the user's cookbook
try {
    $stmt = $db->prepare("
        SELECT recipes.*
        FROM cookbook
        JOIN recipes ON cookbook.recipe_ID = recipes.recipe_ID
        WHERE cookbook.user_ID = :user_id
    ");
    $stmt->execute([':user_id' => $user_id]);
    $recipes = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error fetching cookbook: " . htmlspecialchars($e->getMessage());
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Your Cookbook</title>
</head>
<body>
<header class="bg-primary text-white p-3 mb-4">
    <div class="container">
        <h1 class="h3"><?php echo $user_full_name; ?>'s Cookbook</h1> <!-- Display user's name -->
        <nav class="nav">
            <a class="nav-link text-white" href="index.php">Home</a>
            <a class="nav-link text-white" href="auth/signout.php">Sign Out</a>
        </nav>
    </div>
</header>
<main class="container">
    <?php if (empty($recipes)): ?>
        <div class="alert alert-info" role="alert">
            You haven't added any recipes to your cookbook yet. Browse recipes and add your favorites!
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($recipes as $recipe): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img class="card-img-top" src="img/<?php echo htmlspecialchars($recipe['image']); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($recipe['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($recipe['category']); ?></p>
                            <a href="detail.php?id=<?php echo htmlspecialchars($recipe['recipe_ID']); ?>" class="btn btn-primary">View Recipe</a>
                            <form method="POST" action="cookbook.php">
                                <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipe['recipe_ID']); ?>">
                                <button type="submit" name="remove_from_cookbook" class="btn btn-danger mt-2">Remove from Cookbook</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
