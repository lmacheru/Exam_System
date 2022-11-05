<?php
include('db.php');
include('function.php');

if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		
		$statement = $connection->prepare("
			INSERT INTO staffinfo (staffNumber,staffName, staffEmail, staffPassword,Is_Staff_member) 
			VALUES (:StaffNumber, :Name, :Email, :Password, :Role)
		");
		$result = $statement->execute(
			array(
				':StaffNumber'	=>	$_POST["StaffNumber"],
				':Name'	=>	$_POST["Name"],
				':Email'	=>	$_POST["Email"],
				':Password'	=>	$_POST["Password"],
				':Role'	=>	$_POST["Role"],
			)
		);
		if(!empty($result))
		{
			echo 'Data Inserted';
		}
	}
	
	if($_POST["operation"] == "Edit")
	{
		$image = '';
		if($_FILES["user_image"]["name"] != '')
		{
			$image = upload_image();
		}
		else
		{
			$image = $_POST["hidden_user_image"];
		}
		$statement = $connection->prepare(
			"UPDATE users 
			SET first_name = :first_name, last_name = :last_name, image = :image  
			WHERE id = :id
			"
		);
		$result = $statement->execute(
			array(
				':StaffNumber'	=>	$_POST["StaffNumber"],
				':Name'	=>	$_POST["Name"],
				':Email'	=>	$_POST["Email"],
				':Password'	=>	$_POST["Password"],
				':Role'	=>	$_POST["Role"]
			)
		);
		if(!empty($result))
		{
			echo 'Data Updated';
		}
	}
}

?>