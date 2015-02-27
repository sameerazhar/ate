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
		<link rel="stylesheet" type="text/css" href="/ate/bootstrap/css/bootstrap-multiselect.css">
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
							<div>
								<div class="row">
									<div class="col-lg-2 col-lg-offset-1" style="align:center"><label style="padding-top:4%;">Course Code</label></div>
									<div class="col-lg-6">
										<input type="text" autofocus placeholder = "Course Code" id = "course_code" class="form-control"/>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-2 col-lg-offset-1" style="align:center"><label style="padding-top:4%;">Course Name</label></div>
									<div class="col-lg-6">
										<input type="text" placeholder = "Course Name" id = "course_name" class="form-control"/>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-2 col-lg-offset-1" style="align:center"><label style="padding-top:4%;">Semester</label></div>
									<div class="col-lg-6">
										<input type="number" placeholder = "Semester" id = "sem" class="form-control"/>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-2 col-lg-offset-1" style="align:center"><label style="padding-top:4%;">Password</label></div>
									<div class="col-lg-6">
										<input type="password" placeholder = "Enter Password" id = "password" class="form-control"/>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-2 col-lg-offset-1" style="align:center"><label style="padding-top:4%;">Confirm Password</label></div>
									<div class="col-lg-6">
										<input type="password" placeholder = "Confirm Password" id = "cpass" class="form-control"/>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-2 col-lg-offset-1" style="align:center"><label style="padding-top:4%;">Select Languages</label></div>
									<div class="col-lg-6">
										<select id="languages" multiple="multiple">
											<option value="C">C</option>
											<option value="C++">C++</option>
											<option value="Java">Java</option>
											<option value="Python">Python</option>
										</select>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-3 col-lg-offset-3">
										<button type="button" class="btn btn-md btn-primary btn-block" onclick="create_course();">Create Course</button>
									</div>
									<div class="col-lg-3">
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
		<script type="text/javascript" src = "/ate/bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src = "/ate/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src = "/ate/bootstrap/js/bootstrap-multiselect.js"></script>
		<script type="text/javascript">
			window.onload = function ()
			{
			    var username = document.getElementById("username");
			    username.innerHTML = <?php echo  json_encode($_SESSION["username"])  ?> + "&nbsp;<b class = \"caret\"></b>";
			    $("#languages").multiselect({
            buttonText: function(options, select) {
                if (options.length === 0) {
                    return "Select Languages <b class = \"caret\"></b>";
                }
                 else {
                     labels = [];
                     options.each(function() {
                         if ($(this).attr('label') !== undefined) {
                             labels.push($(this).attr('label'));
                         }
                         else {
                             labels.push($(this).html());
                         }
                     });
                     return labels.join(', ') + ' <b class = \"caret\"></b>';
                 }
            }
        , onChange: function(option, checked, select) {
                alert('Changed option ' + $(option).val() + '.');
            }});

        
    
			}
		</script>
	</body>
</html>
