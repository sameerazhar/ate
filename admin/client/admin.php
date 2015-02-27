<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "admin" )
	{
		header("Location: /ate/index.php");
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="/ate/bootstrap/css/bootstrap.min.css">
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-static-top">
	    	<div class="container">
		        <div class="navbar-header">
		        	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			            <span class="sr-only">Toggle navigation</span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
		        	</button>
		        	<div class="navbar-brand" style="color:white">PES University - Department of Computer Science</div>
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
		        	<ul class="nav navbar-nav  navbar-right">
		            	<li class=" active"><a href="#" style="color:white">Courses</a></li>
		            	<li><a href="#" style="color:white">Students</a></li>
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
		

		<div class = "container">
			<div class = "row">
				<div class = "col-lg-12">
					<div class="panel panel-default">
						<div class = "panel-body">
							<div class = "page-header">
								<h2 style = "padding-left:5%">Courses</h2>
							</div>
							<br>
							<div class = "list-group">
								<?php
									require_once "../../sql_connect.php";
									$query = "SELECT * FROM course";
									$result = mysql_query($query);
									$num = mysql_num_rows($result);
									if( $num == 0 )
									{
										echo "<h3 style = \"color:red;padding-left:3%\">No Courses</h3>";
									}
									else
									{
										for ( $var = 0;  $var < $num; $var++ )
										{
											$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
								?>
											<a href="#" class="list-group-item"><?php echo $row["course_code"] . " - " . $row["course_name"]; ?> </a>
								<?php
										}
									}
								?>
							</div>

							<div class="container">
								<div class="row">
									<div class="col-lg-5 col-lg-offset-1">
										<center><a href = "/ate/admin/client/adminCreateCourse.php" class = "btn btn-primary">Create New Course</a></center>
									</div>
									<div class="col-lg-5">
										<center><button class = "btn btn-danger">Delete a Course</button></center>
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
			    username.innerHTML = <?php echo  json_encode($_SESSION["username"])  ?> + "&nbsp;<b class = \"caret\"></b>";
			}
		</script>
	</body>
</html>
