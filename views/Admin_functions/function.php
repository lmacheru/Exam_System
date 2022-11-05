<?php


function get_total_all_records()
{
	include('db.php');
	$statement = $connection->prepare("SELECT * FROM staffinfo");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}
function get_total_Exam_records()
{
	include('db.php');
	$statement = $connection->prepare("SELECT * FROM examsession");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

?>