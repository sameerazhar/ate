<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "faculty" )
	{
		header("Location: ../../index.php");
	}
	extract($_GET);
	require_once "../../sql_connect.php";
	$query = "SELECT * FROM course WHERE course_code='" . $course . "'";
	$res = mysql_query($query);
	$row = mysql_fetch_assoc($res,MYSQL_ASSOC);
	$course_code = $course;
	$course_name = $row["course_name"];
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../../bootstrap/css/mynav.css">
	</head>
	<body style="background-color:#F0F0F0;">
		<nav class="navbar navbar-inverse navbar-fixed-top">
	    	<div class="container">
		        <div class="navbar-header">
		        	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			            <span class="sr-only">Toggle navigation</span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
		        	</button>
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
		        	<ul class="nav navbar-nav  navbar-right">
		            	<li><a href="./faculty.php" style="color:white"><span class="glyphicon glyphicon-home"></span> &nbsp;&nbsp;Home</a></li>
						<li class = "dropdown">
						<a href="#" class = "dropdown-toggle" id = "username" data-toggle = "dropdown" style="color:white">USERNAME <b class = "caret"></b></a>
						<ul class = "dropdown-menu">
							<li><a href="#">Change Username</a></li>
							<li><a href="#">Change Password</a></li>
							<li><a href="../../authentication/logout.php">Log Out</a></li>
						</ul>
						</li>
		          	</ul>
		        </div>
	    	</div>
    	</nav>

		<br>
		<div class="container" style="padding-top:4%" ng-app = "facultyApp">
			<div class = "row">
				<div class = "col-sm-12">
					<div class="panel panel-default">
						<div class = "panel-body" ng-controller = "facultyController">
							<div class = "page-header">
								<h2 style = "padding-left:5%"><?php  echo $course_code . " - " . $course_name ?></h2>
							</div>
							<br>
							<br>
							<div class="row">
								<div class="col-sm-3">
									<ul class="nav nav-pills nav-stacked">
										<li class="active"><a href=<?php echo "./facultyUploadLab.php?course=" . $course_code; ?> >Lab Assignments</a></li>
										<li><a href="./facultyCourseRegAssign.php">Assignments</a></li>
										<li><a href="./facultyCourseExam.php">Exams</a></li>
										<li><a href=<?php echo "./facultyQuizzes.php?course=" . $course_code; ?> >Quiz</a></li>
									</ul>
								</div>
								<div class="col-sm-9">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="row">
												<div class="col-sm-12">
													<ul class="nav nav-tabs">
														<li class="active"><a href=<?php echo "./facultyUploadLab.php?course=" . $course_code; ?> >Upload new Assignment</a></li>
														<li><a href=<?php echo "./facultyEvaluateLab.php?course=" . $course_code; ?> >Evaluate Assignment</a></li>
													</ul>
												</div>
											</div>
											<br><br>
											<div class="row">
												<div class="col-sm-12">
													<form onsubmit="return false;">
													<div class="row">
														<div class="col-sm-2">
															<label style="padding-top:4%;">Week Number</label>
														</div>
														<div class="col-sm-3">
															<input type = "number" min = "1" id = "week_num" autofocus placeholder="Week Number" class="form-control" />
														</div>
														<div class="col-sm-3">
															<label style="padding-top:4%;">Assignment Number</label>
														</div>
														<div class="col-sm-3">
															<input type="number" min = "1" id = "assign_num" placeholder = "Assignment Number" class="form-control" />
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-sm-12">
															<textarea rows = "10" id = "que" style = "resize:none" class="form-control" placeholder = "Enter the Problem Statement here...."></textarea>
														</div>
													</div>
													<br>
													
													<div class="row">
														<div class="col-sm-5">
															<input type="number" id = "num_t_c" ng-model = "data.val" min = "0" class="form-control"  placeholder = "Enter Number of Test Cases">
														</div>
													</div>
													<br>
													
													<div ng-repeat = "x in [] | range:data.val">
														<div class="row">
															<div class="col-sm-2">
																<center><label style="padding-top:4%;">Test Case {{x}}:</label></center>
															</div>
															<div class="col-sm-2">
																<label style="padding-top:4%;">Input File</label>
															</div>
															<div class="col-sm-8" id = "infile{{x}}">
																<input type = "file" id = "inputfile{{x}}">
															</div>
														</div>
														
														<div class="row">
															<div class="col-sm-2 col-sm-offset-2">
																<label style="padding-top:4%;">Output File</label>
															</div>
															<div class="col-sm-8" id = "outfile{{x}}">
																<input type = "file" id = "outputfile{{x}}">
															</div>
														</div>
														<br>
													</div>
													<br>
													<div class="row">
														<div class="col-sm-3">
															<label style="padding-top:4%;">Output Delimiter:</label>
														</div>
														<div class="col-sm-4">
															<input type="text" id = "delimit" class="form-control" placeholder = "Output Delimiter" />
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-sm-2">
															<label style="padding-top:4%;padding-left:5%;">Due Date :</label>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-2">
															<label style="padding-top:4%;padding-left:5%;">From :</label>
														</div>
														<div class="col-sm-3">
															<input type="date" id = "start_date" class="form-control">
														</div>
														<div class="col-sm-3 col-sm-offset-1">
															<input type="time" id = "start_time" class="form-control">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-sm-2">
															<label style="padding-top:4%;padding-left:5%;">To :</label>
														</div>
														<div class="col-sm-3">
															<input type="date" id = "end_date" class="form-control">
														</div>
														<div class="col-sm-3 col-sm-offset-1">
															<input type="time" id = "end_time" class="form-control">
														</div>
													</div>
													<br>
													<br>
													<div class="row">
														<div class="col-sm-3 col-sm-offset-2">
															<input type="submit" value="Submit" onclick="upload_labAssign();" class="btn btn-primary btn-block" />
														</div>
														<div class="col-sm-3 col-sm-offset-2">
															<input type="reset" value="Reset" class="btn btn-primary btn-block">
														</div>
													</div>
													</form>
												</div>
											</div>
											<br><br>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript" src = "../../bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src = "../../bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src = "../../bootstrap/js/angular.js"></script>
		<script type="text/javascript" src = "./js/facultyUploadLab.js"></script>
		<script type="text/javascript">
			window.onload = function ()
			{
			    var username = document.getElementById("username");
			    username.innerHTML = <?php echo  json_encode($_SESSION["username"]);  ?> + "&nbsp;<b class = \"caret\"></b>";
			}
		</script>
	</body>
</html>
