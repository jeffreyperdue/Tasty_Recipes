<?php
require_once('Auth/auth.php');
require_once('Auth/db.php');

// Fetch user's first and last name if logged in
$greetingMessage = '';
if (isLoggedIn()) {
    $user_id = $_SESSION['user_ID'];
    try {
        $stmt = $db->prepare("SELECT firstname, lastname FROM users WHERE user_ID = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $greetingMessage = "Hello, " . htmlspecialchars($user['firstname'] . ' ' . $user['lastname']);
        }
    } catch (PDOException $e) {
        echo "Error fetching user details: " . htmlspecialchars($e->getMessage());
        exit();
    }
}

// Read recipes from database
try {
    $stmt = $db->query("SELECT * FROM recipes");
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching recipes: " . htmlspecialchars($e->getMessage());
    exit;
}
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Welcome - Tasty Recipes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        h1 {
            margin-top: 100px;
        }
        .greeting-message {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 1rem;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
    <div class="header-area">
        <div id="sticky-header" class="main-header-area">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Logo Section -->
                    <div class="col-xl-3 col-lg-2">
                        <div class="logo">
                            <a href="index.php">
                                <img src="./img/logo.png" alt="Logo" style="max-width: 20%; height: auto; display: inline-block;">
                            </a>
                        </div>
                    </div>
                    <!-- Greeting Section -->
                    <?php if (!empty($greetingMessage)): ?>
                        <div class="col-xl-9 col-lg-10 text-right">
                            <div class="greeting-message">
                                <?php echo $greetingMessage; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>

    <!-- Welcome Section -->
    <div class="container mt-5">
        <?php if (isLoggedIn()): ?>
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h1 class="display-4">Welcome to Tasty Recipes!</h1>
                    <p class="lead">Explore delicious recipes and more!</p>
                    <a href="./Auth/signout.php" class="btn btn-danger mt-4">Sign Out</a>
                    <a href="recipe/create.php" class="btn btn-danger mt-4">Create New Recipe</a>
                    <a href="cookbook.php" class="btn btn-danger mt-4">View Cookbook</a>
                    <a href="my_recipes.php" class="btn btn-danger mt-4">My Recipes</a>
                </div>
            </div>
        <?php else: ?>
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h1 class="display-4">Welcome to Tasty Recipes!</h1>
                    <p class="lead">Explore delicious recipes and more!</p>
                    <a href="./Auth/index.php" class="btn btn-danger mt-4">Sign In</a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Recipe Cards Section -->
        <div class="row mt-5">
            <?php foreach ($recipes as $recipe): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img class="card-img-top" src="./img/<?php echo !empty($recipe['image']) && file_exists('./img/' . $recipe['image']) ? $recipe['image'] : 'placeholder.png'; ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($recipe['title']); ?></h5>
                            <p class="card-text">
                                <strong>Cooking Time:</strong> <?php echo htmlspecialchars($recipe['cooking_time']); ?><br>
                                <strong>Category:</strong> <?php echo htmlspecialchars($recipe['category']); ?>
                            </p>
                            <a href="recipe/detail.php?id=<?php echo $recipe['recipe_ID']; ?>" class="btn btn-primary">See More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="./js/vendor/jquery-1.12.4.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</body>
</html>
