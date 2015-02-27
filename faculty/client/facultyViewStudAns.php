<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "faculty" )
	{
		header("Location: /ate/index.php");
	}
	extract($_GET);
	$course_code = trim($course);
	$quiz_id = trim($quiz_id);
	$usn = trim($usn);
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
												<div class="col-sm-8">
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
															$quiz_name = $row["quiz_name"];
															$query = "SELECT * FROM quiz_student WHERE quiz_id=" . $quiz_id . " AND usn='" . $usn . "'";
															$result = mysql_query($query);
															$row = mysql_fetch_assoc($result, MYSQL_ASSOC);
															echo "<h3 style=\"padding-left:5%;\">" . $quiz_name . " - " . $usn . "</h3>";
														}
													?>
												</div>
												<div class="col-sm-4">
													<h3 class="pull-right">Marks : <?php echo $row["marks"]; ?> </h3>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-12">
												<?php
													$attempted_quiz = $row["started"];
													if( $row["started"] == 0 )
													{
														echo "<h3 style = \"color:red;padding-left:5%;\">Not Attempted.</h3>";
													}
													else
													{
														$questions = explode(",", $row["question_order"]);
														$attempted_answers = explode(",", $row["attempted_answers"]);
														$eval_attempted = $row["attempted_answers"];
														$timer = $row["remaining_time"];
														$student_answers = array();
														foreach( $attempted_answers as $value )
														{
															$qid = explode("_", $value);
															$student_answers[$qid[0]] = array();
														}
														foreach( $attempted_answers as $value )
														{
															$qid = explode("_", $value);
															$student_answers[$qid[0]][] = $qid[1];
														}
														$marks = $row["marks"];
														$num = count($questions);
														$i = 1;

														foreach( $questions as $question_id )
														{
															$query = "SELECT question, correct_answer FROM quiz_qstn_repository WHERE qstn_id=" . $question_id;
															$result = mysql_query($query);
															$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
															$question = utf8_decode($row["question"]);
															$correct_answer = utf8_decode($row["correct_answer"]);
															echo "<div id='$question_id' name='question' oncopy=\"return false;\" oncut=\"return false;\" onpaste=\"return false;\">";
															echo "<div class=\"row\">";
															echo "<div class=\"col-sm-12\">";
															echo $i . ".  " . $question;
															echo "</div>";
															echo "</div>";
															echo "<br>";
															$query = "SELECT * FROM question_option WHERE qstn_id=$question_id ORDER BY option_no";
															$result = mysql_query($query);
															while( $row = mysql_fetch_assoc($result,MYSQL_ASSOC) )
															{
																$option = utf8_decode($row["ques_option"]);
																$optionNo = utf8_decode($row["option_no"]);
																echo "<div class=\"row\">";
																echo "<div class=\"col-sm-10 col-sm-offset-1\">";
																echo $optionNo . ". " . $option;
																echo "</div>";
																echo "</div>";
															}
															echo "<br>";
															echo "<div class=\"row\">";
															echo "<div class=\"col-sm-3 col-sm-offset-1\">";
															echo "Answer: " . $correct_answer;
															echo "</div>";
															if( $student_answers[$question_id] )
															{
																$stud_ans = "";
																$c = count($student_answers[$question_id]);
																$var = 0;
																foreach( $student_answers[$question_id] as $stud )
																{
																	if( $var == $c - 1 )
																	{
																		$stud_ans = $stud_ans . $stud;
																	}
																	else
																	{
																		$stud_ans = $stud_ans . $stud . ",";
																	}
																	$var++;
																}
																if( $correct_answer == $stud_ans )
																{
																	echo "<div class=\"col-sm-6\" style = \"color:green;\">";
																	echo "Your Answer: " . $stud_ans;
																}
																else
																{
																	echo "<div class=\"col-sm-6\" style = \"color:red;\">";
																	echo "Your Answer: " . $stud_ans;
																}
															}
															else
															{
																echo "<div class=\"col-sm-6\" style = \"color:red;\">";
																echo "Not Attempted";
															}
															echo "</div>";
															echo "</div>";
															echo "</div>";
															echo "<hr>";
															$i++;
														}
													}
												?>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12">
												<?php
													if( $attempted_quiz != 0)
													{
														echo "<button class=\"btn btn-default pull-right\" onclick = \"evaluate_quiz('" . $quiz_id . "', '" . $usn . "');\">Evaluate Again</button>";
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
		<script type="text/javascript" src = "/ate/faculty/client/js/facultyViewStudAns.js"></script>
		<script type="text/javascript">
			window.onload = function ()
			{
			    var username = document.getElementById("username");
			    username.innerHTML = <?php echo  json_encode($_SESSION["username"]);  ?> + "&nbsp;<b class = \"caret\"></b>";
			}
		</script>
	</body>
</html>