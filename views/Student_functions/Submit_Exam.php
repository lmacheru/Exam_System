<?php
include('../Admin_functions/db.php');


if(isset($_POST["operation"]))
{
	$Exam_id =$_POST["Exam_id"];
	$ExamTitle =$_POST["ExamTitle"];
	$Duration =$_POST["Duration"];
	$TotalQuestion =$_POST["TotalQuestion"];
	$ExamStatus =$_POST["ExamStatus"];
	$ExamType =$_POST["ExamType"];
	$Examdate =$_POST["Examdate"];
	
	$StudentNum =$_POST["Student_Num"];
	$ModuleCode =$_POST["Module_Cod"];
	$Starttime =substr($_POST["Examdate"],11);
	
	if($_POST["operation"] == "Edit")
	{
		
		//get the current/upload date and time 
	$CurrrentDate =date("Y-m-d");

	date_default_timezone_set("Africa/Johannesburg");
	$uploadtime =date("H:i:s");
	
	
	if($_POST["operation"] == "Edit")
	{
		if($_FILES["student_pdf"]["name"] != '')
		{
		$extension = explode('.', $_FILES['student_pdf']['name']);
		$new_name = rand() . '.' . $extension[1];
		
		//setting the location of the pdf file to be stored
		$destination = '../upload/' . $new_name;
		$file_name = $_FILES['student_pdf']['name'];
		
		//$StudentNum = $_POST["first_name"];
		//The uploaded file is moved to the location that stores the copy of the pdf file
		move_uploaded_file($_FILES['student_pdf']['tmp_name'], $destination);
		}
		$statement = $connection->prepare("INSERT INTO examoutput(startTime,uploadTime,examDate,answerPaperPDF,studentNumber,moduleCode) 
		VALUES('$Starttime','$uploadtime','$CurrrentDate','$file_name','$StudentNum','$ModuleCode')
		");
		$result = $statement->execute(
			array(
			
			
			)
		);
		if(!empty($result))
		{
			echo 'File Uploaded';
		}
	
	//After uploading the document into the Db then update the exam session records

	
		//update records
		$statement = $connection->prepare("UPDATE examsession SET ExamTitle='$ExamTitle'
		,Duration='$Duration',TotalQuestion='$TotalQuestion',Status='Completed',ExamType='$ExamType',
		ExamDate='$Examdate',ModuleCode='$ModuleCode' WHERE Id ='$Exam_id'");
		$result = $statement->execute(
			array(	
						
			)
		);
		if(!empty($result))
		{
			echo '  Exam Submitted';
		}
	}
		
	}else
		
		$statement = $connection->prepare("UPDATE examsession SET ExamTitle='$ExamTitle'
		,Duration='$Duration',TotalQuestion='$TotalQuestion',Status='Not Completed',ExamType='$ExamType',
		ExamDate='$Examdate',ModuleCode='$ModuleCode' WHERE Id ='$Exam_id'");
		$result = $statement->execute(
			array(	
						
			)
		);
		if(!empty($result))
		{
			echo '  Exam Ended';
		}
}

?>