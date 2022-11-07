<?php
include("../views/header.php"); 
include ("../models/db-functions.php");
// Include config file
require_once "../models/connection.php";

     // handle the request 
        $regStudents = get_number_student_Weekly_Submissions_for_modules();
        $moduleCode = [];
        $numberOfStudents = [];
        foreach($regStudents as $student){
            $moduleCode[] = $student["moduleCode"];
            $numberOfStudents[] = $student["NUM_STUDENTS"];
        }

        // student response
        $responses = get_number_student_submissions_for_modules();
        $code = [];
        $number = [];
        foreach($responses as $res){
            $code[] = $res["moduleCode"];
            $number[] = $res["Submissions"];
        }

?>
<div class="content">
		<div class="container">
<?php include('top_menus.php'); ?>	
				<div class="row">


					<div class="col-md-7">
						<h2>Other Report</h2>
						<p>Number of students registed</p>
						<b class="text-danger"><?php echo get_all_students_count(); ?> students</b>
					</div>
					<div class="col-md-4">
						 <h2>Other Report</h2>
						<p>Exams for all modules Completed</p>
						<b class="text-danger"><?php echo get_total_number_submissions_for_all_module(); ?> submissions</b>
					
					<p>Exams all modules Not Completed</p>
						<b class="text-danger"><?php echo get_total_number_of_Exam_NotCompleted(); ?> submissions</b>
					</div>


					
					<div class="col-md-5">
					<h2>Daily</h2>
						<p>Number of student submission for each module</p>
						<canvas height="500" id="student-Submissions"></canvas>

					</div>

					<div class="col-md-5">
						<h2>Weekly</h2>
						<p>Students who took exam for each UNISA module</p>
						<canvas height="500" id="student-registeration"></canvas>
					</div>
				</div>

		</div>
</div>
  </div>
   <!-- Custom JS Link -->
    <script src="../assets/dist/js/main.js"></script>
    <script src="../assets/dist/js/Chart.min.js"></script>
    <script>
		var barColors = [
  "#2b5797",
  "#e8c3b9", 
  "#b91d47",
  "#00aba9",
  "#8A2BE2",
  "#A9A9A9",
  "#FFFF00",
  "#B22222",
  "#FF69B4",
  "#66CDAA",
  "#FFA500",
  "#8B4513"
];
        let register = document.getElementById('student-registeration').getContext('2d');
        let chart = new Chart(register, {
        type: 'pie', // bar 
        data: {
            labels: <?php echo json_encode($moduleCode) ?>,
            datasets: [{
                label: 'Student Registration For Each Module',
                data: <?php echo json_encode($numberOfStudents) ?>, // background
                backgroundColor: barColors, // bar color 
                borderWidth: 1,
                borderColor: '#c1a149',
                hoverBorderWidth: 3,
                hoverBorderColor: '#00cbff'
            }]

        } 
    });

    </script>

    <script>
	
		var barColors = [
  "#2b5797",
  "#e8c3b9", 
  "#b91d47",
  "#00aba9",
  "#8A2BE2",
  "#A9A9A9",
  "#FFFF00",
  "#B22222",
  "#FF69B4",
  "#66CDAA",
  "#FFA500",
  "#8B4513"
];
	
        let resp = document.getElementById('student-Submissions').getContext('2d');
        let respChart = new Chart(resp, {
        type: 'doughnut', // bar 
        data: {
            labels: <?php echo json_encode($code) ?>,
            datasets: [{
                label: 'Student Submissions For Each Module',
                data: <?php echo json_encode($number) ?>, // background
                backgroundColor: barColors, //Green bar color 
                borderWidth: 1,
                borderColor: '#c1a149',
                hoverBorderWidth: 2,
                hoverBorderColor: '#00cbff'
            }]

        } 
    });
    </script>

<?php include("../views/footer.php"); ?>