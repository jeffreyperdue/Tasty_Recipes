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

//check for user in csv
function findUser(){

}




?>