<?php 
require_once('auth.php');
require_once('db.php');
$error='';

//if already logged in, send to entity index
if(isset($_SESSION['email'])){
    header('location: ../index.php');
    
}

//check to see if form has been submitted with values
if(count($_POST)>0){
    
    completeFields();
    if(!isset($_POST['password_confirm'][0])) $error='You must enter your password';
    correctFields();
    if($_POST['password'] != $_POST['password_confirm']) $error='passwords must match';

    $query=$db->prepare('INSERT INTO users(email,password,firstname,lastname,role) VALUES(?,?,?,?,?)');
    $query->execute([$_POST['email'],$_POST['password'],$_POST['firstname'],$_POST['lastname'],1]);

    header('location: ../index.php');

}

?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Tasty Recipes - Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Header -->
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
                        <h3 class="card-title text-center">Sign Up for Tasty Recipes</h3>
                        <!-- Display error message if any -->
                        <?php if (strlen($error) > 0): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" name="firstname" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" name="lastname" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="password">Confirm Password</label>
                                <input type="password" name='password_confirm' class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 w-100">Sign Up</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="index.php">Already have an account? Click here to sign in!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="../js/vendor/jquery-1.12.4.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>








   



