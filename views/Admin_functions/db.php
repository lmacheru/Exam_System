<?php

$username = 'root';
$password = '4F#!IWi0DlA#yv!4';
try{
$connection = new PDO( 'mysql:host=localhost;dbname=exammanagementsystem', $username, $password );
   
} catch (PDOException $ex) {
    $msg = $ex->getMessage();
    exit();
}
?>