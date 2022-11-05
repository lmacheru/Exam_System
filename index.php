<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	session_destroy();
     header("Location: ../index.php");
    exit;
}
 
// Include config file
require_once "models/connection.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
		  $uname = mysqli_real_escape_string($connect,$_POST['username']);
          $password = mysqli_real_escape_string($connect,$_POST['password']);
		  
        //check which button has been click on the login page to differenciate between stuident and admin
	if(isset($_POST['Stu_buttn_submit'])){
		// Prepare a select statement
        $sql_query = "select count(*) as cntUser from studentinfo where studentEmail='".$uname."' and studentPassword='".$password."'";
	}else
	{
		 $sql_query = "select count(*) as cntUser from staffinfo where staffEmail='".$uname."' and staffPassword='".$password."'";
	}
		
            $result = mysqli_query($connect,$sql_query);
                                    $row = mysqli_fetch_array($result);

                                    $count = $row['cntUser'];
                
                // Check if username exists, if yes then verify password

                    if($count > 0){                     
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                          
                            $_SESSION["username"] = $username;                            
                                                     

                            // Redirect user to the specific page
							if(isset($_POST['Stu_buttn_submit'])){
                            header("location: views/student-dashboard.php");
							$_SESSION["role"] = 'Student';   
							}
							else{
								//check if the person login in a lecutre or exam admin
                               $sql_query = "SELECT Is_Staff_member FROM `staffinfo` WHERE staffEmail='".$uname."' and staffPassword='".$password."'";
									
									//check the user is lecture or Exam admin
                                        $sql_query = "SELECT Is_Staff_member FROM `staffinfo` WHERE staffEmail='".$uname."' and staffPassword='".$password."'";
                                        $result = mysqli_query($connect,$sql_query);
                                        $row = mysqli_fetch_array($result);								
								
									$Is_staff = $row['Is_Staff_member'];
                                        //this if statement checks if the user from staff is from exam department or is a lecturer
                                        if($Is_staff == "Y"){
                                            //if the person is a staff member we open the Set-ExamPage
                                            header("Location: views/Set-ExamPage.php");
											  
											session_start();

											$_SESSION["role"] = 'admin';   


                                        }
                                        else{
                                            //if the person is a lecturer  we open the admin-home page that shows dashboard
                                             header("location: views/Lecture-Home.php");
											 $_SESSION["role"] = 'user';   
                                        } 
								  
								 

					}
					}else{
                    // Username and password combination doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
				
                }
                    
                }
				
}          

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
	
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
</head>
<body>
 
        

        <section class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">

                <h1 class="my-4">Login Area</h1>

                <div class="card my-4 p-4">
                    <div class="card-title">Login for student & staff</div>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="student-tab" data-toggle="tab" href="#student" role="tab"
                                aria-controls="home" aria-selected="true">Student Login</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="admin-tab" data-toggle="tab" href="#admin" role="tab"
                                aria-controls="profile" aria-selected="true">Lecturer & Exam Department Staff
                                Login</a>
                        </li>
						
                    </ul>

                    <div class="tab-content" id="myTabContent">
					
					<!--Student tab-->

					<div class="tab-pane fade show active" id="student" role="tabpanel" aria-labelledby="home-tab">
                            <br>
                            <form method="post" id="studentForm" action="">
								<?php $_SESSION["TabName"] = 'Stud';?>
                                <div class="form-group">
                                    <label for="username">Student Email Address</label>
                                    <input class="form-control" type="text" name="username" id="username"
                                        placeholder="My Life Email (e.g. 12345678@mylife.unisa.ac.za)">
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" name="password" id="password"
                                        placeholder="Password">
                                        <input type="checkbox" onclick="myFunction()">Show Password


                                </div>

                                <button type="submit" name="Stu_buttn_submit" class="btn btn-secondary btn-lg">Login Student</button>
                                <br>
                                <div class="studResult"></div>

                            </form>
                        </div>
						
						
						<!--Lecturer and staff member tab-->
						
							<div class="tab-pane fade " id="admin" role="tabpanel" aria-labelledby="profile-tab">
                            <br>
                            <form method="post" id="adminForm" action="">
							<?php $_SESSION["TabName"] = 'admin';?>
                                <div class="form-group">
                                    <label for="username">Staff Email Address</label>
                                    <input class="form-control" type="text" name="username" id="username"
                                        placeholder="Staff Email">
                                </div>

                                <div class="form-group">
                                    <label for="password">Staff Password</label>
                                    <input class="form-control" type="password" name="password" id="password"
                                        placeholder="Password">
                                        <input type="checkbox" onclick="ShowPassword()">Show Password
										
                                </div>

                                <button type="submit" name="Admin_buttn_submit" class="btn btn-secondary btn-lg">Login Staff</button>

                                <br>

                                <div class="adminResult"></div>

                            </form>
                        </div>
                    </div>
					<?php 
						if(!empty($login_err)){
							echo '<div class="alert alert-danger">' . $login_err . '</div>';
						}        
					?>
                </div>
				
            </div>
        </div>
    </div>
</section>
    
</body>
</html>
<?php include("views/footer.php"); ?>