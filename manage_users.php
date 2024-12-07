<?php
require_once('auth/db.php');
session_start();

// Check if the user is an admin
if (!isset($_SESSION['user_ID']) || $_SESSION['role'] != 2) {
    header('Location: index.php');
    exit();
}

// Fetch all users from the database
try {
    $stmt = $db->query("SELECT user_ID, email, firstname, lastname, role FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching users: " . htmlspecialchars($e->getMessage());
    exit();
}

// Handle form submission to save changes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_changes'])) {
    foreach ($_POST['roles'] as $userID => $newRole) {
        try {
            $stmt = $db->prepare("UPDATE users SET role = :role WHERE user_ID = :user_id");
            $stmt->execute([
                ':role' => $newRole,
                ':user_id' => $userID,
            ]);
        } catch (PDOException $e) {
            echo "Error updating user role: " . htmlspecialchars($e->getMessage());
        }
    }
    // Redirect to the same page to reflect changes
    header('Location: manage_users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        h1 {
            margin-top: 100px;
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
                        <?php if (isset($_SESSION['user_ID'])): ?>
                            <div class="col-xl-9 col-lg-10 text-right">
                                <div class="greeting-message">
                                    <h5 class="text-right">Hello, Admin</h5>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Manage Users Section -->
    <div class="container mt-5">
        <h1 class="display-4 text-center">Manage Users</h1>

        <form method="POST" action="">
            <table class="table table-striped table-bordered mt-4">
                <thead class="thead-dark">
                    <tr>
                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                            <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                            <td>
                                <select name="roles[<?php echo $user['user_ID']; ?>]" class="form-select">
                                    <option value="0" <?php echo $user['role'] == 0 ? 'selected' : ''; ?>>Guest</option>
                                    <option value="1" <?php echo $user['role'] == 1 ? 'selected' : ''; ?>>User</option>
                                    <option value="2" <?php echo $user['role'] == 2 ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-center mt-4">
                <button type="submit" name="save_changes" class="btn btn-success">Save Changes</button>
                <a href="manage_users.php" class="btn btn-secondary">Discard Changes</a>
            </div>
        </form>
    </div>

    <!-- JS Scripts -->
    <script src="./js/bootstrap.bundle.min.js"></script>
</body>
</html>
