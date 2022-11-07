<?php

include('../Admin_functions/db.php');
include("function.php");

if(isset($_POST["user_id"]))
{
	$statement = $connection->prepare(
		"DELETE FROM studentinfo WHERE studentNumber = :studentNumber"
	);
	$result = $statement->execute(
		array(
			':studentNumber'	=>	$_POST["user_id"]
		)
	);
	if(!empty($result))
	{
		echo 'Data Deleted';
	}else
		echo $result;
		
}
?>