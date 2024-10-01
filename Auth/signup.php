<?php 
require_once('auth.php');
$error='';

//if already logged in, send to entity index
if(isset($_SESSION['email'])){
    header('location: ../recipe/index.php');
    die();
}

//check to see if form has been submitted with values
if(count($_POST)>0){
    
    completeFields();
    if(!isset($_POST['password_confirm'][0])) $error='You must enter your password';
    correctFields();
    if($_POST['password'] != $_POST['password_confirm']) $error='passwords must match';

    if(strlen($error)==0){
        $fp=fopen('../users.csv.php','r');
        //check is user exists
        while(!feof($fp)){
            $line=fgets($fp);
            $line=explode(';', $line);
        
            //if user exists, display messgage and end script
            if(count($line)==2 && $_POST['email']==$line[0]){
                $error='The email is already registered';
                break;
            }  
        }
        fclose($fp);
        if(strlen($error)==0){
            //open csv in append mode
            $fp=fopen('../users.csv.php','a+');

            //write new credentials
            fputs($fp,$_POST['email'].';'.password_hash($_POST['password'],PASSWORD_DEFAULT).PHP_EOL);

            //close file
            fclose($fp);
            //redirect to main page
            header('location: ../recipe/index.php');
            die();
        }
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
    <h1>Sign Up</h1>
    <form method="POST">
        <label>Email</label><br />
        <input name='email' type="email" required />
        <br /><br />
        <label>Password</label><br />
        <input name='password' type="password" required/>
        <br /><br />
        <label>Confirm Password</label><br />
        <input name='password_confirm' type="password" required/>
        <br /><br />
        <button type="submit">Sign Up</button>
        <br /><br />
        <a href="../index.php">Already have an account? Click here to sign in!</a>
</form>
</body>
</html>



