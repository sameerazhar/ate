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
	$course_name = $row["course_name"];
	$course_code = $course;
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
		<div class="container" style="padding-top:4%">
			<div class = "row">
				<div class = "col-sm-12">
					<div class="panel panel-default">
						<div class = "panel-body">
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
														$query= "SELECT * FROM quiz WHERE quiz_id='" . $quiz . "'";
														$result = mysql_query($query);
														$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
														$qstn_order = $row["question_order"];
														$qstns = explode(",",$qstn_order);
													?>
													<div class="row">
														<div class="col-sm-12">
															<h3 style="padding-left:5%;"><?php echo $row["quiz_name"]; ?></h3>
														</div>
													</div>
													<hr>
													<?php
														$num = sizeof($qstns);
														for( $i = 0; $i < $num; $i++ )
														{
													?>
													<div class="row">
														<div class="col-sm-10">
													<?php
															$qstn = $qstns[$i];
															$query= "SELECT question, correct_answer, difficulty FROM quiz_qstn_repository WHERE qstn_id='" . $qstn . "'";
															$result = mysql_query($query);
															$row = mysql_fetch_assoc($result,MYSQL_ASSOC);						
															$question_string = $row["question"];
															$correct_answer=$row["correct_answer"];
															$temp = $i + 1;
															echo $temp . ".  " . utf8_decode($row["question"]);
															?>
														</div>
														<div class="col-sm-2">
													<?php
															$diff = utf8_decode($row["difficulty"]);
															if( $diff == 1 )
															{
																echo "<label style = \"color:green\">Easy</label>";
															}
															else if( $diff == 2 )
															{
																echo "<label style = \"color:orange\">Medium</label>";
															}
															else
															{
																echo "<label style = \"color:red\">Difficult</label>";
															}
													?>
														</div>
													</div>
													<br>
													<?php
															$query= "SELECT option_no,ques_option FROM question_option WHERE qstn_id= $qstn ORDER BY option_no";
															$result = mysql_query($query);
															while($row = mysql_fetch_assoc($result,MYSQL_ASSOC))
															{
													?>
													<div class="row">
														<div class="col-sm-10 col-sm-offset-1">
															<?php echo utf8_decode($row["option_no"]) . ".  " . utf8_decode($row["ques_option"]); ?>
														</div>
													</div>
													<?php
															}
													?>
													<br>
													<div class="row">
														<div class="col-sm-10 col-sm-offset-1">
															<?php echo "Answer:  " . utf8_decode($correct_answer); ?>
														</div>
													</div>
													<hr>
													<?php
														}
													?>
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