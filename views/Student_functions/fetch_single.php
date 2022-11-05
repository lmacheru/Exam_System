<?php
include('../Admin_functions/db.php');
include('../Admin_functions/function.php');
if(isset($_POST["Exam_id"]))
{
	$output = array();
	$statement = $connection->prepare(
		"SELECT * FROM examsession 
		WHERE id = '".$_POST["Exam_id"]."' 
		LIMIT 1"
	);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
	
	$output["ExamTitle"] = $row["ExamTitle"];
	$output["Duration"] = $row["Duration"];
	$output["TotalQuestion"] = $row["TotalQuestion"];
	$output["Status"] = $row["Status"];
	$output["ExamType"] = $row["ExamType"];
	$output["ExamDate"] = $row["ExamDate"];
	$output["ModuleCode"] = $row["ModuleCode"];
		
	}
	echo json_encode($output);
}
?>