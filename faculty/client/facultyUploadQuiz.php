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
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
		<script type="text/javascript" src = "/ate/faculty/client/js/facultyUploadQuiz.js"></script>
		<meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
														<li><a href=<?php echo "/ate/faculty/client/facultyQuizzes.php?course=" . $course_code; ?> >Quizzes</a></li>
														<li class="active"><a href=<?php echo "/ate/faculty/client/facultyUploadQuiz.php?course=" . $course_code; ?> >Create new Quiz</a></li>	
													</ul>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-sm-2">
													<label style="padding-left:2%;padding-top:5%;">Quiz Name</label>
												</div>
												<div class="col-sm-10">
													<input type="text" autofocus placeholder="Quiz Name" class="form-control" id="quiz_name" />
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-sm-2">
													<label style="padding-left:2%;padding-top:5%;">Enter topic</label>
												</div>
												<div class="col-sm-10">
														<input type="text" id="qstn_summary" class="form-control" placeholder = "Enter topic" autocomplete="off" data-provide="typeahead" data-items="20"/>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-sm-2">
													<label style="padding-left:2%;padding-top:5%;">Easy</label>
												</div>
												<div class="col-sm-2">
													<input type="number" class="form-control" min="0" max="100" id="easy" value="0">
												</div>
												<div class="col-sm-2">
													<label style="padding-left:2%;padding-top:5%;">Medium</label>
												</div>
												<div class="col-sm-2">
													<input type="number" class="form-control" min="0" max="100" id="med" value="0">
												</div>
												<div class="col-sm-2">
													<label style="padding-left:2%;padding-top:5%;">Difficult</label>
												</div>
												<div class="col-sm-2">
													<input type="number" class="form-control" min="0" max="100" id="hard" value="0">
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-sm-2">
													<label style="padding-left:2%;padding-top:5%;">Time Period</label>
												</div>
												<div class="col-sm-4">
													<input type = "number" min = "1" placeholder = "Time period in minutes" class="form-control" id = "time_period" />
												</div>
												<div class="col-sm-2">
													<div class="checkbox"><label><input type = "checkbox" id = "enabled" value="disbled" /> Enable</label></div>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-sm-2">
													<button class="btn btn-primary btn-block" onclick = <?php echo "generate_quiz('" . $course_code . "');" ?> >Generate quiz</button>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-sm-12">
													<span  id = "msg"></span>
												</div>
											</div>
											<hr style="height:2px">
											<div class="row">
												<div class="col-sm-12">
													<label>Upload Quiz File (Only .xls, .xlsx or .ods format)</label>
												</div>
											</div>
											
											<div class="row">
												<div class="col-sm-6">
													<div style="border: 1px solid;"><input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel" name="quiz" id="quiz"/></div>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-sm-2">
													<input type="button" class="btn btn-primary btn-block" value="Upload file" onclick=<?php echo "upload_file('". $course_code . "')" ?> />
												</div>
												
											</div>
											<br>
											<div class="row">
												<div id = "col-sm-12">
													<span id="status" style = "padding-left:2%"></span>
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
		<script type="text/javascript" src="/ate/bootstrap/js/bootstrap3-typeahead.js"></script>
		<script type="text/javascript">
			window.onload = function ()
			{
			    var username = document.getElementById("username");
			    username.innerHTML = <?php echo  json_encode($_SESSION["username"]);  ?> + "&nbsp;<b class = \"caret\"></b>";
			    
			}
			$(document).ready(function() {
			course_code = <?php echo "'$course_code'"; ?>;
            $("#qstn_summary").typeahead({
                source: function(query, process) {
                    $.ajax({
                        url: '/ate/faculty/server/facultyGetTopicQuiz.php',
                        type: 'POST',
                        data: 'qstn_summary=' + query + "&course=" + course_code,
                        dataType: 'JSON',
                        minlength:0,
                        items:1000,
                        async: true,
                        success: function(data) {
                            process(data);
                        }
                    });
                }
            });
           
        });
		</script>
	</body>
</html>
