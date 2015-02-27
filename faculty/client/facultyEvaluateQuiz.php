<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "faculty" )
	{
		header("Location: /ate/index.php");
	}
	extract($_GET);
	$course_code = trim($course);
	$quiz_id = trim($quiz_id);
	require_once "../../sql_connect.php";
	$query = "SELECT * FROM course WHERE course_code='" . $course_code . "'";
	$res = mysql_query($query);
	$row = mysql_fetch_assoc($res,MYSQL_ASSOC);
	$course_name = $row["course_name"];
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="/ate/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/ate/bootstrap/css/mynav.css">
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
		        	<div class="navbar-brand" style="color:white"></div>
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
		        	<ul class="nav navbar-nav  navbar-right">
		        		
		            	<li><a href="/ate/faculty/client/faculty.php" style="color:white"><span class="glyphicon glyphicon-home"></span> &nbsp;&nbsp;Home</a></li>
		            	
						<li class = "dropdown">
						<a href="#" class = "dropdown-toggle" id = "username" data-toggle = "dropdown" style="color:white">USERNAME <b class = "caret"></b></a>
						<ul class = "dropdown-menu">
							<li><a href="#">Change Password</a></li>
							<li><a href="#">Change Username</a></li>
							<li><a href="/ate/authentication/logout.php">Log Out</a></li>
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
										<li><a href=<?php echo "/ate/faculty/client/facultyUploadLab.php?course=" . $course_code; ?> >Lab Assignments</a></li>
										<li><a href="/ate/faculty/client/facultyCourseRegAssign.php">Assignments</a></li>
										<li><a href="/ate/faculty/client/facultyCourseExam.php">Exams</a></li>
										<li class="active"><a href=<?php echo "/ate/faculty/client/facultyQuizzes.php?course=" . $course_code; ?> >Quiz</a></li>
									</ul>
								</div>
								<div class="col-sm-9">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="row">
												<div class="col-sm-12">
													<ul class="nav nav-tabs">
														<li class="active"><a href=<?php echo "/ate/faculty/client/facultyQuizzes.php?course=" . $course_code; ?> >Quizzes</a></li>
														<li><a href=<?php echo "/ate/faculty/client/facultyUploadQuiz.php?course=" . $course_code; ?> >Create new Quiz</a></li>	
													</ul>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12">
													<?php
														$query = "SELECT * FROM quiz WHERE quiz_id=" . $quiz_id . " and course_code='" . $course_code . "'";
														$result = mysql_query($query);
														$num = mysql_num_rows($result);
														if( $num == 0 )
														{
															echo "<h3 style = \"color:red;padding-left:5%;\">Some error occured. Please try later.</h3>";
														}
														else
														{
															$row = mysql_fetch_assoc($result, MYSQL_ASSOC);
															echo "<h3 style=\"padding-left:5%;\">" . $row["quiz_name"] . " - Results</h3>";
														}
													?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3 col-xs-6 col-sm-offset-7">
													<button class="btn btn-default pull-right">Download Results</button>
												</div>
												<div class="col-sm-2 col-xs-6">
													<a href = <?php echo "/ate/faculty/client/facultyViewQuiz.php?course=" . $course_code . "&quiz=" . $quiz_id; ?> class="btn btn-default pull-right">View Questions</a>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-sm-12">
													<table class="table table-bordered">
														<tr>
															<th><center>USN</center></th>
															<th><center>Marks</center></th>
															<th></th>
														</tr>
													<?php
														$query = "SELECT usn, marks FROM quiz_student WHERE quiz_id=" . $quiz_id;
														$result = mysql_query($query);
														$num = mysql_num_rows($result);
														if( $num == 0 )
														{
															echo "<h3 style = \"color:red;padding-left:5%;\">Sorry no data.</h3>";
														}
														else
														{
															for( $var = 0; $var < $num; $var++ )
															{
																$row = mysql_fetch_assoc($result, MYSQL_ASSOC);
													?>
														<tr>
															<td><center><?php echo $row["usn"]; ?></center></td>
															<td><center><?php echo $row["marks"]; ?></center></td>
															<td><center><a href = <?php echo "\"javascript:view_results('" . $row["usn"] . "', '" . $quiz_id . "', '" . $course_code . "');\"" ?> >View Answers</a></center></td>
														</tr>
													<?php
															}
														}
													?>
													</table>
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

		<script type="text/javascript" src = "/ate/bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src = "/ate/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src = "/ate/faculty/client/js/facultyEvaluateQuiz.js"></script>
		<script type="text/javascript">
			window.onload = function ()
			{
			    var username = document.getElementById("username");
			    username.innerHTML = <?php echo  json_encode($_SESSION["username"]);  ?> + "&nbsp;<b class = \"caret\"></b>";
			}
		</script>
	</body>
</html>