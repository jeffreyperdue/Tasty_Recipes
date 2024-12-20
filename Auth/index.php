<?php 
//member home page
require_once('auth.php');
require_once('db.php');
$error='';

// if logged in, redirect to recipe index
if (isLoggedIn()) {
    header('location: ../index.php');
    
}

// check if form is submitted
if (count($_POST) > 0) {
    completeFields();
    correctFields();
    
    
    //check for login credentials in database
    $query = $db->prepare('SELECT * FROM users WHERE email=?');
    $query->execute([$_POST['email']]);

    if($query->rowCount()){
        $user=$query->fetch(PDO::FETCH_ASSOC);
        
        if (password_verify($_POST['password'], $user['password'])){
            
            $_SESSION['user_ID'] = $user['user_ID'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            header('location: ../index.php');       
            
        }
        else{
            
            ?>
                <div class="alert alert-info text-center" role="alert">
                   Wrong email or password!
                </div><?php 
        }
    }
    else{
        
            ?>
            <div class="alert alert-info text-center" role="alert">
                You don't have an account! Please create one!
            </div><?php
    }
    
}
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Tasty Recipes - Sign In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Header--> 
    <header>
        <div class="header-area">
            <div id="sticky-header" class="main-header-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-2">
                            <div class="logo">
                                <a href="../index.php">
                                <img src="../img/logo.png" alt="Logo" style="max-width: 20%; height: auto; display: inline-block;">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Login Section -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Sign In to Tasty Recipes</h3>
                        <!-- Display error message if any -->
                        <?php if (strlen($error) > 0): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 w-100">Sign In</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="signup.php">New to the site? Create an account here.</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
