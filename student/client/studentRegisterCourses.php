<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "student" )
	{
		header("Location: ../../index.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../../bootstrap/css/mynav.css">
		<script type="text/javascript" src = "./js/studentRegisterCourses.js"></script>
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
								<h2 style = "padding-left:5%">Register Courses</h2>
							</div>
							<br>
							
							<?php
								require_once '../../sql_connect.php';
								$query = "SELECT sem FROM student WHERE usn='" . $_SESSION["username"] . "'";
								$result = mysql_query($query);
								$num = mysql_num_rows($result);
								if( $num == 0 )
								{
									echo "<h3 style = \"color:red;padding-left:3%\">Some error occured, try after some time.</h3>";
								}
								else
								{
									$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
									$query = "SELECT course_code, course_name FROM course WHERE sem='" . $row["sem"] . "'";
									$result = mysql_query($query);
									$num = mysql_num_rows($result);
									if( $num == 0 )
									{
										echo "<h3 style = \"color:red;padding-left:3%\">Some error occured, try after some time.</h3>";
									}
									else
									{
										for( $i = 0; $i < $num; $i++ )
										{
							?>
											<div class="row">
											<div class="col-sm-11 col-sm-offset-1">
							
							<?php
											$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
											echo "<div class=\"checkbox\">";
											echo "<label>";
											echo "<input type=\"checkbox\" checked value=\"" . $row["course_code"] . "\">" . $row["course_code"] . " - " . $row["course_name"];
											echo "</label>";
											echo "</div>";
							?>
											</div>
											</div>
							<?php
										}
									}
								}
							?>
								<br>
								<div class="row">
									<div class="col-sm-2 col-sm-offset-1">
										<button class = "btn btn-primary btn-block" onclick="register();">Register</button>
									</div>
									<div class="col-sm-2">
										<a href="./student.php" class = "btn btn-primary btn-block">Cancel</a>
									</div>
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
