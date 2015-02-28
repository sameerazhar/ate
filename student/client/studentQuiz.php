<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "student" )
	{
		header("Location: ../../index.php");
	}
	extract($_GET);
	require_once "../../sql_connect.php";
	$query = "SELECT * FROM course WHERE course_code='" . $course . "'";
	$res = mysql_query($query);
	$row = mysql_fetch_assoc($res,MYSQL_ASSOC);
	$course_name = $row["course_name"];
	$course_code = $course;
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
		            	<li><a href="./student.php" style="color:white"><span class="glyphicon glyphicon-home"></span> &nbsp;&nbsp;Home</a></li>
						<li class = "dropdown active">
						<a href="#" class = "dropdown-toggle" id = "username" data-toggle = "dropdown" style="color:white">USERNAME <b class = "caret"></b></a>
						<ul class = "dropdown-menu">
							<li><a href="./studentChangePassword.php">Change Password</a></li>
							<li><a href="./studentRegisterCourses.php">Register Courses</a></li>
							<li><a href="../../authentication/logout.php">Log Out</a></li>
						</ul>
						</li>
		          	</ul>
		        </div>
	    	</div>
    	</nav>

		<br>
		<div class="container" style="padding-top:4%">
			<div class = "row">
				<div class = "col-sm-12">
					<div class="panel panel-default">
						<div class = "panel-body">
							<div class = "page-header">
								<?php
									$query = "SELECT course_name FROM course WHERE course_code='" . $course_code . "'";
									$result = mysql_query($query);
									$num = mysql_num_rows($result);
									if( $num == 0 )
									{
										echo "<h2 style = \"padding-left:5%;color:red;\">";
										echo "Server Error Occured. Try again later.";
									}
									else
									{
										echo "<h2 style = \"padding-left:5%;\">";
										$row = mysql_fetch_assoc($result, MYSQL_ASSOC);
										echo $row["course_name"] . " - " . $course_code;
									}
									echo "</h2>";
								?>
							</div>
							<br>
							<div>
								<ul class="nav nav-tabs">
									<li><a href=<?php echo "./studentLab.php?course=" . $course_code?> >Lab Assignments</a></li>
									<li><a href="#">Assignments</a></li>
									<li><a href="#">Exams</a></li>
									<li class="active"><a href=<?php echo "\"./studentQuiz.php?course=" . $course_code . "\"";?> >Quiz</a></li>
									
								</ul>
							</div>
							<br>
							<div class="row">
								<div class="col-sm-12">
									<table class="table table-bordered">
									<?php
										$query= "SELECT quiz.quiz_id, quiz.quiz_name, quiz.time_period, quiz.enable FROM quiz_student JOIN quiz ON quiz.quiz_id = quiz_student.quiz_id WHERE course_code='" . $course_code . "' AND usn='" . $_SESSION["username"] . "' AND ( started=0 or started=1) AND enable=1";
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
										<tr>
											<td><center><label><?php echo $var + 1; echo "."; ?></label></center></td>
											<td><label><?php echo $row["quiz_name"]; ?></label></td>
											<td><center><a href=<?php echo "\"javascript:attempt_quiz('" . $course_code . "', '" . $row["quiz_id"] . "')\"" ; ?> >Attempt</a></center></td>
											<td><center><small>Time : <?php echo ($row["time_period"] / 60) . " mins"; ?></small></center></td>
										</tr>
									<?php
											}
										}
									?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src = "../../bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src = "../../bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src = "./js/studentQuiz.js"></script>
		<script type="text/javascript">
			window.onload = function ()
			{
			    var username = document.getElementById("username");
			    username.innerHTML = <?php echo  json_encode($_SESSION["username"])  ?> + "&nbsp;<b class = \"caret\"></b>";
			}
		</script>
	</body>
</html>
