<?php
include('../Admin_functions/db.php');
include('function.php');

if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		
		$statement = $connection->prepare("INSERT INTO studentinfo (studentNumber, studentName, 
		studentEmail, studentPassword) VALUES (:StudentNumber,:Name,:Email,:Password)
		");
		$result = $statement->execute(
			array(	
				':StudentNumber'=>	$_POST["StudentNumber"],
				':Name'	=>	$_POST["Name"],
				':Email'	=>	$_POST["Email"],
				':Password'	=>	$_POST["Password"],
				
			)
		);
		if(!empty($result))
		{
			echo 'Data Inserted';
		}
	}
}

?>