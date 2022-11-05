<?php
include('../Admin_functions/db.php');
include('../Admin_functions/function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM examsession ";
if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE ExamTitle LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR Status LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY Id DESC ';
}
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	
	$sub_array = array();

	$sub_array[] = $row["ExamTitle"];
	$sub_array[] = $row["Duration"];
	$sub_array[] = $row["TotalQuestion"];
	$sub_array[] = $row["Status"];
	$sub_array[] = $row["ExamType"];
	$sub_array[] = $row["ExamDate"];
	$sub_array[] = $row["ModuleCode"];
	
	if($row["Status"] =='Completed' ||$row["Status"] == 'Not Completed'){
	$sub_array[] = '<button type="button" name="Close" id="'.$row["Id"].'" class="bbtn btn-success" disabled>Closed</button>';
	}
	else{
			$sub_array[] = '<button type="button" name="update" id="'.$row["Id"].'" class="btn btn-warning btn-xs update">Start Exam</button>';
	}
	$data[] = $sub_array;
}
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_Exam_records(),
	"data"				=>	$data
);
echo json_encode($output);
?>