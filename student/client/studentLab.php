<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "student" )
	{
		header("Location: /ate/index.php");
	}
	extract($_GET);
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
		        	
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
		        	<ul class="nav navbar-nav  navbar-right">
		            	<li><a href="#" style="color:white">Home</a></li>
						<li class = "dropdown active">
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
								<?php
									require_once "../../sql_connect.php";
									$query = "SELECT course_name FROM course WHERE course_code='" . $course . "'";
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
										echo $row["course_name"] . " - " . $course;
									}
									echo "</h2>";
								?>
							</div>
							<br>
							<div>
								<ul class="nav nav-tabs">
									<li class="active"><a href="<?php echo "/ate/student/client/studentLab.php?course=" . $course?>">Lab Assignments</a></li>
									<li><a href="#">Assignments</a></li>
									<li><a href="#">Exams</a></li>
									<li><a href="<?php echo "/ate/student/client/studentQuiz.php?course=" . $course?>">Quiz</a></li>
									
								</ul>
							</div>
							<br>
							<br>
							<div>
								<div class="list-group">
									<?php
										$query = "SELECT assign_id FROM assignment WHERE course_code='" . $course . "'";
										$result = mysql_query($query);
										$num = mysql_num_rows($result);
										if( $num == 0 )
										{
											echo "<h3 style = \"color:red;padding-left:5%\">No Lab Assignments</h3>";
										}
										else
										{
											$week_no = array();
											$assign_no = array();
											$i = 0;
											for( $var = 0; $var < $num; $var++ )
											{
												$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
												if( strncasecmp("Week_", $row["assign_id"], 5) == 0 )
												{
													$week = explode("_", $row["assign_id"]);
													$week_no[$i] = $week[1];
													$assign_no[$i] = $week[2];
													$i++;
												}
											}

											$week_no = array_unique($week_no);
											sort($week_no);
											$len = sizeof($week_no);
											for( $var = 0; $var < $len; $var++ )
											{
												echo "<a class=\"list-group-item\" href=\"javascript:get_que('" . $week_no[$var] . "','" . $course . "')\">Week - " . $week_no[$var] . "</a>";
												?>
												<div style="display:none;" class = <?php echo "class_que".$week_no[$var]; ?> id = <?php echo "que".$week_no[$var]; ?> >
												</div>
												<?php
											}
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src = "/ate/bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src = "/ate/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src = "/ate/student/client/js/studentLab.js"></script>
		<script type="text/javascript">
			window.onload = function ()
			{
			    var username = document.getElementById("username");
			    username.innerHTML = <?php echo  json_encode($_SESSION["username"])  ?> + "&nbsp;<b class = \"caret\"></b>";
			}
		</script>
	</body>
</html>
