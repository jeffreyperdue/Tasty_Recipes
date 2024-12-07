<?php
session_start();
require_once('auth/db.php');

// Check if user is logged in
if (!isset($_SESSION['user_ID'])) {
    header('Location: auth/index.php');
    exit();
}

$user_id = $_SESSION['user_ID'];
$greetingMessage = '';

try {
    // Fetch user details
    $stmt = $db->prepare("SELECT firstname, lastname FROM users WHERE user_ID = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $greetingMessage = htmlspecialchars($user['firstname'] . ' ' . $user['lastname']);
    }

    // Fetch recipes that user owns
    $stmt = $db->prepare("
        SELECT *
        FROM recipes
        WHERE user_ID = :user_id
    ");
    $stmt->execute([':user_id' => $user_id]);
    $recipes = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
    exit();
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <title><?php echo $greetingMessage; ?>'s Recipes</title>
    <style>
        .header-area {
            margin-bottom: 20px;
        }
        .header-logo {
            max-width: 50px;
            height: auto;
        }
        .greeting-message {
            margin-top: 20px;
            text-align: center;
        }
        .btn-container {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-area">
            <div class="container d-flex align-items-center justify-content-between">
                <!-- Logo -->
                <div class="logo">
                    <a href="index.php">
                        <img src="./img/logo.png" alt="Logo" class="header-logo">
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Greeting Section -->
    <div class="container">
        <div class="greeting-message">
            <h1 class="display-4"><?php echo $greetingMessage; ?>'s Recipes</h1>
        </div>

        <!-- Navigation Buttons -->
        <div class="btn-container">
            <a href="index.php" class="btn btn-danger">Home</a>
            <a href="auth/signout.php" class="btn btn-danger">Sign Out</a>
            <a href="recipe/create.php" class="btn btn-danger">Create New Recipe</a>
        </div>

        <!-- Cookbook Recipes -->
        <?php if (empty($recipes)): ?>
            <div class="alert alert-info text-center" role="alert">
                You haven't added any recipes. Creat one now!
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($recipes as $recipe): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img class="card-img-top" src="./img/<?php echo !empty($recipe['image']) && file_exists('./img/' . $recipe['image']) ? $recipe['image'] : 'placeholder.png'; ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($recipe['title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($recipe['category']); ?></p>
                                <a href="recipe/detail.php?id=<?php echo $recipe['recipe_ID']; ?>" class="btn btn-primary">View Recipe</a>
                                
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="./js/bootstrap.bundle.min.js"></script>
</body>
</html>
