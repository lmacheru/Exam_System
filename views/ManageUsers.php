<?php
include("../views/header.php");
?>
<html>
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
	<body>
		<div class="container Box">
		<?php include('top_menus.php'); ?>
			
						<div class="table-responsive">
				<div align="right">
					<button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-info btn-lg">Add</button>
				</div>
				
				<table id="user_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="10%">StaffNumber</th>
							<th width="35%">StaffName</th>
							<th width="35%">StaffEmail</th>
							<th width="10%">Delete</th>
							<th width="10%"></th>

						</tr>
					</thead>
				</table>
				
			</div>
		</div>
	</body>
</html>

<div id="userModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="user_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add User</h4>
				</div>
				<div class="modal-body">
						<div class="form-group"
							<label for="StaffNumber" class="control-label">Staff Number*</label>
							<input type="text" class="form-control" id="StaffNumber" name="StaffNumber" placeholder="Staff Number" required>			
						</div>
						
						<div class="form-group"
							<label for="Name" class="control-label">Name*</label>
							<input type="text" class="form-control" id="Name" name="Name" placeholder="Name" required>			
						</div>
						
						<div class="form-group"
							<label for="username" class="control-label">Email*</label>
							<input type="email" class="form-control" id="Email" name="Email" placeholder="Email" required>			
						</div>
						
						
						
						<div class="form-group">
							<label for="status" class="control-label">Role</label>				
							<select id="Role" name="Role" class="form-control">
							<option value="Y">Admin</option>				
							<option value="N">Lecture</option>	
							</select>						
						</div>	
					

						<div class="form-group"
							<label for="Password" class="control-label">New Password</label>
							<input type="text" class="form-control" id="Password" name="Password" placeholder="Password">			
						</div>		
				<div class="modal-footer">
					<input type="hidden" name="user_id" id="user_id" />
					<input type="hidden" name="operation" id="operation" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript" language="javascript" >
$(document).ready(function(){
	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').text("Add User");
		$('#action').val("Add");
		$('#operation').val("Add");
	});
	
	var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"Admin_functions/fetch_Staff.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[0, 3, 4],
				"orderable":false,
			},
		],

	});

	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
		var StaffNumber = $('#StaffNumber').val();
		var Name = $('#Name').val();
		var Email = $('#Email').val();
		var Role = $('#Role').val();
		var Password = $('#Password').val();

		if(StaffNumber != '' && Name != '')
		{
			$.ajax({
				url:"Admin_functions/insert_Staff.php",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
					alert(data);
					$('#user_form')[0].reset();
					$('#userModal').modal('hide');
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
		var user_id = $(this).attr("id");
		if(confirm("Are you sure you want to delete this?"))
		{
			$.ajax({
				url:"Admin_functions/delete_Staff.php",
				method:"POST",
				data:{user_id:user_id},
				success:function(data)
				{
					alert(data);
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
								alert(data);

			return false;	
			
		}
	});
	
	
});
$(document).ready(function() {
    $('#Name').keyup(function(e) {
        var txtVal = $(this).val();
        $('#Email').val(txtVal.concat('@unisa.ac.za'));
    });
    
    $('#Email').keyup(function(e) {
        var txtVal = $(this).val();
        $('#Name').val(txtVal);
    });
});
</script>