<?php
include('../Admin_functions/db.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM studentinfo ";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE studentNumber LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR studentName LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY studentName  ';
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
	$sub_array[] = $row["studentNumber"];;
	$sub_array[] = $row["studentName"];
	$sub_array[] = $row["studentEmail"];	
	$sub_array[] = '<button type="button" name="delete" id="'.$row["studentNumber"].'" class="btn btn-danger btn-xs delete">Delete</button>';
	$sub_array[] = '';

	$sub_array[] = '';
	$data[] = $sub_array;
}
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_all_student_records(),
	"data"				=>	$data
);
echo json_encode($output);
?>