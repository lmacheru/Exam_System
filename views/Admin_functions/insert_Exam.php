<?php
include('db.php');
include('function.php');

if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		
		$statement = $connection->prepare("
			INSERT INTO examsession (ExamTitle, Duration, TotalQuestion, Status, ExamType,ExamDate,ModuleCode) 
			VALUES (:ExamTitle, :Duration,:TotalQuestion, :ExamStatus, :ExamType,:Examdate,:Module_Cod)
		");
		$result = $statement->execute(
			array(	
				':ExamTitle'=>	$_POST["ExamTitle"],
				':Duration'	=>	$_POST["Duration"],
				':TotalQuestion'=>	$_POST["TotalQuestion"],
				':ExamStatus'	=>	$_POST["ExamStatus"],
				':ExamType'	=>	$_POST["ExamType"],
				':Examdate'	=>	$_POST["Examdate"],
				':Module_Cod'	=>	$_POST["Module_Cod"],
				
			)
		);
		if(!empty($result))
		{
			echo 'Data Inserted';
		}
	}
}

?>