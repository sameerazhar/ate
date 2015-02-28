<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "faculty" )
	{
		header("Location: ../../index.php");
	}
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
		<div class="container" style="padding-top:4%">
			<div class = "row">
				<div class = "col-sm-12">
					<div class="panel panel-default">
						<div class = "panel-body">
							<div class = "page-header">
								<h2 style = "padding-left:5%">My Courses</h2>
							</div>
							<div class="list-group">
								<?php
									require_once "../../sql_connect.php";
									$query = "SELECT * FROM faculty_course WHERE username='" . $_SESSION["username"] . "'";
									$result = mysql_query($query);
									$num = mysql_num_rows($result);
									if( $num == 0 )
									{
										echo "<h3 style = \"color:red;padding-left:3%\">No Courses Assigned</h3>";
									}
									else
									{
										for( $var = 0; $var < $num; $var++ )
										{
											$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
											$query = "SELECT course_code, course_name FROM course WHERE course_code='" . $row["course_code"] . "'";
											$res = mysql_query($query);
											$row = mysql_fetch_assoc($res,MYSQL_ASSOC);
											echo "<a href=\"./facultyUploadLab.php?course=" . $row["course_code"] . "\" id=\"sem\"  class=\"list-group-item\">". $row["course_code"] . " - " . $row["course_name"] . "</a>";
										}
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script type="text/javascript" src = "../../bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src = "../../bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			window.onload = function ()
			{
			    var username = document.getElementById("username");
			    username.innerHTML = <?php echo  json_encode($_SESSION["username"])  ?> + "&nbsp;<b class = \"caret\"></b>";
			}
		</script>
	</body>
</html>
