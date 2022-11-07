<?php


function get_all_student_records()
{
	include('../Admin_functions/db.php');
	$statement = $connection->prepare("SELECT * FROM studentinfo");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}


?>