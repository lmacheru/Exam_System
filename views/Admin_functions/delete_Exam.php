<?php

include('db.php');
include("function.php");

if(isset($_POST["Exam_id"]))
{
	$statement = $connection->prepare(
		"DELETE FROM examsession WHERE Id = :id"
	);
	$result = $statement->execute(
		array(
			':id'	=>	$_POST["Exam_id"]
		)
	);
	
	if(!empty($result))
	{
		echo 'Data Deleted';
	}else{
		echo $result;
		}
}



?>