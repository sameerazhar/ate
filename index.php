<?php
	session_start();
	if( isset($_SESSION["username"]) && isset($_SESSION["usertype"]) )
	{
		if( $_SESSION["usertype"]=="admin")
		{
			header("Location: admin/client/admin.php");
		}
		elseif( $_SESSION["usertype"]=="student")
		{
			header("Location: student/client/student.php");
		}
		elseif( $_SESSION["usertype"]=="faculty")
		{
			header("Location: faculty/client/faculty.php");
		}
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	</head>
	<body style="background-color:#F0F0F0;">
		<nav class="navbar navbar-inverse  navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="row" style="color:white">
					<div class="col-sm-12">
						<center><h2>PES University - Department of Computer Science</h2></center>
					</div>
				</div>
			</div>
		</nav>
		<div class="container"  style="padding-top:5%">
			<div class="row">
				<div class="col-sm-12">
					<center><h2>Programming Laboratories</h2></center>
				</div>
			</div>
		</div>
		<hr style="height:1px;background-color:black">
		<div style="padding-top:5%">
			<div class="row">
				<div class="col-sm-4">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1">
							<div class="panel panel-default">
								<div class = "panel-body">
									<div class = "page-header">
											<center><h2>Admin</h2></center>
									</div>
									<br>
									<div id="admin_form" style="display:none">
										<div class="row">
											<div class="col-sm-10 col-sm-offset-1">
												<input type="text" placeholder = "Username" class="form-control" name="admin_username" id="admin_username">
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-sm-10 col-sm-offset-1">
												<input type="password" placeholder = "Password" class="form-control" name="admin_password" id="admin_password">
											</div>
										</div>
										<br>  
										<div class="row"  id = "invalid">
											<div class="col-sm-12">
												<center><label id = "admin_errormsg" style = "display:none;color:red;font-size:1.2em"></label></center>
											</div>
										</div>
										<br>
									</div>
									
									<div class="row">
										<div class="col-sm-10 col-sm-offset-1">
												<button class="btn btn-block btn-success" id = "admin_btn" onclick = "admin();" style="font-size:1.3em">Log In</button>
											</div>
									</div><br>
									<div class="row" id = "admin_details">
										<div class="col-sm-10 col-sm-offset-2">
											<ul>
												<li><strong>View Courses</strong></li>
												<li><strong>Create new Courses</strong></li>
												<li><strong>View Student Details</strong></li>
												<li><strong>Update Student Details</strong></li>
												<br>
												<br>
												<br>
											</ul>
										</div>
									</div>
									<br>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1">
							<div class="panel panel-default">
								<div class = "panel-body">
									<div class = "page-header">
											<center><h2>Student</h2></center>
									</div>
									<br>
									<div class="form-group" id="stud_form" style="display:none">
										<div class="row">
											<div class="col-sm-10 col-sm-offset-1">
												<input type="text" placeholder = "Username" class="form-control" name="stud_username" id="stud_username">
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-sm-10 col-sm-offset-1">
												<input type="password" placeholder = "Password" class="form-control" name="stud_password" id="stud_password">
											</div>
										</div>
										<br>  
										<div class="row"  id = "invalid">
											<div class="col-sm-12">
												<center><label id = "stud_errormsg" style = "display:none;color:red;font-size:1.2em"></label></center>
											</div>
										</div>
										<br>
									</div>
									
									<div class="row">
										<div class="col-sm-10 col-sm-offset-1">
												<button class="btn btn-block btn-success" id = "stud_btn" onclick = "student();" style="font-size:1.3em">Log In</button>
											</div>
									</div><br>
									<div class="row" id = "stud_details">
										<div class="col-sm-10 col-sm-offset-2">
											<ul>
												<li><strong>View Problem Statements</strong></li>
												<li><strong>Submit Lab Programs</strong></li>
												<li><strong>Submit Assignments</strong></li>
												<li><strong>Attend Lab Exams</strong></li>
												<br>
												<br>
												<br>
											</ul>
										</div>
									</div>
									<br>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1">
							<div class="panel panel-default">
								<div class = "panel-body">
									<div class = "page-header">
											<center><h2>Faculty</h2></center>
									</div>
									<br>
									<div class="form-group" id="fclt_form" style="display:none">
										<div class="row">
											<div class="col-sm-10 col-sm-offset-1">
												<input type="text" placeholder = "Username" class="form-control" name="fclt_username" id="fclt_username">
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-sm-10 col-sm-offset-1">
												<input type="password" placeholder = "Password" class="form-control" name="fclt_password" id="fclt_password">
											</div>
										</div>
										<br>  
										<div class="row"  id = "invalid">
											<div class="col-sm-12">
												<center><label id = "fclt_errormsg" style = "display:none;color:red;font-size:1.2em"></label></center>
											</div>
										</div>
										<br>
									</div>
									
									<div class="row">
										<div class="col-sm-10 col-sm-offset-1">
												<button class="btn btn-block btn-success" id = "fclt_btn" onclick = "faculty();" style="font-size:1.3em">Log In</button>
											</div>
									</div><br>
									<div class="row" id = "fclt_details">
										<div class="col-sm-10 col-sm-offset-2">
											<ul>
												<li><strong>Upload Questions</strong></li>
												<li><strong>Upload test</strong></li>
												<li><strong>Evaluate Student Programs</strong></li>
												<li><strong>Upload Solution</strong></li>
												<br>
												<br>
												<br>
											</ul>
										</div>
									</div>
									<br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src = "bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src = "bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src = "authentication/login.js"></script>
	</body>
</html>
