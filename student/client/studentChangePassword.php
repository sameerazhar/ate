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
		<script type="text/javascript" src = "./js/studentChangePassword.js"></script>
	</head>
	<body style="background-color:#F0F0F0;">
		<nav class="navbar navbar-inverse navbar-static-top">
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
		

		<div class = "container">
			<div class = "row">
				<div class = "col-sm-12">
					<div class="panel panel-default">
						<div class = "panel-body">
							<div class = "page-header">
								<h2 style = "padding-left:5%">Change Password</h2>
							</div>
							<br>
							<div>
								<div class="row">
									<div class="col-sm-2 col-sm-offset-1" style="align:center"><label style="padding-top:4%;">Current Password</label></div>
									<div class="col-sm-6">
										<input type="password" autofocus placeholder = "Current Password" id = "old_password" class="form-control"/>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-sm-2 col-sm-offset-1" style="align:center"><label style="padding-top:4%;">New Password</label></div>
									<div class="col-sm-6">
										<input type="password" placeholder = "New Password" id = "new_password" class="form-control"/>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-sm-2 col-sm-offset-1" style="align:center"><label style="padding-top:4%;">Confirm Password</label></div>
									<div class="col-sm-6">
										<input type="password" placeholder = "Confirm Password" id = "confirm_password" class="form-control"/>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-sm-6 col-sm-offset-3" id="error_msg" style="color:red;"></div>
								</div>
								<br>
								<div class="row">
									<div class="col-sm-3 col-sm-offset-3">
										<button type="button" class="btn btn-md btn-primary btn-block" onclick="update_password();">Submit</button>
									</div>
									<div class="col-sm-3">
										<button type="button" class="btn btn-md btn-primary btn-block" onclick="cancel();">Cancel</button>
									</div>
								</div>
								<br>
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
