<?php
include("../views/header.php");
require_once "../models/connection.php";
?>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>		
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<style>
			body
			{
				margin:0;
				padding:0;
				background-color:#f1f1f1;
			}
			.box
			{
				width:800px;
				padding:10px;
				background-color:#fff;
				border:1px solid #ccc;
				border-radius:5px;
				margin-top:25px;
			}
			.table
			{
				width:1100px;
				padding:30px;
				background-color:#fff;
				border:1px solid #ccc;
				border-radius:5px;
				margin-top:25px;
			}
		</style>	
	</head>
<div class="container" style="background-color:#f4f3ef;">  
	<?php include('top_menus.php'); ?>	
	<br>
	<div> 	
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2" align="right">
					<button type="button" id="add_button" data-toggle="modal" data-target="#examModal" class="btn btn-info btn-lg">Add</button>

				</div>
			</div>
		</div>
		<table id="Exam_data" class="table table-bordered table-striped">
			<thead>
				<tr>						
									
					<th>Exam Title</th>					
					<th>Duration (Minute)</th>
					<th>Total Question</th>					
					<th>Status</th>	
					<th>Question Type</th>
					<th>Exam Date</th>
					<th>Module Code</th>					
				
					<th></th>					
				</tr>
			</thead>
		</table>
	</div>
	
	<div id="examModal" class="modal fade">
		<div class="modal-dialog">
			<form method="post" id="exam_Form" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add Exam</h4>
					</div>
					<div class="modal-body">
						<div class="form-group"
							<label for="ExamTitle" class="control-label">Exam Title</label>
							<input type="text" class="form-control" id="ExamTitle" name="ExamTitle" placeholder="Exam title" required>			
						</div>						
						
						<div class="form-group"
							<label for="Duration" class="control-label">Duration</label>
							<select name="Duration" id="Duration" class="form-control">
	                				<option value="">Select</option>
									<option value="0.6">12 Seconds</option>									
									<option value="3">3 Minute</option>								
	                				<option value="30">30 Minute</option>
	                				<option value="60">1 Hour</option>
	                				<option value="120">2 Hour</option>
	                				<option value="240">4 Hour</option>
	                			</select>	
						</div>
						
						<div class="form-group"
							<label for="TotalQuestion" class="control-label">Total Question</label>
							<select name="TotalQuestion" id="TotalQuestion" class="form-control">
								<option value="">Select</option>
								<option value="1">1 Question</option>
								<option value="2">2 Question</option>
								<option value="3">3 Question</option>
								<option value="5">5 Question</option>
								<option value="10">10 Question</option>
								<option value="50">50 Question</option>
								<option value="100">100 Question</option>
							</select>		
						</div>

						<div class="form-group"
							<label for="ExamStatus" class="control-label">Status</label>
							<select name="ExamStatus" id="ExamStatus" class="form-control">
								<option value="">Select</option>
								<option value="Created">Created</option>
								<option value="Completed">Completed</option>
							</select>			
						</div>
												
						<div class="form-group"
							<label for="ExamType" class="control-label">Exam Type</label>
							<select name="ExamType" id="ExamType" class="form-control">
								<option value="">Select</option>
								<option value="Written">Written</option>
							</select>			
						</div>
						<div class="form-group"
						  <label for="Examdate">Enter a date and time for Exam:</label>
						  <input id="Examdate" class="form-control" type="datetime-local" name="Examdate" />
						</div>
												
						<div class="form-group"
							<label for="Module_Code" class="control-label">Module Code</label>
							<?php
							$result = $connect->query("SELECT moduleCode FROM moduleinfo");
    
								echo "<html>";
								echo "<body>";
								echo "<select name='Module_Cod' id='Module_Cod' class='form-control'>";
								echo '<option value="">Select</option>';
								
								while ($row = $result->fetch_assoc()) {

											  unset($id, $name);
											  $id = $row['moduleCode'];
											  
											  
											  echo '<option value="'.$id.'">'.$id.'</option>';
											 
							}

								echo "</select>";

							?>
						</div>
								
					</div>
					<div class="modal-footer">
						<input type="hidden" name="Exam_id" id="Exam_id" />
					<input type="hidden" name="operation" id="operation" />
						<input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</form>
		</div>
	</div>
			
</div>
<script type="text/javascript" language="javascript" >
$(document).ready(function(){
	$('#add_button').click(function(){
		$('#exam_Form')[0].reset();
		$('.modal-title').text("Add Exam");
		$('#action').val("Add");
		$('#operation').val("Add");
	});
	
	var dataTable = $('#Exam_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"Admin_functions/fetch_Exam.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[0, 3, 4],
				"orderable":false,
			},
		],

	});

	$(document).on('submit', '#exam_Form', function(event){
		event.preventDefault();
		var ExamTitle = $('#ExamTitle').val();
		var Duration = $('#Duration').val();
		var TotalQuestion = $('#TotalQuestion').val();
		var ExamStatus = $('#ExamStatus').val();
		var ExamType = $('#ExamType').val();
		var Examdate = $('#Examdate').val();
		var Module_Cod = $('#Module_Cod').val();

		if(ExamTitle != '' && Duration != '')
		{
			$.ajax({
				url:"Admin_functions/insert_Exam.php",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
					alert(data);
					$('#exam_Form')[0].reset();
					$('#examModal').modal('hide');
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			alert("Both Fields are Required");
		}
	});
	
	$(document).on('click', '.update', function(){
		var user_id = $(this).attr("id");
		$.ajax({
			url:"fetch_single.php",
			method:"POST",
			data:{user_id:user_id},
			dataType:"json",
			success:function(data)
			{
				
				$('#userModal').modal('show');
				$('#first_name').val(data.first_name);
				$('#last_name').val(data.last_name);
				$('.modal-title').text("Edit User");
				$('#user_id').val(user_id);
				$('#user_uploaded_image').html(data.user_image);
				$('#action').val("Edit");
				$('#operation').val("Edit");
			}
		})
	});
	
	$(document).on('click', '.delete', function(){
		var Exam_id = $(this).attr("id");
		if(confirm("Are you sure you want to delete this?"))
		{
			$.ajax({
				url:"Admin_functions/delete_Exam.php",
				method:"POST",
				data:{Exam_id:Exam_id},
				success:function(data)
				{
					alert(data);
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			return false;	
		}
	});
	
	
});
</script>