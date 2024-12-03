<?php

$host='localhost';
$dbname='tasty recipes';
$user='root';
$pass='';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8mb4', $user, $pass,$options); //connect once per every request
//avoid creating new connections