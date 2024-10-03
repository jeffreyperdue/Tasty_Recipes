<?php
    
session_start();

//check if user is logged on
function isLoggedIn(){
    return isset($_SESSION['email']);
}


//check if email and password is complete
function completeFields(){
    if(!isset($_POST['email'][0])) $error='You must enter your email';
    if(!isset($_POST['[password]'][0])) $error='You must enter your password';
}

//check if email and password is correct
function correctFields(){
    if(!filter_var(trim($_POST['email']),FILTER_VALIDATE_EMAIL)) $error='you must enter a valid email';
    if(strlen($_POST['password'])<8 || strlen($_POST['password'])>16){
        $error='you must enter a password between 8 and 16 characters long';
    }
}

//check to see if user exists on sign in page
function checkUser(){
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
}




?>