<?php 

$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = "4F#!IWi0DlA#yv!4"; /* Password */
$dbname = "exammanagementsystem"; /* Database name */

$connect = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$connect) {
  die("Connection failed: " . mysqli_connect_error());
}

?>
