<?php

// initializing variables
$user_name = "";
$email    = "";
$errors = array();
$dsn = 'mysql:host=db;dbname=naturalHRTest;';
// connect to the database
//$db = mysqli_connect("db", "admin", "hg567", "naturalHRTest");

 try {
     $db = new PDO($dsn, "admin", "hg567");
 } catch (\Exception $e) {
     var_dump($e);
 }