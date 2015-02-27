<?php
	session_start();
	if( !isset($_SESSION["username"]) )
	{
		header("Location: /ate/ate.php");
	}
	extract($_GET);
	$usn = $_SESSION["username"];
	$course = trim($course);
	$week = trim($week);
	$que = trim($que);
	$lang = trim($lang);
	$main_file = trim($main_file);
	require_once '../../sql_connect.php';

	$query = "SELECT * FROM program WHERE usn='" . $usn . "' and course_code='" . $course . "' and assign_id='week_" . $week . "_" . $que ."'";
	$result = mysql_query($query);
	$num = mysql_num_rows($result);
	if( $num == 0 )
	{
		echo "ERROR";
		return;
	}
	$row = mysql_fetch_assoc($result,MYSQL_ASSOC);

	$cwd = getcwd();
	chdir("http://localhost/ate/python/");
	$resource = popen("python3 execute.py " . $usn . " " . $course . " week_" . $week . "_" . $que . " " . $lang . " " . $main_file , "r");
	if (is_resource($resource))
	{
		while( !feof($resource) )
		{
			echo fgets($resource);
		}
	}
	//for( $i = 0; $i < count($result); $i++ )
	{
		//echo "Compiled Successfully";
		$resource = popen("./a.out 2>&1", "r");
		if ( is_resource($resource) )
		{
			while( !feof($resource) )
			{
				echo fgets($resource);
			}
		}
	}
	chdir($cwd);
	
?>