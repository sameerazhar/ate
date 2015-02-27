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
		<style type="text/css">
			textarea
			{
				font-size: 20px;
			}
		</style>
		<script language="Javascript" type="text/javascript" src="/ate/edit_area/edit_area_full.js"></script>
		<script type="text/javascript" src = "/ate/student/client/js/studentAttemptLab.js"></script>
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
		            	<li><a href="#" style="color:white"><span class="glyphicon glyphicon-home"></span> &nbsp;&nbsp;Home</a></li>
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
							
							
							
							<div class="row">
								<div class="col-sm-12">
									<h4 id = "week_no" style = "padding-left:3%">Week - <?php echo $week; ?> &nbsp;&nbsp; Program - <?php echo $que; ?></h4>
								</div>
							</div>
							<hr>
							

							<div class="row">
								<div class="col-sm-12">
									<?php
										$query = "SELECT que_path FROM assignment WHERE assign_id='week_" . $week . "_" . $que . "' and course_code='" . $course . "'";
										$result = mysql_query($query);
										$num = mysql_num_rows($result);
										if( $num == 0 )
										{
											echo "<h3 style = \"color:red;padding-left:5%\">Server Error</h3>";
										}
										else
										{
											$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
											$question = file_get_contents( "http://localhost" . $row['que_path']);
											echo "<div style = \"padding-left:3%;padding-right:3%\">" . $question . "</div>";
										}
									?>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<?php
										$assign_id = "week_" . $week . "_" . $que;
										$query = "SELECT * FROM test_case WHERE assign_id='" . $assign_id . "' and course_code='" . $course . "'";
										$result = mysql_query($query);
										$num = mysql_num_rows($result);
										if( $num != 0 )
										{
											$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
											echo "<br>";
											if( $row["input"] != "" )
											{
												$input = str_replace("\n","<br>",$row["input"]);
												$input = str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;",$input);
												echo "<div style = \"padding-left:3%;padding-right:3%\"><strong>Input : </strong><br>";
												echo $input;
												echo "</div>";
											}
											if( $row["output"] != "" )
											{
												echo "<br>";
												$output = str_replace("\n","<br>",$row["output"]);
												$output = str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;",$output);
												echo "<div style = \"padding-left:3%;padding-right:3%\"><strong>Output : </strong><br>";
												echo $output;
												echo "</div>";
											}
										}
										
										$query = "SELECT language FROM course WHERE course_code='" . $course ."'";
										$result = mysql_query($query);
										$num = mysql_num_rows($result);
										if( $num == 0 )
										{
											echo "<h3 style = \"color:red;padding-left:5%\">No Language Specified</h3>";
										}
										else
										{

									?>
											<br>
											<div class="row" style="padding-left:3%;padding-right:3%">
												<div class="col-sm-2">
													<select class="form-control" onchange="select_lang();" id = "lang">
													<?php
														$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
														$lang = explode(";", $row["language"]);
														echo "<script type=\"text/javascript\">set_data('" . $lang[0] . "', '" . $week . "', '" . $course . "', '" . $que . " ')</script>";
														for( $var  = 0; $var < sizeof($lang) - 1; $var++ )
														{
															echo "<option>" . $lang[$var] . "</option>";
														}
													?>
													</select>
												</div>
												<div class="col-sm-2">
													<button class="btn btn-md btn-info" onclick="create_file();">Create New File</button>
												</div>
												<div class="col-sm-2">
													<button class="btn btn-md btn-danger" onclick="delete_file();">Delete File</button>
												</div>
											</div>
											<br>
											<div class="row" style="padding-left:3%;padding-right:3%">
												<div class="col-sm-12">
													<ul class="nav nav-tabs" id = "filetabs"></ul>
													<br>
													<div id="tabContent" class="tab-content">
													</div>
												</div>
											</div>
											<br>
											<div class="row" style="padding-left:3%;padding-right:3%">
												<div class="col-sm-12">
													<label style="padding-left:3%;">Select files for execution</label>
												</div>
											</div>
											
											<div class="row" style="padding-left:3%;padding-right:3%">
												<div class="col-sm-12" id = "comp_files">
												</div>
											</div>
											<br>
											<div class="row" style="padding-left:3%;padding-right:3%">
												<div class="col-sm-3">
													<input type = "text" placeholder = "Enter file name with main function" id = "main_file" class="form-control" />
												</div>
												<div class="col-sm-2">
													<button class="btn btn-primary btn-block" onclick="execute();">Execute</button>
												</div>
												<div class="col-sm-2">
													<button class="btn btn-success btn-block">Submit</button>
												</div>
											</div>
											<br>
											<div class="row" style="padding-left:3%;padding-right:3%">
												<div class="col-sm-3">
													<input type = "number" placeholder = "Enter minimum number of tokens" id = "num_tokens" class="form-control" />
												</div>
												<div class="col-sm-2">
													<button class="btn btn-primary btn-block" onclick="repeated_code();">Find Repeated Code</button>
												</div>
											</div>
											<br>
											<div class="row" style="padding-left:3%;padding-right:3%">
								
												<div class="col-sm-12" id = "cmd">
													
												</div>
											</div>
											<br>
											<div class="row" style="padding-left:3%;padding-right:3%">
												<div class="col-sm-12">
													<div class="panel panel-default" style="display:none;" id = "output_window">
														<div class="panel-body">
															<div class="page-header" style="padding-left:5%;padding-right:5%;">
																<h3 id = "heading">Output:</h3>
															</div>
															<div class="row" style="padding-left:3%;padding-right:3%;">
																<div class="col-sm-12" id = "output"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
									<?php
										}
									?>
								</div>
							</div>
							<br><br><br>
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
			    
				fetch_files();
			}
		</script>
	</body>
</html>
