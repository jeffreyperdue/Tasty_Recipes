<?php 
//member home page
require_once('auth.php');
$error='';

// if logged in, redirect to recipe index
if (isLoggedIn()) {
    header('location: ../index.php');
    die();
}

// check if form is submitted
if (count($_POST) > 0) {
    completeFields();
    correctFields();

    //check for login credentials in csv file
    if(strlen($error)==0){
       $fp=fopen('../users.csv.php','r');
        while(!feof($fp)){                  //while end of file hasn't been reached
            $line=fgets($fp);               //read a line and set it to variable $line
            $line=explode(';', $line);      //splits string into array using ; as delimiter
        
            //if email is found and password is correct, sign in, redirect to recipe index
            if(count($line)==2 && $_POST['email']==$line[0] && password_verify($_POST['password'],trim($line[1]))){
                fclose($fp);
                $_SESSION['email']=$line[0];
                header('location: ../index.php');
                die();
            }
            $error='user doesn\'t exist. please create an account';
        }
        fclose($fp);
        
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
    <!-- Header -->
    <header>
        <div class="header-area">
            <div id="sticky-header" class="main-header-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-2">
                            <div class="logo">
                                <a href="index.php">
                                    <img src="../img/logo.png" alt="Logo">
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
