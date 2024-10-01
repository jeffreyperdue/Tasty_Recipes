<?php 
require_once('Auth/auth.php');
$error='';
//if logged in, send to index.php in entity folder
if(isLoggedIn()){
    header('location: recipe/index.php');
    die();
}

//check to see if form has been submitted with values
if(count($_POST)>0){
    
    completeFields();
    correctFields();

    //check for login credentials in csv file
    if(strlen($error)==0){
        $fp=fopen('users.csv.php','r');
        while(!feof($fp)){
            $line=fgets($fp);
            $line=explode(';', $line);
        
            if(count($line)==2 && $_POST['email']==$line[0] && password_verify($_POST['password'],trim($line[1]))){
                fclose($fp);
                $_SESSION['email']=$line[0];
                header('location: recipe/index.php');
                die();
            }
        }
        fclose($fp);
        $error='user doesn\'t exist. please create an account';
    }
}

?>

<html>
    <head>
</head>
<body>
    <?php 
        if(strlen($error)>0) echo $error;
    ?>
    <h1>Signin to Website</h1>
    <form method="POST">
        <label>Email</label><br />
        <input name='email' type="email" required />
        <br /><br />
        <label>Password</label><br />
        <input name='password' type="password" required/>
        <br /><br />
        <button type="submit">Sign In</button>
        <br /><br />
        <a href="Auth/signup.php">New to the site? Create an account here.</a>
</form>
</body>
</html>