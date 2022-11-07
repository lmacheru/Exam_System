
<h5>

<?php 
session_start();
if($_SESSION["username"]) 
{ echo "Logged in: ".ucfirst($_SESSION["username"]); } ?></a> </h5><br>
		<p>
		<strong>Welcome <?php echo ucfirst($_SESSION["role"]); ?>
		</strong>
		</p>	
<ul class="nav nav-tabs">	
	<?php 
	
	if($_SESSION["role"] == 'Administrator') { ?>
	
			<button type="button" name="exam" id="exam" class="btn btn-info"  onclick='window.location.replace("Exam_Admin.php")'>
			  Exam Dashboard
			</button>
			
			<button type="button" name="exam" id="exam" class="btn btn-info"  onclick='window.location.replace("Lecture_Page.php")'>
			  Schedule Exam
			</button>
			
			<button type="button" name="User" id="user" class="btn btn-info"  onclick='window.location.replace("ManageUsers.php")'>
			  Manage Users
			</button>				
	<?php } else if($_SESSION["role"] == 'Lecture') {?>	
			
			<button type="button" name="exam" id="exam" class="btn btn-info"  onclick='window.location.replace("Lecture_Page.php")'>
			  Schedule Exam
			</button>
			
			<button type="button" name="User" id="user" class="btn btn-info"  onclick='window.location.replace("ManageStudents.php")'>
			  Manage Students
			</button>	

			<?php }?>
	
	<?php if($_SESSION["role"] == 'Student') { ?>
	<button type="button" name="Dashboard" id="Dashboard" class="btn btn-info"  onclick='window.location.replace("student-dashboard.php")'>
			  Dashboard
			</button>					
	<?php } ?>
</ul>