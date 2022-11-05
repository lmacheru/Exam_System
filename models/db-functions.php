<?php 

include("connection.php");

function get_all_students(){
    global $connect;
    $rows = $connect->query("SELECT * FROM studentinfo");
    return $rows;
}

function get_all_students_count(){
    global $connect;
    $rows = $connect->query("SELECT COUNT(*) AS 'count' FROM studentinfo")->fetchColumn();
    return $rows;
}

function get_number_student_Weekly_Submissions_for_modules(){
    global $connect;
    $rows = $connect->query("SELECT DISTINCT moduleCode, COUNT(moduleCode) AS 'NUM_STUDENTS' FROM examoutput where examDate >= '2022-11-01' and examDate <= '2022-11-28' GROUP BY moduleCode;
    ");
    return $rows;
}

function get_number_student_Submissions_for_modules(){
    global $connect;
	$CurrrentDate =date("Y-m-d");
    $rows = $connect->query("SELECT DISTINCT moduleCode, COUNT(moduleCode) AS 'Submissions' FROM examoutput where examDate ='$CurrrentDate'  GROUP BY moduleCode;");
    return $rows;
}

function get_total_number_submissions_for_all_module(){
    global $connect;
    $rows = $connect->query("SELECT COUNT(*) AS 'SUBMISSIONS' FROM examoutput;")->fetchColumn();
    return $rows;
}





$dsn = "mysql:host=localhost;dbname=exammanagementsystem";
$username = "root";
$password = "4F#!IWi0DlA#yv!4";

try {
    $connect = new PDO($dsn, $username, $password); // connects to the db
} catch (PDOException $ex) {
    $msg = $ex->getMessage();
    exit();
}


