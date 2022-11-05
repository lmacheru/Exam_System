<?php
include("../views/header.php");


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

		<table id="Exam_data" class="table table-bordered table-striped">
			<thead>
				<tr>						
									
					<th>Exam Title</th>					
					<th>Duration (Minute)</th>
					<th>Total Questions</th>					
					<th>Status</th>	
					<th>Question Type</th>
					<th>Exam Date</th>
					<th>Module Code</th>					
					<th></th>					
				</tr>
			</thead>
		</table>
	</div>
	
	<!--Modal that will be used to upload the PDF file-->
	<div id="examModal" class="modal fade" data-backdrop="static">
		<div class="modal-dialog">
			<form method="post" id="exam_Form" enctype="multipart/form-data">
						<div class="modal-content">
							<div class="modal-header">
						
								<h4 class="modal-title">Submit PDF</h4>
							</div>
<br><br>
<div id="clockdiv"></div>
<br><br>								
							<div class="modal-body">
								<label>Enter Student Number</label>
								<input type="text" name="Student_Num" id="Student_Num" class="form-control" value="<?php echo substr($_SESSION["username"],0,8);?>"/>
								<br />
								<label>Enter Module Code</label>
								<input type="text" name="Module_Cod" id="Module_Cod" class="form-control " />
								<br />
								<label>Select User Image</label>
								<input type="file" name="student_pdf" id="student_pdf" />
								<span id="user_uploaded_pdf"></span>
								
								<input type="hidden" name="ExamTitle" id="ExamTitle" class="form-control " />
								<input type="hidden" name="Duration" id="Duration" class="form-control " />
								<input type="hidden" name="TotalQuestion" id="TotalQuestion" class="form-control " />
								<input type="hidden" name="ExamStatus" id="ExamStatus" class="form-control " />
								<input type="hidden" name="ExamType" id="ExamType" class="form-control " />
								<input type="hidden" name="Examdate" id="Examdate" class="form-control " />
																
							</div>
							<div class="modal-footer">
								<input type="hidden" name="Exam_id" id="Exam_id" />
								<input type="hidden" name="operation" id="operation" />
								<input type="submit" name="action" id="action" class="btn btn-success" value="Submit" />
							</div>
						</div>
					</form>
	</div>
			
</div>
<script type="text/javascript" language="javascript" >
$(document).ready(function(){	
	var dataTable = $('#Exam_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"Student_functions/fetch_Stu_Exam.php",
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
		var extension = $('#student_pdf').val().split('.').pop().toLowerCase();
		var Operations =$('#operation').val();
		if(extension != '')
		{
			if(jQuery.inArray(extension, ['pdf']) == -1)
			{
				alert("Invalid File please upload .pdf file");
				$('#student_pdf').val('');
				return false;
			}
		}	

		
			$.ajax({
				url:"Student_functions/Submit_Exam.php",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
					//alert(data);
					$('#exam_Form')[0].reset();
					$('#examModal').modal('hide');
					dataTable.ajax.reload();
				}
			});
		
	
	});
	
	$(document).on('click', '.update', function(){
		var Exam_id = $(this).attr("id");

		
		$.ajax({
			url:"Student_functions/fetch_single.php",			
			method:"POST",
			data:{Exam_id:Exam_id},
			dataType:"json",
			success:function(data)
			{
				
				$('#examModal').modal('show');
				$('#ExamTitle').val(data.ExamTitle);
				$('#Duration').val(data.Duration);
				$('#TotalQuestion').val(data.TotalQuestion);
				$('#ExamStatus').val(data.Status);
				$('#ExamType').val(data.ExamType);
				$('#Examdate').val(data.ExamDate);				
				$('#Module_Cod').val(data.ModuleCode);
				
				$('.modal-title').text("Submit Exam");
				$('#Exam_id').val(Exam_id);
				$('#action').val("Submit");
				$('#operation').val("Edit");
				
				
				var Duration = $('#Duration').val();
				// 10 minutes from now

				var time_in_minutes = 1;
				time_in_minutes =Duration
				var current_time = Date.parse(new Date());
				var deadline = new Date(current_time + time_in_minutes*60*1000);


				function time_remaining(endtime){
					var t = Date.parse(endtime) - Date.parse(new Date());
					var seconds = Math.floor( (t/1000) % 60 );
					var minutes = Math.floor( (t/1000/60) % 60 );
					var hours = Math.floor( (t/(1000*60*60)) % 24 );

					return {'total':t,'hours':hours, 'minutes':minutes, 'seconds':seconds};
				}
				function run_clock(id,endtime){
					var clock = document.getElementById(id);
					function update_clock(){
						var t = time_remaining(endtime);
						clock.innerHTML = 'hour: ' +t.hours+ ' : '+t.minutes+' : '+t.seconds;
						
						//check if the timmer is 0 and if its 0 update the test record and close the Exam modal
						if(t.total<=0){ 
						clearInterval(timeinterval); 
						$('#action').val("Submit");
						$('#operation').val("TimeUp");
						document.getElementById("action").click();
							
						}
					}
					update_clock(); // run function once at first to avoid delay
					var timeinterval = setInterval(update_clock,1000);
				}
				run_clock('clockdiv',deadline);
				
				
			}
		})
	
	});
	

});



</script>

