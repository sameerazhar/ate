<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "faculty" )
	{
		header("Location: /ate/index.php");
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
		<link rel="stylesheet" type="text/css" href="/ate/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/ate/bootstrap/css/mynav.css">
		<script type="text/javascript" src = "/ate/faculty/client/js/facultyQuizzes.js"></script>
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
											<br>
											<div class="row">
												<div class="col-sm-12">
													<table class="table table-bordered">
													<?php
														$query = "SELECT * FROM quiz WHERE course_code='" . $course_code . "' group by quiz_name";
														$result = mysql_query($query);
														$num = mysql_num_rows($result);
														if( $num == 0 )
														{
															echo "<h3 style = \"color:red;padding-left:5%;\">No Quizzes</h3>";
														}
														else
														{
															for( $var = 0; $var < $num; $var++ )
															{
																$row = mysql_fetch_assoc($result, MYSQL_ASSOC);
													?>
													<?php echo "<tr id =\"row" . $row["quiz_id"] . "\">"; ?>
														<td>
															<center><label><?php echo $var + 1; echo "."; ?></label></center>
														</td>
														<td>
															<label> <?php echo $row["quiz_name"]; ?> </label>
														</td>
														<td>
															<center><a href = <?php echo "/ate/faculty/client/facultyViewQuiz.php?course=" . $course_code . "&quiz=" . $row["quiz_id"]; ?> >View</a></center>
														</td>
														<td>
													<?php
																$enable = "Enable";
																if( $row["enable"] == 1 )
																{
																	$enable = "Disable";
																}
													?>
															<center><a href= <?php echo "\"javascript:disable_quiz('" . $row["quiz_id"] . "')\"  id = \"enable" . $row["quiz_id"] . "\" " ?> ><?php echo $enable; ?></a></center>
														</td>
														<td>
															<center><a href= <?php echo "\"javascript:evaluate_quiz('" . $row["quiz_id"] . "', '" . $course_code . "')\"" ?> >Evaluate</a></center>
														</td>
														<td>
															<center><a href= <?php echo "\"javascript:delete_quiz('" . $row["quiz_id"] . "')\"  id = \"delete" . $row["quiz_id"] . "\" " ?>>Delete</a></center>
														</td>
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
		<script type="text/javascript">
			window.onload = function ()
			{
			    var username = document.getElementById("username");
			    username.innerHTML = <?php echo  json_encode($_SESSION["username"]);  ?> + "&nbsp;<b class = \"caret\"></b>";
			}
		</script>
	</body>
</html>